<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierTerminal extends Model
{
    protected $fillable = [
        'name', 'phone','address','fax','email','supplier_id'
    ];
    public function supplier()
    {
        return $this->belongsTo('App\Models\Suppliers','supplier_id');
    }
}
