<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    protected $fillable = [
        'name','purchasing_price','selling_price','user_id','supplier_purchasing_price','supplier_id',
        'display_order'
    ];
    
	protected $appends = [
		'selling_amount'
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
        return $product->selling_amount;
    }
    public static function dieselSellingPrice()
    {
        $product = Product::where('name','HSD')->first();
        return $product->selling_amount;
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
                        ->where('product_id',$this->id)
                        ->sum('qty'); 
        $total_test_sale = Sale::where('user_id',$user_id)
                        ->where('type','test')
                        ->where('product_id',$this->id)
                        ->sum('qty'); 
        return $total_sale - $total_test_sale;
    }
    public function totalCurrentMonthSales($user_id = null)
    {
        if(!$user_id)
            $user_id = Auth::user()->id;
        $total_sale = Sale::where('user_id',$user_id)
                        ->where('type','!=','test')
                        ->where('product_id',$this->id)
                        ->whereBetween('sale_date',[Carbon::now()->startOfMonth(),Carbon::now()])
                        ->sum('qty'); 
        $total_test_sale = Sale::where('user_id',$user_id)
                        ->where('type','test')
                        ->whereBetween('sale_date',[Carbon::now()->startOfMonth(),Carbon::now()])
                        ->where('product_id',$this->id)
                        ->sum('qty'); 
        // dd($total_sale);
        return $total_sale - $total_test_sale;
    }
    public function totaPurchasesQty($user_id = null)
    {
        if(!$user_id)
            $user_id = Auth::user()->id;
        return Purchase::where('user_id',$user_id)
                        ->where('product_id',$this->id)
                        ->sum('qty'); 
    }
    public function totalCurrentMonthPurchasesQty($user_id = null)
    {
        if(!$user_id)
            $user_id = Auth::user()->id;
        return Purchase::where('user_id',$user_id)
                        ->where('product_id',$this->id)
                        ->whereBetween('date',[Carbon::now()->startOfMonth(),Carbon::now()])
                        ->sum('qty'); 
    }
    public function totaPurchasesAmount($user_id = null)
    {
        if(!$user_id)
            $user_id = Auth::user()->id;
        return Purchase::where('user_id',$user_id)
                        ->where('product_id',$this->id)
                        ->sum('total_amount'); 
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
                        ->where('type','!=','test')
                        ->whereDate('sale_date',$date)
                        ->sum('qty'); 
        $test_sale = Sale::where('user_id',Auth::user()->id)
                        ->where('product_id',$this->id)
                        ->where('type','test')
                        ->whereDate('sale_date',$date)
                        ->sum('qty'); 
        return $total_sale - $test_sale;
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
        // dd($total_amount);
        $total_sale_amount = Sale::where('user_id',Auth::user()->id)
                        ->where('product_id',$this->id)
                        ->whereDate('sale_date',$date)
                        ->where('type','test')
                        ->sum('total_amount'); 
        return round($total_amount - $total_sale_amount);
    }
    public function totalCommulativeSaleAmount($date)
    {
        $total_amount = Sale::where('user_id',Auth::user()->id)
                        ->where('product_id',$this->id)
                        ->where('type','!=','test')
                        ->whereDate('sale_date',$date)
                        ->sum('total_amount'); 
        return round($total_amount);
    }
    public function totalDrAmount($start_date,$end_date)
    {
        $amountBalance = -(Auth::user()->getPurchasePrice($start_date,$this) * Auth::user()->getOpeningBalance($start_date,$this));
        $total_sales = Sale::where('user_id',Auth::user()->id)
                        ->where('product_id',$this->id)
                        ->whereBetween('sale_date', [$start_date,$end_date])
                        ->where('type','!=','test')
                        ->sum('total_amount'); 
        $test_sale = Sale::where('user_id',Auth::user()->id)
                        ->where('product_id',$this->id)
                        ->whereBetween('sale_date', [$start_date,$end_date])
                        ->where('type','test')
                        ->sum('total_amount'); 
        $sales = $total_sales - $test_sale;
        $total_purchases = Purchase::where('user_id',Auth::user()->id)
                        ->where('product_id',$this->id)
                        ->whereBetween('date', [$start_date,$end_date])
                        ->sum('total_amount'); 
        $amountBalance = $amountBalance - $total_purchases;
        $amountBalance = $amountBalance + $sales;
        return round($amountBalance);
    }
    public function getTotalDrAmount($end_date)
    {
        $start_date = Carbon::parse('2023-05-31'); 
        $amountBalance = Auth::user()->getPurchasePrice($start_date,$this) * Auth::user()->getOpeningBalance($start_date,$this);
        $total_sales = Sale::where('user_id',Auth::user()->id)
                        ->where('product_id',$this->id)
                        ->where('sale_date','<', $end_date)
                        ->where('type','!=','test')
                        ->sum('total_amount'); 
        $test_sale = Sale::where('user_id',Auth::user()->id)
                        ->where('product_id',$this->id)
                        ->where('sale_date','<', $end_date)
                        ->where('type','test')
                        ->sum('total_amount'); 
        $sales = $total_sales - $test_sale;
        $total_purchases = Purchase::where('user_id',Auth::user()->id)
                        ->where('product_id',$this->id)
                        ->where('date','<', $end_date)
                        ->sum('total_amount'); 
        $amountBalance = abs($amountBalance + $total_purchases);
        $amountBalance = abs($amountBalance - $sales);
        return round($amountBalance);
    }
    public function getSaleRate($date)
    {
        $sale = Sale::where('user_id',Auth::user()->id)
                        ->where('product_id',$this->id)
                        ->where('type','!=',['whole_sale','test'])
                        ->whereDate('sale_date',$date)
                        ->first(); 
        return $sale?$sale->price:$this->selling_amount;
    }
    public function getWholeSaleRate($date)
    {
        $sale = Sale::where('user_id',Auth::user()->id)
                        ->where('product_id',$this->id)
                        ->where('type','whole_sale')
                        ->whereDate('sale_date',$date)
                        ->first(); 
        return $sale?$sale->price:$this->selling_amount;
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
    
	/**
	 * @return string
	 */
	public function getSellingAmountAttribute() {
        $selling_amount = GlobalProductRate::where('user_id',Auth::user()->id)->where('product_id',$this->id)->first();
        if($selling_amount)
            return $selling_amount->selling_price;
		return @$this->selling_price;
	}
    public function getSaleForSupplier($date)
    {
        $sale = Purchase::where('product_id',$this->id)->whereDate('date',$date)->first();
        return $sale;
    }
    public function getClosingBalance($last_date)
    {
        $date = Carbon::parse($last_date);
        $date->addDay();
        $totalQtyStock = Purchase::where('user_id',Auth::user()->id)->where('product_id',$this->id)
                            ->whereDate('date','<',$date)
                            ->sum('qty');
        $totalAccessStock = Purchase::where('user_id',Auth::user()->id)->where('product_id',$this->id)
                            ->whereDate('date','<',$date)
                            ->sum('access');
        $totalStock = $totalQtyStock + $totalAccessStock;
        $totalSale = Sale::where('user_id',Auth::user()->id)
                        ->where('product_id',$this->id)
                        ->where('type','!=','test')
                        ->whereDate('sale_date','<',$date)
                        ->sum('qty');       
        $testSale = Sale::where('user_id',Auth::user()->id)
                        ->where('product_id',$this->id)
                        ->where('type','test')
                        ->whereDate('sale_date','<',$date)
                        ->sum('qty');
        $sale = $totalSale - $testSale;
        $avaiableStock = $totalStock - $sale;
        return $avaiableStock;
    }
}
