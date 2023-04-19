<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'name', 'phone','address','fax','email','user_id','supplier_id'
    ];
    public function site()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function supplier()
    {
        return $this->belongsTo('App\Models\User','supplier_id');
    }
    public function accounts()
    {
        return $this->hasMany(VendorAccount::class);
    }
    public function terminals()
    {
        return $this->hasMany(VendorTerminal::class);
    }
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
