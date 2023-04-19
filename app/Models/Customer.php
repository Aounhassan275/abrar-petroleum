<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name','father_name','cnic','phone','balance','user_id','address'
    ];
    
    public function transcations()
    {
        return $this->hasMany(CustomerTranscation::class);
    }
    public function vehicles()
    {
        return $this->hasMany(CustomerVehicle::class);
    }
}
