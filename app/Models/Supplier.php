<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Supplier extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function setPasswordAttribute($value){
        if (!empty($value)){
            $this->attributes['password'] = Hash::make($value);
        }
    }
    public static function employee(){
        return (new static)::where('type','2')->get();
    }
    public function purchases()
    {
        return $this->hasMany(SupplierPurchase::class);
    }
    public function sales()
    {
        return $this->hasMany(Purchase::class);
    }
    public function terminals()
    {
        return $this->hasMany(SupplierTerminal::class);
    }
    public function vehicles()
    {
        return $this->hasMany(SupplierVehicle::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
