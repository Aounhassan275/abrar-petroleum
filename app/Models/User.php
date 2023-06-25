<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
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
        return $this->hasMany(Product::class)->orderby('display_order','ASC');
    }
    public function debitCredits()
    {
        return $this->hasMany(DebitCredit::class,'user_id');
    }
    public function debitCreditAccounts()
    {
        return $this->hasMany(DebitCreditAccount::class,'user_id');
    }
    public function employees()
    {
        return $this->hasMany(Employee::class,'user_id');
    }
    public function getPetrolMachine()
    {
        $productMachines = Machine::where('user_id',$this->id)->where('product_id',2)->get();
        return $productMachines;
    }
    public function getDieselMachine()
    {
        $productMachines = Machine::where('user_id',$this->id)->where('product_id',1)->get();
        return $productMachines;
    }
    public function getPetrolOpeningBalance($date)
    {
        $product = Product::where('name','PMG')->first();
        $totalQtyStock = Purchase::where('user_id',$this->id)->where('product_id',$product->id)
                            ->whereDate('date','<',$date)
                            ->sum('qty');
        $totalAccessStock = Purchase::where('user_id',$this->id)->where('product_id',$product->id)
                            ->whereDate('date','<',$date)
                            ->sum('access');
        $totalStock = $totalQtyStock + $totalAccessStock;
        $totalSale = Sale::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->where('type','!=','test')
                        ->whereDate('sale_date','<',$date)
                        ->sum('qty');       
        $testSale = Sale::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->where('type','test')
                        ->whereDate('sale_date','<',$date)
                        ->sum('qty');
        $sale = $totalSale - $testSale;
        $avaiableStock = $totalStock - $sale;
        return $avaiableStock;
    }
    public function getOpeningBalance($date,$product)
    {
        $totalQtyStock = Purchase::where('user_id',$this->id)->where('product_id',$product->id)
                            ->whereDate('date','<',$date)
                            ->sum('qty');
        $totalAccessStock = Purchase::where('user_id',$this->id)->where('product_id',$product->id)
                            ->whereDate('date','<',$date)
                            ->sum('access');
        $totalStock = $totalQtyStock + $totalAccessStock;
        $totalSale = Sale::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->where('type','!=','test')
                        ->whereDate('sale_date','<',$date)
                        ->sum('qty');       
        $testSale = Sale::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->where('type','test')
                        ->whereDate('sale_date','<',$date)
                        ->sum('qty');
        $sale = $totalSale - $testSale;
        $avaiableStock = $totalStock - $sale;
        return $avaiableStock;
    }
    public function getTodaySale($date,$product)
    {
        $todaySale = Sale::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->where('type','!=','test')
                        ->whereDate('sale_date',$date)
                        ->sum('qty');
        $testSale = Sale::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->where('type','test')
                        ->whereDate('sale_date',$date)
                        ->sum('qty');
        return $todaySale - $testSale;
    }
    public function getTodaySaleTotalAmount($date,$product)
    {
        $todaySale = Sale::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->where('type','!=','test')
                        ->whereDate('sale_date',$date)
                        ->sum('total_amount');
        $testSale = Sale::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->where('type','test')
                        ->whereDate('sale_date',$date)
                        ->sum('total_amount');
        return round($todaySale - $testSale);
        return $todaySale;
    }
    public function getTodayPurchaseTotalAmount($date,$product)
    {
        $todayPurchase = Purchase::where('user_id',$this->id)->where('product_id',$product->id)->whereDate('date',$date)->sum('total_amount');
        return round($todayPurchase);
    }
    public function getTodayPurchasePrice($date,$product)
    {
        $todayPurchase = Purchase::where('user_id',$this->id)->where('product_id',$product->id)->whereDate('date',$date)->first();
        return $todayPurchase ? $todayPurchase->price : 0;
    }
    public function getTodaySalePrice($date,$product)
    {
        $todaySale = Sale::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->where('type','retail_sale')
                        ->whereDate('sale_date',$date)
                        ->first();
        return $todaySale?$todaySale->price:0;
    }
    public function getTodayPetrolSale($date)
    {
        $product = Product::where('name','PMG')->first();
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
    public function getTodayPetrolSaleTotalAmount($date)
    {
        $product = Product::where('name','PMG')->first();
        $todaySale = Sale::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->where('type','retail_sale')
                        ->whereDate('sale_date',$date)
                        ->sum('total_amount');
        return $todaySale;
    }
    public function getTodayPetrolSalePrice($date)
    {
        $product = Product::where('name','PMG')->first();
        $todaySale = Sale::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->where('type','retail_sale')
                        ->whereDate('sale_date',$date)
                        ->first();
        return $todaySale?$todaySale->price:0;
    }
    public function getTodayPetrolPurchase($date)
    {
        $product = Product::where('name','PMG')->first();
        $todayPurchase = Purchase::where('user_id',$this->id)->where('product_id',$product->id)->whereDate('date',$date)->sum('qty');
        $todayAccessPurchase = Purchase::where('user_id',$this->id)->where('product_id',$product->id)->whereDate('date',$date)->sum('access');
        return $todayPurchase + $todayAccessPurchase;
    }
    public function getTodayPetrolPurchaseTotalAmount($date)
    {
        $product = Product::where('name','PMG')->first();
        $todayPurchase = Purchase::where('user_id',$this->id)->where('product_id',$product->id)->whereDate('date',$date)->sum('total_amount');
        return $todayPurchase;
    }
    public function getTodayPetrolPurchasePrice($date)
    {
        $product = Product::where('name','PMG')->first();
        $todayPurchase = Purchase::where('user_id',$this->id)->where('product_id',$product->id)->whereDate('date',$date)->first();
        return $todayPurchase ? $todayPurchase->price : 0;
    }
    public function getPurchasePrice($date,$product)
    {
        $todayPurchase = Purchase::where('user_id',$this->id)->where('product_id',$product->id)->whereDate('date',$date)->first();
        if(!$todayPurchase)
        {
            $todayPurchase = Purchase::where('user_id',$this->id)->where('product_id',$product->id)->whereDate('date','<',$date)->orderBy('date','DESC')->first();
        }
        return $todayPurchase ? $todayPurchase->price : 0;
    }
    public function getTodayPurchase($date,$product)
    {
        $todayPurchase = Purchase::where('user_id',$this->id)->where('product_id',$product->id)->whereDate('date',$date)->sum('qty');
        $todayAccessPurchase = Purchase::where('user_id',$this->id)->where('product_id',$product->id)->whereDate('date',$date)->sum('access');
        return $todayPurchase + $todayAccessPurchase;
    }
    public function totalExpense($start_date,$end_date)
    {
        $category_id = AccountCategory::where('name','Expenses & Income')->first()->id;
        $credit = DebitCredit::select('debit_credits.*','debit_credit_accounts.account_category_id as account_category_id')
            ->join('debit_credit_accounts', 'debit_credits.account_id', 'debit_credit_accounts.id')
            ->where('debit_credits.user_id',Auth::user()->id)
            ->where('debit_credit_accounts.account_category_id',$category_id)
            ->whereBetween('debit_credits.sale_date', [$start_date,$end_date])->sum('credit');
        $debit = DebitCredit::select('debit_credits.*','debit_credit_accounts.account_category_id as account_category_id')
            ->join('debit_credit_accounts', 'debit_credits.account_id', 'debit_credit_accounts.id')
            ->where('debit_credits.user_id',Auth::user()->id)
            ->where('debit_credit_accounts.account_category_id',$category_id)
            ->whereBetween('debit_credits.sale_date', [$start_date,$end_date])
            ->sum('debit');
        return $credit - $debit;
    }
    public function getDieselOpeningBalance($date)
    {
        $product = Product::where('name','HSD')->first();
        $totalQtyStock = Purchase::where('user_id',$this->id)->where('product_id',$product->id)
                            ->whereDate('date','<',$date)
                            ->sum('qty');
        $totalAccessStock = Purchase::where('user_id',$this->id)->where('product_id',$product->id)
                            ->whereDate('date','<',$date)
                            ->sum('access');
        $totalStock = $totalQtyStock + $totalAccessStock;
        $totalSale = Sale::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->where('type','!=','test')
                        ->whereDate('sale_date','<',$date)
                        ->sum('qty');       
        $testSale = Sale::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->where('type','test')
                        ->whereDate('sale_date','<',$date)
                        ->sum('qty');
        $sale = $totalSale - $testSale;
        $avaiableStock = $totalStock - $sale;
        return $avaiableStock;
    }
    public function getTodayDieselSale($date)
    {
        $product = Product::where('name','HSD')->first();
        $todaySale = Sale::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->where('type','retail_sale')
                        ->whereDate('sale_date',$date)
                        ->sum('qty');
        $todayTestSale = Sale::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->where('type','test')
                        ->whereDate('sale_date',$date)
                        ->sum('qty');
        return $todaySale - $todayTestSale;
    }
    public function getTodayDieselPurchase($date)
    {
        $product = Product::where('name','HSD')->first();
        $todayPurchase = Purchase::where('user_id',$this->id)->where('product_id',$product->id)->whereDate('date',$date)->sum('qty');
        $todayAccessPurchase = Purchase::where('user_id',$this->id)->where('product_id',$product->id)->whereDate('date',$date)->sum('access');
        return $todayPurchase + $todayAccessPurchase;
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
    public function haveLastSale($date,$product = null)
    {   
        if($product){
            $next_date = date("Y-m-d",strtotime ( '+1 day' , strtotime ( $date ) )) ;
            if($this->haveSale($next_date,$product)->count() > 0)
            {
                return false;
            }
            if($this->haveSale($date,$product)->count() > 0)
            {
                return true;
            }
        }
        return false;
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
    public function getDip($date,$product)
    {   
        $dip = Dip::where('user_id',$this->id)
                        ->where('product_id',$product->id)
                        ->whereDate('date',$date)
                        ->first();  
        return $dip;
    }
    public function todaySaleAmount($date)
    {
        $todaySale = Sale::where('user_id',$this->id)
                        ->where('type','!=','test')
                        ->whereDate('sale_date',$date)
                        ->sum('total_amount');
        $testSale = Sale::where('user_id',$this->id)
                        ->where('type','test')
                        ->whereDate('sale_date',$date)
                        ->sum('total_amount');
        return $todaySale - $testSale;
    }
    
    public function globalProductRate()
    {
        return $this->belongsTo(GlobalProductRate::class,'user_id');
    }
}
