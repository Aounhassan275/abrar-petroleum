<?php

namespace App\Helpers;

use App\Models\DebitCredit;
use App\Models\DebitCreditAccount;
use App\Models\LossGainTranscation;
use App\Models\User;
use Carbon\Carbon;

class LossGainHelper
{
    public static function procceed($old_amount,$product,$old_selling_amount,$date){
        $users = User::all();
        foreach($users as $user)
        {
            if($product->availableStock($user->id) > 0)
            {
                $difference = $product->purchasing_price - $old_amount;
                $totalAmount = $product->availableStock($user->id) * $difference;
                LossGainTranscation::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'date' => $date,
                    'amount' => $totalAmount,
                    'old_price' => $old_amount,
                    'new_price' => $product->purchasing_price,
                    'old_selling_price' => $old_selling_amount,
                    'new_selling_price' => $product->selling_price,
                    'qty' => $product->availableStock($user->id),
                ]);
                $account = DebitCreditAccount::where('name','Rate Gain and Loss')->first();
                $credit = 0;
                $debit = 0;
                if($totalAmount > 0)
                {
                    $credit = $totalAmount;
                    $description = "Profit On Price Difference Of".$difference;
                }else{
                    $debit = $totalAmount;
                    $description = "Loss On Price Difference Of".$difference;
                }
                DebitCredit::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'qty' => $product->availableStock($user->id),
                    'debit' => @$debit,
                    'credit' => @$credit,
                    'account_id' => $account->id,
                    'description' => $description,
                    'sale_date' => $date,
                ]);
            }
        }
    } 
}