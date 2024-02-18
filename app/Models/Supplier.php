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
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
    public function haveSale($date,$product = null)
    {   
        if($product == null)
        {
            $sales = Purchase::where('supplier_id',$this->id)
                            ->whereDate('date',$date)
                            ->get();  
        }else{
            $sales = Purchase::where('supplier_id',$this->id)
                            ->where('product_id',$product->id)
                            ->whereDate('date',$date)
                            ->get();  
        }
        return $sales;
    }
    public function haveDebitCredit($date)
    {   
        $sales = DebitCredit::query()->select('debit_credits.*')
                            ->join('debit_credit_accounts','debit_credit_accounts.id','debit_credits.account_id')
                            ->where('debit_credits.is_hide',0)
                            ->where('debit_credits.supplier_id',$this->id)
                            ->whereDate('debit_credits.sale_date',$date)
                            ->orderBy('debit_credits.display_order','ASC')
                            ->get();  
        dd($sales);
        return $sales;
    }
}
