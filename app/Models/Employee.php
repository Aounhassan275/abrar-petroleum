<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'supplier_id','name','phone','address','designation','user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
