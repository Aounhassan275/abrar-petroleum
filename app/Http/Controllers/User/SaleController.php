<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DebitCredit;
use App\Models\DebitCreditAccount;
use App\Models\Dip;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $diesel = Product::where('name','HSD')->first();
        $petrol = Product::where('name','PMG')->first();
        $sale_date = Sale::orderBy('sale_date','DESC')->first()->sale_date;
        if($request->date)
        {
            $sale_date->addDay();    
            if(Carbon::parse($request->date)->gt($sale_date))
            {
                toastr()->error('Not Allowed');
                $date =  $sale_date;
                $day_before = Sale::all()->last()->sale_date;
            }else{
                $date =  Carbon::parse($request->date);
                $day_before =  Carbon::parse($request->date)->subDay();
            }
        }else{
            $date =  $sale_date->addDay();
            $day_before = Sale::all()->last()->sale_date;
        }
        $newDateForLastDay = $newDateForNextDay = $date; 
        $active_tab = $request->active_tab?$request->active_tab:'diesel';
        $previousUrl = route('user.sale.index').'?active_tab='.$active_tab.'&date='.$newDateForLastDay->subDay(1)->format('Y-m-d');
        $nextUrl = route('user.sale.index').'?active_tab='.$active_tab.'&date='.$newDateForNextDay->addDay(1)->format('Y-m-d');
        $accounts = DebitCreditAccount::query()
                // leftJoin('debit_credits', 'debit_credit_accounts.id', '=', 'debit_credits.account_id')
                // ->select('debit_credit_accounts.*', DB::raw('COUNT(debit_credits.account_id) as accounts'))
                ->select('debit_credit_accounts.*')
                ->where('debit_credit_accounts.user_id', Auth::user()->id)
                ->orWhereNull('debit_credit_accounts.user_id')
                ->orderBy('debit_credit_accounts.account_category_id', 'ASC')
                // ->where('debit_credit_accounts.is_hide', 0)
                ->get();
        $cash_account_id = DebitCreditAccount::where('name','Cash in Hand')->first()->id;
        $lastDayCash = DebitCredit::where('account_id',$cash_account_id)->whereDate('sale_date',$day_before)->where('user_id',Auth::user()->id)->first();
        $missing_debit_credits = DebitCredit::whereNull('account_id')->where('user_id',Auth::user()->id)->get();
        $products = Product::whereNull('supplier_id')->where('user_id',Auth::user()->id)->orWhereNull('user_id')->get();
        $salaryAccounts = DebitCreditAccount::where('user_id',Auth::user()->id)->where('account_category_id',4)->where('salary','>',0)->get();
        return view('user.sale.create',compact(
            'petrol','diesel','date','active_tab',
            'accounts','products','cash_account_id',
            'lastDayCash','missing_debit_credits',
            'previousUrl','nextUrl','salaryAccounts'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $diesel = Product::where('name','HSD')->first();
        $petrol = Product::where('name','PMG')->first();
        $date = Carbon::today();
        return view('user.sale.create',compact('petrol','diesel','date'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            if($request->current_reading)
            {
                $product = Product::find($request->product_id);
                if($request->testing == true)
                {
                    // if($request->testing_quantity > $product->availableStock())
                    // {
                    //     toastr()->error('Stock is not avaiable');
                        
                    //     if($product->name == 'PMG')
                    //     {
                    //         return redirect()->to(route('user.sale.index').'?active_tab=petrol&date='.$request->sale_date);
                    //     }else{
                    //         return redirect()->to(route('user.sale.index').'?active_tab=diesel&date='.$request->sale_date);
                    //     }
                    // }
                    $total = $product->selling_amount * $request->testing_quantity;
                    Sale::create([
                        'user_id' => Auth::user()->id,
                        'product_id' => $request->product_id,
                        'price' => $product->selling_amount,
                        'total_amount' => $total,
                        'type' => 'test',
                        'sale_date' => $request->sale_date,
                        'qty' => $request->testing_quantity,
                    ]);

                }
                foreach($request->current_reading as $key => $current_reading)
                {
                    if($current_reading)
                    {
                        if($request->qty[$key] > $product->availableStock())
                        {
                            toastr()->error('Stock is not avaiable');
                            if($product->name == 'PMG')
                            {
                                return redirect()->to(route('user.sale.index').'?active_tab=petrol&date='.$request->sale_date);
                            }else{
                                return redirect()->to(route('user.sale.index').'?active_tab=diesel&date='.$request->sale_date);
                            }
                        }
                        $sale = Sale::create([
                            'user_id' => Auth::user()->id,
                            'product_id' => $request->product_id,
                            'machine_id' => $request->machine_id[$key],
                            'price' => $request->price[$key],
                            'total_amount' => $request->total_amount[$key],
                            'type' => $request->type[$key],
                            'previous_reading' => $request->previous_reading[$key],
                            'current_reading' => $current_reading,
                            'sale_date' => $request->sale_date,
                            'qty' => $request->qty[$key],
                        ]);
                        $sale->machine->update(['meter_reading'=>$sale->current_reading]);
                    
                    }
                }
                if($request->whole_sale == true)
                {
                    if($request->wholesale_quantity > $product->availableStock())
                    {
                        toastr()->error('Stock is not avaiable');
                        if($product->name == 'PMG')
                        {
                            return redirect()->to(route('user.sale.index').'?active_tab=petrol&date='.$request->sale_date);
                        }else{
                            return redirect()->to(route('user.sale.index').'?active_tab=diesel&date='.$request->sale_date);
                        }                    }
                    Sale::create([
                        'user_id' => Auth::user()->id,
                        'product_id' => $request->product_id,
                        'price' => $request->wholesale_price,
                        'total_amount' => $request->wholesale_total_amount,
                        'type' => 'whole_sale',
                        'sale_date' => $request->sale_date,
                        'qty' => $request->wholesale_quantity,
                    ]);
                }
                if($request->dip)
                {
                    Dip::create([
                        'user_id' => Auth::user()->id,
                        'product_id' => $request->product_id,
                        'access' => $request->dip,
                        'date' => $request->sale_date,
                    ]);
                }   
                foreach($request->day_and_night_sale as $index => $day_and_night_sale)
                {
                    if($day_and_night_sale > 0)
                    {
                        if($request->sale_detail_id && $request->sale_detail_id[$index])
                        {
                            $saleDetail = SaleDetail::find($request->sale_detail_id[$index]);
                            $saleDetail->update([
                                'supply_sale' => $request->supply_sale[$index],
                                'retail_sale' => $request->retail_sale[$index],
                                'type' => $request->sale_type[$index],
                                'total_sale' => $day_and_night_sale,
                                'product_id' => $request->product_id,
                            ]);
                        }else{
                            SaleDetail::create([
                                'user_id' => Auth::user()->id,
                                'sale_date' => Carbon::parse($request->sale_date),
                                'supply_sale' => $request->supply_sale[$index],
                                'retail_sale' => $request->retail_sale[$index],
                                'type' => $request->sale_type[$index],
                                'total_sale' => $day_and_night_sale,
                                'product_id' => $request->product_id,
                            ]);
                        }
                    }
                }
                $this->manageSale($request->sale_date);
                toastr()->success('Sale is Created Successfully');
                if($product->name == 'PMG')
                {
                    return redirect()->to(route('user.sale.index').'?active_tab=misc&date='.$request->sale_date);
                }else{
                    return redirect()->to(route('user.sale.index').'?active_tab=petrol&date='.$request->sale_date);
                }  
            }elseif($request->is_misc_sale){
                foreach($request->qty as $key => $qty)
                {
                    if($qty)
                    {
                        $product = Product::find($request->product_id[$key]);
                        if($qty > $product->availableStock())
                        {
                            toastr()->error('Stock is not avaiable');
                            return redirect()->to(route('user.sale.index').'?active_tab=misc&date='.$request->sale_date);
                        }
                        $sale = Sale::create([
                            'user_id' => Auth::user()->id,
                            'product_id' => $request->product_id[$key],
                            'price' => $request->price[$key],
                            'total_amount' => $request->total_amount[$key],
                            'type' => 'misc_sale',
                            'qty' => $qty,
                            'sale_date' => $request->sale_date,
                        ]);}
                }
                $this->manageSale($request->sale_date);
                toastr()->success('Sale is Created Successfully');
                return redirect()->to(route('user.sale.index').'?active_tab=sale_detail&date='.$request->sale_date);
            }else{
                $sale = Sale::create($request->all());    
                if($sale->machine)
                {
                    $sale->machine->update(['meter_reading'=>$sale->current_reading]);
                }
                toastr()->success('Sale is Created Successfully');
                return back();
            }
        }catch(Exception $e)
        {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sale = Sale::find($id);
        return view('user.sale.edit',compact('sale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try{
            if($request->current_reading)
            {
                $product = Product::find($request->product_id);
                if($request->testing == true)
                {
                    if($request->testing_sale_id)
                    {
                        $sale = Sale::find($request->testing_sale_id);      
                        $total_qty = $request->testing_quantity - $sale->qty;                  
                        // if($total_qty > $product->availableStock())
                        // {
                        //     toastr()->error('Stock is not avaiable');  
                        //     if($product->name == 'PMG')
                        //     {
                        //         return redirect()->to(route('user.sale.index').'?active_tab=petrol&date='.$request->sale_date);
                        //     }else{
                        //         return redirect()->to(route('user.sale.index').'?active_tab=diesel&date='.$request->sale_date);
                        //     }  
                        // }
                        $total = $product->selling_amount * $request->testing_quantity;
                        $sale->update([
                            'price' => $product->selling_amount,
                            'total_amount' => $total,
                            'qty' => $request->testing_quantity,
                        ]);
                    }else{
                                          
                        // if($request->testing_quantity > $product->availableStock())
                        // {
                        //     toastr()->error('Stock is not avaiable');  
                        //     if($product->name == 'PMG')
                        //     {
                        //         return redirect()->to(route('user.sale.index').'?active_tab=petrol&date='.$request->sale_date);
                        //     }else{
                        //         return redirect()->to(route('user.sale.index').'?active_tab=diesel&date='.$request->sale_date);
                        //     }  
                        // }
                        $total = $product->selling_amount * $request->testing_quantity;
                        Sale::create([
                            'user_id' => Auth::user()->id,
                            'product_id' => $request->product_id,
                            'price' => $product->selling_amount,
                            'total_amount' => $total,
                            'type' => 'test',
                            'sale_date' => $request->sale_date,
                            'qty' => $request->testing_quantity,
                        ]);

                    }
                }
                foreach($request->current_reading as $key => $current_reading)
                {
                    if($current_reading)
                    {
                        if($request->sale_id[$key])
                        {
                            $sale = Sale::find($request->sale_id[$key]);
                            $total_qty = $request->qty[$key] - $sale->qty;
                            if($total_qty > $product->availableStock())
                            {
                                toastr()->error('Stock is not avaiable');  
                                if($product->name == 'PMG')
                                {
                                    return redirect()->to(route('user.sale.index').'?active_tab=petrol&date='.$request->sale_date);
                                }else{
                                    return redirect()->to(route('user.sale.index').'?active_tab=diesel&date='.$request->sale_date);
                                }  
                            }
                            $sale->update([
                                'price' => $request->price[$key],
                                'total_amount' => $request->total_amount[$key],
                                'previous_reading' => $request->previous_reading[$key],
                                'current_reading' => $current_reading,
                                'sale_date' => $request->sale_date,
                                'qty' => $request->qty[$key],
                            ]);
                            $sale->machine->update(['meter_reading'=>$sale->current_reading]);
                        }else{
                            if($request->qty[$key] > $product->availableStock())
                            {
                                toastr()->error('Stock is not avaiable');  
                                if($product->name == 'PMG')
                                {
                                    return redirect()->to(route('user.sale.index').'?active_tab=petrol&date='.$request->sale_date);
                                }else{
                                    return redirect()->to(route('user.sale.index').'?active_tab=diesel&date='.$request->sale_date);
                                }  
                            }
                            $sale = Sale::create([
                                'user_id' => Auth::user()->id,
                                'product_id' => $request->product_id,
                                'machine_id' => $request->machine_id[$key],
                                'price' => $request->price[$key],
                                'total_amount' => $request->total_amount[$key],
                                'type' => $request->type[$key],
                                'previous_reading' => $request->previous_reading[$key],
                                'current_reading' => $current_reading,
                                'sale_date' => $request->sale_date,
                                'qty' => $request->qty[$key],
                            ]);
                            $sale->machine->update(['meter_reading'=>$sale->current_reading]);
                        }
                    }
                }
                if($request->whole_sale == true)
                {
                    if($request->whole_sale_id)
                    {
                        $sale = Sale::find($request->whole_sale_id);
                        $total_qty = $request->wholesale_quantity - $sale->qty;                  
                        if($total_qty > $product->availableStock())
                        {
                            toastr()->error('Stock is not avaiable');  
                            if($product->name == 'PMG')
                            {
                                return redirect()->to(route('user.sale.index').'?active_tab=petrol&date='.$request->sale_date);
                            }else{
                                return redirect()->to(route('user.sale.index').'?active_tab=diesel&date='.$request->sale_date);
                            }  
                        }
                        $total = $product->selling_amount * $request->testing_quantity;
                        $sale->update([
                            'price' => $request->wholesale_price,
                            'total_amount' => $request->wholesale_total_amount,
                            'qty' => $request->wholesale_quantity,
                        ]);
                    }else{               
                        if($request->wholesale_quantity > $product->availableStock())
                        {
                            toastr()->error('Stock is not avaiable');  
                            if($product->name == 'PMG')
                            {
                                return redirect()->to(route('user.sale.index').'?active_tab=petrol&date='.$request->sale_date);
                            }else{
                                return redirect()->to(route('user.sale.index').'?active_tab=diesel&date='.$request->sale_date);
                            }  
                        }
                        Sale::create([
                            'user_id' => Auth::user()->id,
                            'product_id' => $request->product_id,
                            'price' => $request->wholesale_price,
                            'total_amount' => $request->wholesale_total_amount,
                            'type' => 'whole_sale',
                            'sale_date' => $request->sale_date,
                            'qty' => $request->wholesale_quantity,
                        ]);
                    }

                }
                
                if($request->dip)
                {
                    if($request->dip_id)
                    {
                        $dip = Dip::find($request->dip);
                        $dip->update([
                            'access' => $request->dip,
                        ]);
                    }else{
                        Dip::create([
                            'user_id' => Auth::user()->id,
                            'product_id' => $request->product_id,
                            'access' => $request->dip,
                            'date' => $request->sale_date,
                        ]);
                    }
                }  
                foreach($request->day_and_night_sale as $index => $day_and_night_sale)
                {
                    if($day_and_night_sale > 0)
                    {
                        if($request->sale_detail_id && $request->sale_detail_id[$index])
                        {
                            $saleDetail = SaleDetail::find($request->sale_detail_id[$index]);
                            $saleDetail->update([
                                'supply_sale' => $request->supply_sale[$index],
                                'retail_sale' => $request->retail_sale[$index],
                                'type' => $request->sale_type[$index],
                                'total_sale' => $day_and_night_sale,
                                'product_id' => $request->product_id,
                            ]);
                        }else{
                            SaleDetail::create([
                                'user_id' => Auth::user()->id,
                                'sale_date' => Carbon::parse($request->sale_date),
                                'supply_sale' => $request->supply_sale[$index],
                                'retail_sale' => $request->retail_sale[$index],
                                'type' => $request->sale_type[$index],
                                'total_sale' => $day_and_night_sale,
                                'product_id' => $request->product_id,
                            ]);
                        }
                    }
                }
                $this->manageSale($request->sale_date);
                toastr()->success('Sale is Created Successfully');
                if($product->name == 'PMG')
                {
                    return redirect()->to(route('user.sale.index').'?active_tab=misc&date='.$request->sale_date);
                }else{
                    return redirect()->to(route('user.sale.index').'?active_tab=petrol&date='.$request->sale_date);
                }  
            }elseif($request->is_misc_sale){
                
                foreach($request->qty as $key => $qty)
                {
                    if($qty)
                    {
                        if($request->sale_id[$key])
                        {
                            $sale = Sale::find($request->sale_id[$key]);
                            $product = Product::find($request->product_id[$key]);
                            $total_qty = $qty - $sale->qty;
                            if($total_qty > $product->availableStock())
                            {
                                toastr()->error('Stock is not avaiable');  
                                return redirect()->to(route('user.sale.index').'?active_tab=misc&date='.$request->sale_date);              
                            }
                            $sale->update([
                                'price' => $request->price[$key],
                                'total_amount' => $request->total_amount[$key],
                                'qty' => $qty,
                            ]);
                        }else{  
                            $product = Product::find($request->product_id[$key]);
                            if($qty > $product->availableStock())
                            {
                                toastr()->error('Stock is not avaiable');
                                return redirect()->to(route('user.sale.index').'?active_tab=misc&date='.$request->sale_date);              
                            }
                            $sale = Sale::create([
                                'user_id' => Auth::user()->id,
                                'product_id' => $request->product_id[$key],
                                'price' => $request->price[$key],
                                'total_amount' => $request->total_amount[$key],
                                'type' => 'misc_sale',
                                'qty' => $qty,
                                'sale_date' => $request->sale_date,
                            ]);
                        }
                    }
                }
                toastr()->success('Sale is Created Successfully');
                return redirect()->to(route('user.sale.index').'?active_tab=sale_detail&date='.$request->sale_date);
            }else{
                $sale = Sale::find($id);
                $sale->update($request->all());
                if($sale->machine)
                {
                    $sale->machine->update(['meter_reading'=>$sale->current_reading]);
                }
            }
            toastr()->success('Sale is Created Successfully');
            return redirect()->to(route('user.sale.index'));
        }catch(Exception $e)
        {
            toastr()->error($e->getMessage());
            return back();
        }
        toastr()->success('Sale Informations Updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale = Sale::find($id);
        $sale->delete();
        toastr()->success('Sale Deleted successfully');
        return redirect()->back();
    }
    public function getSaleDetails(Request $request)
    {
        $diesel = Product::where('name','HSD')->first();
        $petrol = Product::where('name','PMG')->first();
        $date = Carbon::parse($request->date);
        $html = view('user.sale.partials.sale_detail', compact('petrol','diesel','date'))->render();;
        return response([
            'html' => $html,
        ], 200);
    }
    public function deleteSale(Request $request)
    {
        if($request->delete_diesel_product_id)
        {
            $product = Product::find($request->delete_diesel_product_id);
        }else{
            $product = Product::find($request->delete_petrol_product_id);
        }
        $date = $request->delete_petrol_date?$request->delete_petrol_date:$request->delete_diesel_date;
        $sales = Sale::where('user_id',Auth::user()->id)->where('sale_date',$date)
                        ->where('product_id',$product->id)->get();
        foreach($sales as $sale)
        {
            if($sale->type == "retail_sale")
            {
                $sale->machine->update(['meter_reading'=>$sale->previous_reading]);
            }
            if($sale->type != "test")
            {
                $debit_credit = DebitCredit::where('account_id','42')->where('user_id',Auth::user()->id)->where('sale_date',$date)->first();
                if($debit_credit)
                {
                    $debit_credit->update([
                        'credit' => $debit_credit->credit -= $sale->total_amount
                    ]);
                }

            }
            $sale->delete();
        }
        toastr()->success('Sale Deleted successfully');
        return response([
            'success' => true,
        ], 200);
    }
    public function deleteSaleForMisc(Request $request)
    {
        $sale = Sale::find($request->id);
        if($sale->type != "test")
        {
            $debit_credit = DebitCredit::where('account_id','42')->where('user_id',Auth::user()->id)->where('sale_date',$sale->sale_date)->first();
            if($debit_credit)
            {
                $debit_credit->update([
                    'credit' => $debit_credit->credit -= $sale->total_amount
                ]);
            }
        }
        $sale->delete();
        toastr()->success('Sale Deleted successfully');
        return response([
            'success' => true,
        ], 200);
    }
    public function updateSaleRate(Request $request)
    {
        foreach($request->change_product_id  as $key => $change_product_id)
        {
            $product = Product::find($change_product_id);
            if($product->user_id)
            {
                $sales = Sale::where('user_id',Auth::user()->id)->whereDate('sale_date',$request->change_rate_date)
                ->where('product_id',$product->id)->where('type','misc_sale')->get();

            }else{
                $sales = Sale::where('user_id',Auth::user()->id)->whereDate('sale_date',$request->change_rate_date)
                ->where('product_id',$product->id)->where('type',['retail_sale','test'])->get();
            }
            foreach($sales as $sale)
            {
                $sale->update([
                    'price' => $request->change_sale_rate[$key],
                    'total_amount' => $request->change_sale_rate[$key] * $sale->qty,
                ]);
            }
        }
        $debit_credit = DebitCredit::where('account_id','42')->where('user_id',Auth::user()->id)->where('sale_date',$request->change_rate_date)->first();
        $new_sale_amount = round(Auth::user()->todaySaleAmount($request->change_rate_date));
        if($debit_credit)
        {
            $debit_credit->update([
                'credit' => $new_sale_amount
            ]);
        }
        toastr()->success('Sale Updated successfully');
        return response([
            'date' => $request->change_rate_date,
            'success' => true,
        ], 200);
    }
    public function manageSale($date)
    {
        $date = Carbon::parse($date);
        $debit_credit = DebitCredit::where('account_id','42')->where('user_id',Auth::user()->id)->whereDate('sale_date',$date)->first();
        $new_sale_amount = round(Auth::user()->todaySaleAmount($date));
        if($debit_credit)
        {
            $debit_credit->update([
                'credit' => $new_sale_amount
            ]);
        }
    }
}
