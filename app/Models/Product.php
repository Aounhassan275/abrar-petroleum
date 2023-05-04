<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    protected $fillable = [
        'name','purchasing_price','selling_price','user_id','supplier_purchasing_price','supplier_id'
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
        $product = Product::where('name','PMG')->first();
        return $product->selling_price;
    }
    public static function dieselSellingPrice()
    {
        $product = Product::where('name','HSD')->first();
        return $product->selling_price;
    }
    public function totalStocks($user_id = null)
    {
        if(!$user_id)
            $user_id = Auth::user()->id;
        $total_stock = $this->purchases->where('user_id',$user_id)->sum('qty');
        $total_access_stock = $this->purchases->where('user_id',$user_id)->sum('access');
        return $total_stock + $total_access_stock;
    }
    public function totalSales($user_id = null)
    {
        if(!$user_id)
            $user_id = Auth::user()->id;
        $total_sale = Sale::where('user_id',$user_id)
                        ->where('type','!=','test')
                        ->sum('qty'); 
        return $total_sale;
    }
    public function availableStock($user_id = null)
    {
        if(!$user_id)
            $user_id = Auth::user()->id;
        $available_stock = $this->totalStocks($user_id) - $this->totalSales($user_id);
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
    public function totalDrAmount($start_date,$end_date)
    {
        $total_sales = Sale::where('user_id',Auth::user()->id)
                        ->where('product_id',$this->id)
                        ->whereBetween('sale_date', [$start_date,$end_date])
                        ->where('type','!=','test')
                        ->sum('total_amount'); 
        $total_purchases = Purchase::where('user_id',Auth::user()->id)
                        ->where('product_id',$this->id)
                        ->whereBetween('date', [$start_date,$end_date])
                        ->sum('total_amount'); 
        return $total_sales - $total_purchases;
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
    //Supplier Functions 
    public function supplierPurchases()
    {
        return $this->hasMany(SupplierPurchase::class);
    }
    public function suppliersales()
    {
        return $this->hasMany(Purchase::class);
    }
    public function supplierTotalStocks($supplier_id = null)
    {
        if(!$supplier_id)
            $supplier_id = Auth::user()->id;
        $total_stock = $this->supplierPurchases->where('supplier_id',$supplier_id)->sum('qty');
        $total_access_stock = $this->supplierPurchases->where('supplier_id',$supplier_id)->sum('access');
        return $total_stock + $total_access_stock;
    }
    public function supplierTotalSales($supplier_id = null)
    {
        if(!$supplier_id)
            $supplier_id = Auth::user()->id;
        $total_sale = Purchase::where('supplier_id',$supplier_id)->sum('qty'); 
        return $total_sale;
    }
    public function supplierAvailableStock($supplier_id = null)
    {
        if(!$supplier_id)
            $supplier_id = Auth::user()->id;
        $available_stock = $this->supplierTotalStocks($supplier_id) - $this->supplierTotalSales($supplier_id);
        return $available_stock;
    }
}
