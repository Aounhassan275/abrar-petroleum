<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerTranscation extends Model
{
    protected $fillable = [
        'amount','type','image','customer_id'
    ];
    public function customer()
    {
        return $this->hasMany(Customer::class);
    }
}
