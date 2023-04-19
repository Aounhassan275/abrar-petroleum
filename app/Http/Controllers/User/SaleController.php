<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DebitCreditAccount;
use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $petrol = Product::find(1);
        $diesel = Product::find(2);
        if($request->date)
        {
            $date = Carbon::parse($request->date);
        }else{
            $date = Carbon::today();
        }
        $active_tab = $request->active_tab?$request->active_tab:'petrol';
        $accounts = DebitCreditAccount::where('user_id',Auth::user()->id)->orWhereNull('user_id')->where('name','!=','Cash')->where('name','!=','Sale')->get();
        $cash_account_id = DebitCreditAccount::where('name','Cash')->first()->id;
        $products = Product::where('user_id',Auth::user()->id)->orWhereNull('user_id')->get();
        return view('user.sale.create',compact('petrol','diesel','date','active_tab','accounts','products','cash_account_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $petrol = Product::find(1);
        $diesel = Product::find(2);
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
                foreach($request->current_reading as $key => $current_reading)
                {
                    if($current_reading)
                    {
                        if($request->qty[$key] > $product->availableStock())
                        {
                            toastr()->error('Stock is not avaiable');
                            if($product->name == 'Petrol')
                            {
                                return redirect()->to(route('user.sale.index').'?active_tab=petrol');
                            }else{
                                return redirect()->to(route('user.sale.index').'?active_tab=diesel');
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
                if($request->testing == true)
                {
                    if($request->testing_quantity > $product->availableStock())
                    {
                        toastr()->error('Stock is not avaiable');
                        
                        if($product->name == 'Petrol')
                        {
                            return redirect()->to(route('user.sale.index').'?active_tab=petrol');
                        }else{
                            return redirect()->to(route('user.sale.index').'?active_tab=diesel');
                        }
                    }
                    $total = $product->selling_price * $request->testing_quantity;
                    Sale::create([
                        'user_id' => Auth::user()->id,
                        'product_id' => $request->product_id,
                        'price' => $product->selling_price,
                        'total_amount' => $total,
                        'type' => 'test',
                        'sale_date' => $request->sale_date,
                        'qty' => $request->testing_quantity,
                    ]);

                }
                if($request->whole_sale == true)
                {
                    if($request->wholesale_quantity > $product->availableStock())
                    {
                        toastr()->error('Stock is not avaiable');
                        if($product->name == 'Petrol')
                        {
                            return redirect()->to(route('user.sale.index').'?active_tab=petrol');
                        }else{
                            return redirect()->to(route('user.sale.index').'?active_tab=diesel');
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
                toastr()->success('Sale is Created Successfully');
                if($product->name == 'Petrol')
                {
                    return redirect()->to(route('user.sale.index').'?active_tab=petrol');
                }else{
                    return redirect()->to(route('user.sale.index').'?active_tab=diesel');
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
                            return redirect()->to(route('user.sale.index').'?active_tab=misc');
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
                        toastr()->success('Sale is Created Successfully');
                        return redirect()->to(route('user.sale.index').'?active_tab=misc');
                    }
                }
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
                                if($product->name == 'Petrol')
                                {
                                    return redirect()->to(route('user.sale.index').'?active_tab=petrol');
                                }else{
                                    return redirect()->to(route('user.sale.index').'?active_tab=diesel');
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
                                if($product->name == 'Petrol')
                                {
                                    return redirect()->to(route('user.sale.index').'?active_tab=petrol');
                                }else{
                                    return redirect()->to(route('user.sale.index').'?active_tab=diesel');
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
                if($request->testing == true)
                {
                    if($request->testing_sale_id)
                    {
                        $sale = Sale::find($request->testing_sale_id);      
                        $total_qty = $request->testing_quantity - $sale->qty;                  
                        if($total_qty > $product->availableStock())
                        {
                            toastr()->error('Stock is not avaiable');  
                            if($product->name == 'Petrol')
                            {
                                return redirect()->to(route('user.sale.index').'?active_tab=petrol');
                            }else{
                                return redirect()->to(route('user.sale.index').'?active_tab=diesel');
                            }  
                        }
                        $total = $product->selling_price * $request->testing_quantity;
                        $sale->update([
                            'price' => $product->selling_price,
                            'total_amount' => $total,
                            'qty' => $request->testing_quantity,
                        ]);
                    }else{
                                          
                        if($request->testing_quantity > $product->availableStock())
                        {
                            toastr()->error('Stock is not avaiable');  
                            if($product->name == 'Petrol')
                            {
                                return redirect()->to(route('user.sale.index').'?active_tab=petrol');
                            }else{
                                return redirect()->to(route('user.sale.index').'?active_tab=diesel');
                            }  
                        }
                        $total = $product->selling_price * $request->testing_quantity;
                        Sale::create([
                            'user_id' => Auth::user()->id,
                            'product_id' => $request->product_id,
                            'price' => $product->selling_price,
                            'total_amount' => $total,
                            'type' => 'test',
                            'sale_date' => $request->sale_date,
                            'qty' => $request->testing_quantity,
                        ]);

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
                            if($product->name == 'Petrol')
                            {
                                return redirect()->to(route('user.sale.index').'?active_tab=petrol');
                            }else{
                                return redirect()->to(route('user.sale.index').'?active_tab=diesel');
                            }  
                        }
                        $total = $product->selling_price * $request->testing_quantity;
                        $sale->update([
                            'price' => $request->wholesale_price,
                            'total_amount' => $request->wholesale_total_amount,
                            'qty' => $request->wholesale_quantity,
                        ]);
                    }else{               
                        if($request->wholesale_quantity > $product->availableStock())
                        {
                            toastr()->error('Stock is not avaiable');  
                            if($product->name == 'Petrol')
                            {
                                return redirect()->to(route('user.sale.index').'?active_tab=petrol');
                            }else{
                                return redirect()->to(route('user.sale.index').'?active_tab=diesel');
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
                toastr()->success('Sale is Created Successfully');
                if($product->name == 'Petrol')
                {
                    return redirect()->to(route('user.sale.index').'?active_tab=petrol');
                }else{
                    return redirect()->to(route('user.sale.index').'?active_tab=diesel');
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
                                return redirect()->to(route('user.sale.index').'?active_tab=misc');              
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
                                return redirect()->to(route('user.sale.index').'?active_tab=misc');              
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
        $petrol = Product::find(1);
        $diesel = Product::find(2);
        $date = Carbon::parse($request->date);
        $html = view('user.sale.partials.sale_detail', compact('petrol','diesel','date'))->render();;
        return response([
            'html' => $html,
        ], 200);
    }
    public function deleteSale(Request $request)
    {
        $sale = Sale::find($request->id);
        $sale->delete();
        toastr()->success('Sale Deleted successfully');
        return response([
            'success' => true,
        ], 200);
    }
}
