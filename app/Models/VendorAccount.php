<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorAccount extends Model
{
    protected $fillable = [
        'title','bank_id','location','number','vendor_id'
    ];
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
