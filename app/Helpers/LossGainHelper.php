<?php

namespace App\Helpers;

use App\Models\LossGainTranscation;
use App\Models\User;

class LossGainHelper
{
    public static function procceed($old_amount,$product){
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
                    'amount' => $totalAmount,
                    'old_price' => $old_amount,
                    'new_price' => $product->purchasing_price,
                    'qty' => $product->availableStock($user->id),
                ]);
            }
        }
    } 
}