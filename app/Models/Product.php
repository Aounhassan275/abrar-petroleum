<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    protected $fillable = [
        'name','purchasing_price','selling_price','user_id'
    ];
    
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
    public static function petrolSellingPrice()
    {
        $product = Product::where('name','HSD')->first();
        return $product->selling_price;
    }
    public static function dieselSellingPrice()
    {
        $product = Product::where('name','PMG')->first();
        return $product->selling_price;
    }
    public function totalStocks()
    {
        $total_stock = $this->purchases->where('user_id',Auth::user()->id)->sum('qty');
        return $total_stock;
    }
    public function totalSales()
    {
        $total_sale = $this->sales->where('user_id',Auth::user()->id)->sum('qty');
        return $total_sale;
    }
    public function availableStock()
    {
        $available_stock = $this->totalStocks() - $this->totalSales();
        return $available_stock;
    }
    public function totalSale($date)
    {
        $total_sale = Sale::where('user_id',Auth::user()->id)
                        ->where('product_id',$this->id)
                        ->whereDate('sale_date',$date)
                        ->sum('qty'); 
        return $total_sale;
    }
    public function totalTestSale($date)
    {
        $total_sale = Sale::where('user_id',Auth::user()->id)
                        ->where('product_id',$this->id)
                        ->where('type','test')
                        ->whereDate('sale_date',$date)
                        ->sum('qty');  
        return $total_sale;
    }
    public function totalWholeSale($date)
    {
        $total_sale = Sale::where('user_id',Auth::user()->id)
                        ->where('product_id',$this->id)
                        ->where('type','whole_sale')
                        ->whereDate('sale_date',$date)
                        ->sum('qty');  
        return $total_sale;
    }
    public function totalSaleAmount($date)
    {
        $total_amount = Sale::where('user_id',Auth::user()->id)
                        ->where('product_id',$this->id)
                        ->whereDate('sale_date',$date)
                        ->where('type','!=','test')
                        ->sum('total_amount'); 
        return $total_amount;
    }
    public function getSaleRate($date)
    {
        $sale = Sale::where('user_id',Auth::user()->id)
                        ->where('product_id',$this->id)
                        ->whereDate('sale_date',$date)->first(); 
        return $sale?$sale->price:$this->selling_price;
    }
    public function getSale($date)
    {
        $sale = Sale::where('product_id',$this->id)->whereDate('sale_date',$date)->first();
        return $sale;
    }
}
