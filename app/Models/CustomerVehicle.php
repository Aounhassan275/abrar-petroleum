<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerVehicle extends Model
{
    protected $fillable = [
        'name','reg_number','customer_id'
    ];
    public function customer()
    {
        return $this->hasMany(Customer::class);
    }
}
