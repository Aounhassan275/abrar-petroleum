<?php

namespace App\Http\Controllers\Supplier;

use App\Helpers\SupplierHelper;
use App\Http\Controllers\Controller;
use App\Models\AccountCategory;
use App\Models\DebitCredit;
use App\Models\DebitCreditAccount;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchasePayment;
use App\Models\Supplier;
use App\Models\SupplierPurchase;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
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
        $sale_date = Purchase::where('supplier_id',Auth::user()->id)->get()->last()->date;
        if($request->date)
        {
            $sale_date->addDay();    
            if(Carbon::parse($request->date)->gt($sale_date))
            {
                toastr()->error('Not Allowed');
                $date =  $sale_date;
                $day_before = Purchase::all()->last()->date;
            }else{
                $date =  Carbon::parse($request->date);
                $day_before =  Carbon::parse($request->date)->subDay();
            }
        }else{
            $date =  $sale_date->addDay();
            $day_before = Purchase::all()->last()->date;
        }
        $active_tab = $request->active_tab?$request->active_tab:'product_purchase';
        $newDateForLastDay = $newDateForNextDay = $date; 
        $previousUrl = route('supplier.sale.index').'?active_tab='.$active_tab.'&date='.$newDateForLastDay->subDay(1)->format('Y-m-d');
        $nextUrl = route('supplier.sale.index').'?active_tab='.$active_tab.'&date='.$newDateForNextDay->addDay(1)->format('Y-m-d');
        $accounts = DebitCreditAccount::query()
                ->select('debit_credit_accounts.*')
                ->where('debit_credit_accounts.supplier_id', Auth::user()->id)
                ->orWhereNull('debit_credit_accounts.user_id')
                ->orderBy('debit_credit_accounts.account_category_id', 'ASC')
                ->get();
        $cash_account_id = DebitCreditAccount::where('name','Cash in Hand')->first()->id;
        $lastDayCash = DebitCredit::where('account_id',$cash_account_id)->whereDate('sale_date',$day_before)->where('supplier_id',Auth::user()->id)->first();
        $missing_debit_credits = DebitCredit::whereNull('account_id')->where('supplier_id',Auth::user()->id)->get();
        $products = Product::whereNull('user_id')->orWhere('supplier_id',Auth::user()->id)->get();
        $purchases = Purchase::where('supplier_id',Auth::user()->id)->whereDate('date',$date)->get();
        $userId = Auth::user()->id;
        $vendor_category_id = AccountCategory::where('name','Vendors')->first()->id;
        $vendorAccounts = DebitCreditAccount::query()->where('account_category_id',$vendor_category_id)
                ->where(function ($query) use ($userId) {
                    $query->where('supplier_id', $userId)
                        ->orWhereNull('user_id');
                })
                ->get();
        $supplierPurchases = SupplierPurchase::where('supplier_id',$userId)->whereDate('date',$date)->get();
        return view('supplier.sale.index',compact(
            'date','active_tab','accounts','products','cash_account_id',
            'lastDayCash','missing_debit_credits',
            'previousUrl','nextUrl','diesel','petrol',
            'purchases','vendorAccounts','supplierPurchases'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supplier.sale.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'date' => 'required',
            'product_id.*' => 'required',
            'user_id.*' => 'required',
            'sale_type.*' => 'required',
            'qty.*' => 'required|numeric|gt:0',
            'price.*' => 'required',
            'total_amount.*' => 'required|numeric|gt:0',
        ]);
        try{
            DB::beginTransaction();
            foreach($request->user_id as $index => $user_id)
            {
                $product = Product::find($request->product_id[$index]);
                if($product->supplierAvailableStock() > $request->qty[$index])
                {
                    if($request->purchase_id[$index])
                    {
                        $purchase = Purchase::find($request->purchase_id[$index]);
                        $purchase->update([
                            'price' => $request->price[$index],
                            'qty' => $request->qty[$index],
                            'product_id' => $request->product_id[$index],
                            'total_amount' => $request->total_amount[$index],
                            'supplier_vehicle_id' => $request->supplier_vehicle_id[$index],
                            'user_id' => $user_id,
                        ]);
                    }else{
                        $purchase = Purchase::create([
                            'price' => $request->price[$index],
                            'qty' => $request->qty[$index],
                            'product_id' => $request->product_id[$index],
                            'total_amount' => $request->total_amount[$index],
                            'supplier_vehicle_id' => $request->supplier_vehicle_id[$index],
                            'user_id' => $user_id,
                            'date' => $request->date,
                            'supplier_id' => Auth::user()->id,
                        ]);

                    }
                    $account_id  = DebitCreditAccount::where('product_id',$request->product_id)->first()->id;
                    if($request->purchase_id[$index])
                    {
                        $userDebitCredit = DebitCredit::where('purchase_id',$purchase->id)
                                            ->where('account_id',$account_id)->first();
                        if($userDebitCredit)
                        {
                            $userDebitCredit->update([
                                'user_id' => $user_id,
                                'site_validation' => 0,
                                'debit' => @$purchase->total_amount,
                                'account_id' => $account_id,
                                'sale_date' => $purchase->date,
                                'purchase_id' => $purchase->id,
                            ]);
                        }else{
                            DebitCredit::create([
                                'user_id' => $user_id,
                                'site_validation' => 0,
                                'debit' => @$purchase->total_amount,
                                'account_id' => $account_id,
                                'sale_date' => $purchase->date,
                                'purchase_id' => $purchase->id,
                            ]);
                        }
                    }else{
                        DebitCredit::create([
                            'user_id' => $user_id,
                            'site_validation' => 0,
                            'debit' => @$purchase->total_amount,
                            'account_id' => $account_id,
                            'sale_date' => $purchase->date,
                            'purchase_id' => $purchase->id,
                        ]);

                    }
                    $supplier_account_id  = DebitCreditAccount::where('name','Alitraders')->where('supplier_id',Auth::user()->id)->first()->id;
                    if($request->purchase_id[$index])
                    {
                        $debitcredit = DebitCredit::where('purchase_id',$purchase->id)
                        ->where('account_id',$supplier_account_id)->first();
                        if($debitcredit)
                        {
                            $debitcredit->update([
                                'user_id' => $user_id,
                                'site_validation' => 0,
                                'credit' => @$purchase->total_amount,
                                'account_id' => $supplier_account_id,
                                'sale_date' => $purchase->date,
                                'purchase_id' => $purchase->id,
                                'description' => $purchase->qty.' litres '.$purchase->product->name,
                            ]);
                        }
                        else{
                            
                            $debitcredit = DebitCredit::create([
                                'user_id' => $user_id,
                                'site_validation' => 0,
                                'credit' => @$purchase->total_amount,
                                'account_id' => $supplier_account_id,
                                'sale_date' => $purchase->date,
                                'purchase_id' => $purchase->id,
                                'description' => $purchase->qty.' litres '.$purchase->product->name,
                            ]);
                        }
                    }else{
                        $debitcredit = DebitCredit::create([
                            'user_id' => $user_id,
                            'site_validation' => 0,
                            'credit' => @$purchase->total_amount,
                            'account_id' => $supplier_account_id,
                            'sale_date' => $purchase->date,
                            'purchase_id' => $purchase->id,
                            'description' => $purchase->qty.' litres '.$purchase->product->name,
                        ]);
                    }
                    SupplierHelper::storeDebitCredit($debitcredit,1);
                }else{
                    DB::rollBack();
                    return response([
                        "success" => false,
                        "message" => 'Stock is limited!',
                    ], 500);
                }
            }
            toastr()->success('Sale is Created Successfully');
            DB::commit();
            $url = route('supplier.sale.index').'?active_tab=product&date='.Carbon::parse($request->date)->format('Y-m-d');
            return response([
                "success" => true,
                "url" => $url,
                "message" => 'Sale Created Successfully!',
            ], 200);
        }catch(Exception $e)
        {        
            DB::rollBack();   
            return response([
                "success" => false,
                "message" => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sale = Purchase::find($id);
        return view('supplier.sale.edit',compact('sale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $purchase = Purchase::find($id);
        $purchase->update($request->all());
        toastr()->success('Sale Informations Updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purchase = Purchase::find($id);
        $purchase->delete();
        toastr()->success('Sale Deleted successfully');
        return redirect()->back();
    }
    public function getProductFields(Request $request)
    {
        $key = $request->key;
        $html = view('supplier.sale.partials.product_sale_fields', compact('key'))->render();
        return response([
            'html' => $html,
        ], 200);
    }
}
