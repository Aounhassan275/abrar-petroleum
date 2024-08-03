<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\AccountCategory;
use App\Models\DebitCredit;
use App\Models\DebitCreditAccount;
use App\Models\SupplierPurchase;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupplierPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('supplier.purchase.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userId = Auth::user()->id;
        $vendor_category_id = AccountCategory::where('name','Vendors')->first()->id;
        $accounts = DebitCreditAccount::query()->where('account_category_id',$vendor_category_id)
                ->where(function ($query) use ($userId) {
                    $query->where('supplier_id', $userId)
                        ->orWhereNull('user_id');
                })
                ->get();
        return view('supplier.purchase.create',compact('accounts'));
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
            $purchase  = SupplierPurchase::create($request->all());
            $this->storeDebitCreditForPurchase($purchase);
            toastr()->success('Supplier Purchase is Created Successfully');
            return redirect()->back();
        }catch(Exception $e)
        {
            toastr()->error($e->getMessage());
            return back()->withInput($request->all());

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SupplierPurchase  $supplierPurchase
     * @return \Illuminate\Http\Response
     */
    public function show(SupplierPurchase $supplierPurchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SupplierPurchase  $supplierPurchase
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase = SupplierPurchase::find($id);
        return view('supplier.purchase.edit',compact('purchase'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SupplierPurchase  $supplierPurchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $purchase = SupplierPurchase::find($id);
        $purchase->update($request->all());
        toastr()->success('Purchase Informations Updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupplierPurchase  $supplierPurchase
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purchase = SupplierPurchase::find($id);
        $purchase->delete();
        toastr()->success('Purchase Deleted successfully');
        return redirect()->back();
    }
    public function storeDebitCreditForPurchase($purchase)
    {
        $debitCredit = DebitCredit::where('purchase_id',$purchase->id)->first();
        if($debitCredit)
        {
           $debitCredit->update([
                'supplier_id' => Auth::user()->id,
                'credit' => 0,
                'debit' => @$purchase->total_amount,
                'account_id' => $purchase->debit_credit_account_id,
                'sale_date' => $purchase->date,
                'purchase_id' => $purchase->id,
                'description' => $purchase->qty.' litres '.$purchase->product->name,
            ]);
        }else{     
            DebitCredit::create([
                'supplier_id' => Auth::user()->id,
                'credit' => 0,
                'debit' => @$purchase->total_amount,
                'account_id' => $purchase->debit_credit_account_id,
                'sale_date' => $purchase->date,
                'purchase_id' => $purchase->id,
                'description' => $purchase->qty.' litres '.$purchase->product->name,
            ]);
        }
    }
    public function getPurchasesFields(Request $request)
    {
        $supplierPurchaseIndex = $request->key;
        $userId = Auth::user()->id;
        $vendor_category_id = AccountCategory::where('name','Vendors')->first()->id;
        $vendorAccounts = DebitCreditAccount::query()->where('account_category_id',$vendor_category_id)
                ->where(function ($query) use ($userId) {
                    $query->where('supplier_id', $userId)
                        ->orWhereNull('user_id');
                })
                ->get();
        $html = view('supplier.sale.supplier_purchases.partials.fields', compact('supplierPurchaseIndex','vendorAccounts'))->render();
        return response([
            'html' => $html,
        ], 200);
    }
    public function save(Request $request)
    {
        $this->validate($request,[
            'date' => 'required',
            'product_id.*' => 'required',
            'qty.*' => ['required', 'numeric', 'qty_access_check'],
            'access.*' => ['required', 'numeric', 'qty_access_check'],
            'shortage.*' => ['required', 'numeric', 'qty_access_check'],
            'price.*' => 'required|numeric',
            'total_amount.*' => 'nullable|numeric',
            'debit_credit_account_id.*' => 'required',
        ]);
        try{
            DB::beginTransaction();
            foreach($request->product_id as $index => $product_id)
            {
                if($request->supplier_purchase_id[$index])
                {
                    $purchase = SupplierPurchase::find($request->supplier_purchase_id[$index]);
                    $purchase->update([
                        'date' => $request->date,
                        'product_id' => $product_id,
                        'qty' => $request->qty[$index],
                        'price' => $request->price[$index],
                        'total_amount' => $request->total_amount[$index],
                        'access' => @$request->access[$index],
                        'access_total_amount' => $request->access_total_amount[$index],
                        'shortage' => @$request->shortage[$index],
                        'shortage_total_amount' => $request->shortage_total_amount[$index],
                        'supplier_vehicle_id' => @$request->supplier_vehicle_id[$index],
                        'supplier_terminal_id' => @$request->supplier_terminal_id[$index],
                        'debit_credit_account_id' => @$request->debit_credit_account_id[$index],
                    ]);

                }else{
                    $purchase  = SupplierPurchase::create([
                        'supplier_id' => Auth::user()->id,
                        'date' => $request->date,
                        'product_id' => $product_id,
                        'qty' => $request->qty[$index],
                        'price' => $request->price[$index],
                        'total_amount' => $request->total_amount[$index],
                        'access' => @$request->access[$index],
                        'access_total_amount' => $request->access_total_amount[$index],
                        'shortage' => @$request->shortage[$index],
                        'shortage_total_amount' => $request->shortage_total_amount[$index],
                        'supplier_vehicle_id' => @$request->supplier_vehicle_id[$index],
                        'supplier_terminal_id' => @$request->supplier_terminal_id[$index],
                        'debit_credit_account_id' => @$request->debit_credit_account_id[$index],
                    ]);
                }
                if($purchase->qty > 0 && $purchase->shortage == 0 && $purchase->access == 0)
                {
                    $this->storeDebitCreditForPurchase($purchase);
                }else if($purchase->access > 0 && $purchase->shortage == 0 && $purchase->qty == 0)
                {
                    $this->storeDebitCreditForAccessPurchase($purchase);
                }else if($purchase->shortage > 0 && $purchase->access == 0 && $purchase->qty == 0){
                    $this->storeDebitCreditForShortagePurchase($purchase);
                }else{
                    DB::rollBack();   
                    return response([
                        "success" => false,
                        "message" => "There is a issue in saving data related to access, shortage or product quantity.",
                    ], 500);
                }
            }
            toastr()->success('Purchase is Created Successfully');
            DB::commit();
            $url = route('supplier.sale.index').'?active_tab=product&date='.Carbon::parse($request->date)->format('Y-m-d');
            return response([
                "success" => true,
                "url" => $url,
                "message" => 'Purchase Created Successfully!',
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
    public function storeDebitCreditForAccessPurchase($purchase)
    {
        $account_id  = DebitCreditAccount::where('name','Product Excess')->first()->id;
        $expenseDebitCredit = DebitCredit::where('purchase_id',$purchase->id)
                ->where('account_id',$account_id)->first();
        if($expenseDebitCredit)
        {
            $expenseDebitCredit->update([
                'product_id' => @$purchase->product_id,
                'qty' => @$purchase->access,
                'credit' => @$purchase->access_total_amount,
                'account_id' => $account_id,
                'sale_date' => $purchase->date,
                'purchase_id' => $purchase->id,
                'description' => $purchase->access.' litres '.$purchase->product->name,
            ]);
        }else{
            DebitCredit::create([
                'supplier_id' => Auth::user()->id,
                'product_id' => @$purchase->product_id,
                'qty' => @$purchase->access,
                'credit' => @$purchase->access_total_amount,
                'account_id' => $account_id,
                'sale_date' => $purchase->date,
                'purchase_id' => $purchase->id,
                'description' => $purchase->access.' litres '.$purchase->product->name,
            ]);
        }
        
        $excessAccountId  = DebitCreditAccount::where('product_id',$purchase->product_id)->first()->id;
        $productDebitCredit = DebitCredit::where('purchase_id',$purchase->id)
                ->where('account_id',$excessAccountId)->first();
        if($productDebitCredit){
            $productDebitCredit->update([
                'debit' => @$purchase->access_total_amount,
                'account_id' => $excessAccountId,
                'sale_date' => $purchase->date,
                'purchase_id' => $purchase->id,
                'description' => $purchase->access.' litres '.$purchase->product->name,
            ]);
        }else{
            DebitCredit::create([
                'supplier_id' => Auth::user()->id,
                'debit' => @$purchase->access_total_amount,
                'account_id' => $excessAccountId,
                'sale_date' => $purchase->date,
                'purchase_id' => $purchase->id,
                'description' => $purchase->access.' litres '.$purchase->product->name,
            ]);
        }
    }
    public function storeDebitCreditForShortagePurchase($purchase)
    {
        $account_id  = DebitCreditAccount::where('name','Product Shortage')->first()->id;
        $expenseDebitCredit = DebitCredit::where('purchase_id',$purchase->id)
                ->where('account_id',$account_id)->first();
        if($expenseDebitCredit)
        {
            $expenseDebitCredit->update([
                'product_id' => @$purchase->product_id,
                'qty' => @$purchase->shortage,
                'debit' => @$purchase->shortage_total_amount,
                'account_id' => $account_id,
                'sale_date' => $purchase->date,
                'purchase_id' => $purchase->id,
                'description' => $purchase->shortage.' litres '.$purchase->product->name,
            ]);
        }else{
            DebitCredit::create([
                'supplier_id' => Auth::user()->id,
                'product_id' => @$purchase->product_id,
                'qty' => @$purchase->shortage,
                'debit' => @$purchase->shortage_total_amount,
                'account_id' => $account_id,
                'sale_date' => $purchase->date,
                'purchase_id' => $purchase->id,
                'description' => $purchase->shortage.' litres '.$purchase->product->name,
            ]);
        }
        
        $excessAccountId  = DebitCreditAccount::where('product_id',$purchase->product_id)->first()->id;
        $productDebitCredit = DebitCredit::where('purchase_id',$purchase->id)
                ->where('account_id',$excessAccountId)->first();
        if($productDebitCredit){
            $productDebitCredit->update([
                'credit' => @$purchase->shortage_total_amount,
                'account_id' => $excessAccountId,
                'sale_date' => $purchase->date,
                'purchase_id' => $purchase->id,
                'description' => $purchase->shortage.' litres '.$purchase->product->name,
            ]);
        }else{
            DebitCredit::create([
                'supplier_id' => Auth::user()->id,
                'credit' => @$purchase->shortage_total_amount,
                'account_id' => $excessAccountId,
                'sale_date' => $purchase->date,
                'purchase_id' => $purchase->id,
                'description' => $purchase->shortage.' litres '.$purchase->product->name,
            ]);
        }
    }
}
