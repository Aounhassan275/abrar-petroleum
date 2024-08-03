<?php

namespace App\Helpers;

use App\Models\DebitCredit;
use App\Models\DebitCreditAccount;

class SupplierHelper
{
    public static function storeDebitCredit($debitcredit,$is_supplier = 0){
        // Store or update Debit Credit For Supplier Account Code Start
            SupplierHelper::storeDebitCreditForSupplierAccount($debitcredit,$is_supplier);
        // Store or update Debit Credit For Supplier Account Code End
        // Store or update Debit Credit For Site Account Code Start
            SupplierHelper::storeDebitCreditForSiteAccount($debitcredit,$is_supplier);
        // Store or update Debit Credit For Site Account Code End
    } 
    public static function storeDebitCreditForSupplierAccount($debitcredit,$is_supplier)
    {
        $supplier_account_id  = DebitCreditAccount::where('name','Alitraders')->where('supplier_id',4)->first()->id;
        $data = [
            'debit_credit_id' => $debitcredit->id,
            'site_id' => $debitcredit->user_id,
            'site_validation' => $is_supplier ? 0 : 1,
            'supplier_validation' => $is_supplier ? 1 : 0,
            'supplier_id' => 4,
            'debit' => $debitcredit->credit ? $debitcredit->credit : 0,
            'credit' => $debitcredit->debit ? $debitcredit->debit : 0,
            'account_id' => $supplier_account_id,
            'sale_date' => $debitcredit->sale_date,
            'purchase_id' => $debitcredit->purchase_id,
            'description' => $debitcredit->description,
            'product_id' => $debitcredit->product_id,
            'qty' => $debitcredit->qty,
            'customer_vehicle_id' => $debitcredit->customer_vehicle_id,
        ];
        $isAlreadyExit = DebitCredit::where('debit_credit_id',$debitcredit->id)->where('account_id',$supplier_account_id)->first();
        if($isAlreadyExit)
        {
            $isAlreadyExit->update($data);
        }else{
            DebitCredit::create($data);
        }
    }
    public static function storeDebitCreditForSiteAccount($debitcredit,$is_supplier)
    {
        $account_id  = DebitCreditAccount::where('site_id',$debitcredit->user_id)->where('supplier_id',4)->first()->id;
        $isAlreadyExit = DebitCredit::where('debit_credit_id',$debitcredit->id)->where('account_id',$account_id)->first();
        $data = [
            'debit_credit_id' => $debitcredit->id,
            'site_id' => $debitcredit->user_id,
            'supplier_id' => 4,
            'site_validation' => $is_supplier ? 0 : 1,
            'supplier_validation' => $is_supplier ? 1 : 0,
            'debit' => $debitcredit->debit,
            'credit' => $debitcredit->credit,
            'account_id' => $account_id,
            'sale_date' => $debitcredit->sale_date,
            'purchase_id' => $debitcredit->purchase_id,
            'description' => $debitcredit->description,
            'product_id' => $debitcredit->product_id,
            'qty' => $debitcredit->qty,
            'customer_vehicle_id' => $debitcredit->customer_vehicle_id,
        ];
        if($isAlreadyExit)
        {
            $isAlreadyExit->update($data);
        }else{
            DebitCredit::create($data);
        }
    }
    
}