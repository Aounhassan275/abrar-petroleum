<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountCategory extends Model
{
    protected $fillable = [
        'name'
    ];
    public function debitCreditAccount()
    {
        return $this->hasMany(DebitCreditAccount::class);
    }
}
