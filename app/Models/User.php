<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password','type','capital_amount'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function setPasswordAttribute($value){
        if (!empty($value)){
            $this->attributes['password'] = Hash::make($value);
        }
    }
    public static function site(){
        return (new static)::where('type','Site')->get();
    } 
    public static function supplier(){
        return (new static)::where('type','Supplier')->get();
    }
    public function vendors()
    {
        return $this->hasMany(Vendor::class);
    }
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
    public function accounts()
    {
        return $this->hasMany(BankAccount::class);
    }
    public function machines()
    {
        return $this->hasMany(Machine::class);
    }
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function debitCredits()
    {
        return $this->hasMany(DebitCredit::class,'user_id');
    }
    public function getPetrolMachine()
    {
        $productMachines = Machine::where('user_id',$this->id)->where('product_id',1)->get();
        return $productMachines;
    }
    public function getDieselMachine()
    {
        $productMachines = Machine::where('user_id',$this->id)->where('product_id',2)->get();
        return $productMachines;
    }
    public function getPetrolOpeningBalance($date)
    {
        $product = Product::where('name','Petrol')->first();
        $totalStock = Purchase::where('user_id',$this->id)->where('product_id',$product->id)
                            ->whereDate('created_at','!=',$date)
                            ->sum('qty');
        $totalSale = Sale::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->where('type','!=','test')
                        ->whereDate('sale_date','!=',$date)
                        ->sum('qty');       
        $testSale = Sale::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->where('type','test')
                        ->whereDate('sale_date','!=',$date)
                        ->sum('qty');
        $sale = $totalSale - $testSale;
        $avaiableStock = $totalStock - $sale;
        return $avaiableStock;
    }
    public function getTodayPetrolSale($date)
    {
        $product = Product::where('name','Petrol')->first();
        $todaySale = Sale::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->where('type','retail_sale')
                        ->whereDate('sale_date',$date)
                        ->sum('qty');
        $testSale = Sale::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->where('type','test')
                        ->whereDate('sale_date',$date)
                        ->sum('qty');
        return $todaySale - $testSale;
    }
    public function getTodayPetrolPurchase($date)
    {
        $product = Product::where('name','Petrol')->first();
        $todayPurchase = Purchase::where('user_id',$this->id)->where('product_id',$product->id)->whereDate('created_at',$date)->sum('qty');
        return $todayPurchase;
    }
    public function getDieselOpeningBalance($date)
    {
        $product = Product::where('name','Diesel')->first();
        $totalStock = $this->purchases->where('product_id',$product->id)->sum('qty');
        $totalSale = Sale::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->where('type','!=','test')
                        ->whereDate('sale_date','!=',$date)
                        ->sum('qty');
        $avaiableStock = $totalStock - $totalSale;
        return $avaiableStock;
    }
    public function getTodayDieselSale($date)
    {
        $product = Product::where('name','Diesel')->first();
        $todaySale = Sale::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->where('type','retail_sale')
                        ->whereDate('sale_date',$date)
                        ->sum('qty');
        return $todaySale;
    }
    public function getTodayDieselPurchase($date)
    {
        $product = Product::where('name','Diesel')->first();
        $todayPurchase = Purchase::where('user_id',$this->id)->where('product_id',$product->id)->whereDate('created_at',$date)->sum('qty');
        return $todayPurchase;
    }
    public function haveSale($date,$product = null)
    {   
        if($product == null)
        {
            $sales = Sale::where('user_id',$this->id)
                            ->where('type','misc_sale')
                            ->whereDate('sale_date',$date)
                            ->get();  
        }else{
            $sales = Sale::where('user_id',$this->id)
                            ->where('product_id',$product->id)
                            ->whereDate('sale_date',$date)
                            ->get();  
        }
        return $sales;
    }
    public function haveDebitCredit($date)
    {   
        $sales = DebitCredit::where('user_id',$this->id)
                            ->whereDate('sale_date',$date)
                            ->get();  
        return $sales;
    }
    public function getTestSale($date,$product)
    {   
        $test_sale = Sale::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->where('type','test')
                        ->whereDate('sale_date',$date)
                        ->first();  
        return $test_sale;
    }
    public function getWholeSale($date,$product)
    {   
        $sale = Sale::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->where('type','whole_sale')
                        ->whereDate('sale_date',$date)
                        ->first();  
        return $sale;
    }
    public function todaySaleAmount($date)
    {
        $todaySale = Sale::where('user_id',$this->id)
                        ->whereDate('sale_date',$date)
                        ->sum('total_amount');
        $testSale = Sale::where('user_id',$this->id)
                        ->where('type','test')
                        ->whereDate('sale_date',$date)
                        ->sum('total_amount');
        return $todaySale - $testSale;
    }
}
