<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'title','bank_id','location','number','user_id'
    ];
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
