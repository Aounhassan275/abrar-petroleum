<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorTerminal extends Model
{
    protected $fillable = [
        'name','vendor_id'
    ];
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
