<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierVehicle extends Model
{
    protected $fillable = [
        'name', 'number','supplier_id','description'
    ];
    public function supplier()
    {
        return $this->belongsTo('App\Models\Suppliers','supplier_id');
    }
}
