<?php

namespace App\Http\Controllers;

use App\Helpers\SupplierHelper;
use App\Models\DebitCredit;
use App\Models\DebitCreditAccount;
use App\Models\User;
use Illuminate\Http\Request;

class CronjobController extends Controller
{
    public function moveDebitCreditAccounts()
    {
        set_time_limit(0);
        $supplier_account_id  = DebitCreditAccount::where('name','Alitraders')->where('supplier_id',4)->first()->id;
        $debitcredits = DebitCredit::whereNotNull('sale_date')->where('account_id',$supplier_account_id)->get();
        foreach($debitcredits as $debitcredit)
        {
            SupplierHelper::storeDebitCredit($debitcredit);
        }
    }
    public function createSiteAccounts()
    {
        $users = User::all();
        foreach($users as $user)
        {
            if(DebitCreditAccount::where('site_id',$user->id)->count() == 0)
            {
                DebitCreditAccount::create([
                    'name' => $user->username,
                    'supplier_id' => 4,
                    'site_id' => $user->id,
                    'account_category_id' =>2,
                ]); 
            }
        }  
    }
}
