<?php

use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/******************ADMIN PANELS ROUTES****************/
Route::group(['prefix' => 'admin', 'as'=>'admin.','namespace' => 'Admin',], function () {
 
  /*******************LOGIN ROUTES*************/
  Route::view('login', 'admin.auth.index')->name('login');
  Route::post('login','AuthController@login');
  /******************MESSAGE ROUTES****************/
  Route::resource('message', 'MessageController');
  Route::group(['middleware' => 'auth:admin'], function () { 
    /*******************Logout ROUTES*************/       
    Route::get('logout','AuthController@logout')->name('logout'); 
    /*******************Dashoard ROUTES*************/
    Route::view('dashboard', 'admin.dashboard.index')->name('dashboard.index');
    /******************ADMIN ROUTES****************/
      Route::resource('admin', 'AdminController');    
      /******************Supplier ROUTES****************/
      Route::resource('supplier', 'SupplierController');    
    /******************Product ROUTES****************/
      Route::resource('product', 'ProductController');   
    /******************Expense Type ROUTES****************/
      Route::resource('expense_type', 'ExpenseTypeController');    
    /*******************Profile ROUTES*************/
    Route::view('profile', 'admin.profile.index')->name('profile.index');
    Route::view('messages', 'admin.message.index')->name('messages.index');
    /******************Information ROUTES****************/
    Route::resource('information', 'InformationController');
    /******************USER PROFILE  ROUTES****************/
    Route::resource('user', 'UserController');  
    /******************BANK ROUTES****************/
    Route::resource('bank', 'BankController');  
    /******************Account Category ROUTES****************/
    Route::resource('account_category', 'AccountCategoryController');  
    /******************Debit Credit Account ROUTES****************/
    Route::resource('debit_credit_account', 'DebitCreditAccountController');  
    /******************Global Product Rate ROUTES****************/
    Route::resource('global_product_rate', 'GlobalProductRateController');  
  });
});

/******************USER PANELS ROUTES****************/
Route::group(['prefix' => 'user', 'as'=>'user.','namespace' => 'User'], function () {
 
  /*******************LOGIN ROUTES*************/
  Route::view('login', 'user.auth.index')->name('login');
  Route::post('login','AuthController@login');
   /******************REGISTERED ROUTES****************/
  Route::view('register', 'user.auth.register')->name('register');
  Route::post('register','AuthController@register')->name('register');
  Route::group(['middleware' => 'auth:user'], function () { 
    /*******************Logout ROUTES*************/       
    Route::get('logout','AuthController@logout')->name('logout');
    /*******************Dashoard ROUTES*************/
    Route::view('dashboard', 'user.dashboard.index')->name('dashboard.index');
    /******************USER PROFILE  ROUTES****************/
    Route::resource('user', 'UserController');  
    /******************Vendor ROUTES****************/
    Route::post('vendor/get_vendor_terminals','VendorController@getVendorTerminal')->name('vendor.get_vendor_terminals');
    Route::resource('vendor', 'VendorController');  
    /******************Vendor Terminal ROUTES****************/
    Route::resource('vendor_terminal', 'VendorTerminalController');  
    /******************Vendor Account ROUTES****************/
    Route::resource('vendor_account', 'VendorAccountController');  
    /******************PURCHASE ROUTES****************/
    Route::resource('purchase', 'PurchaseController');  
    /******************PURCHASE PAYMENTS ROUTES****************/
    Route::resource('purchase_payment', 'PurchasePaymentController');  
    /******************Product ROUTES****************/
    Route::post('product/get_price','ProductController@getPrice')->name('product.get_price');
    Route::resource('product', 'ProductController');  
    /******************OWN BANK ACCOUNTS ROUTES****************/
    Route::resource('bank_account', 'BankAccountController');  
    /******************MACHINE ROUTES****************/
    Route::post('machine/get_meter_reading','MachineController@getMeterReading')->name('machine.get_meter_reading');
    Route::resource('machine', 'MachineController');  
    /******************CUSTOMER ROUTES****************/
    Route::post('customer/get_customer_vehicle','CustomerController@getCustomerVehicle')->name('customer.get_customer_vehicle');
    Route::resource('customer', 'CustomerController');  
    /******************CUSTOMER VEHICLE ROUTES****************/
    Route::resource('customer_vehicle', 'CustomerVehicleController');  
    /******************CUSTOMER TRANSCATION ROUTES****************/
    Route::resource('customer_transcation', 'CustomerTranscationController');  
    /******************SALE ROUTES****************/
    Route::post('sale/get_sale_details', 'SaleController@getSaleDetails')->name('sale.getSaleDetails');  
    Route::post('sale/delete_sale_for_misc', 'SaleController@deleteSaleForMisc')->name('sale.delete_sale_for_misc');  
    Route::post('sale/delete_sale', 'SaleController@deleteSale')->name('sale.delete_sale');  
    Route::post('sale/update_sale_rate', 'SaleController@updateSaleRate')->name('sale.update_sale_rate');  
    Route::resource('sale', 'SaleController');  
    /******************EXPENSE ROUTES****************/
    Route::resource('expense', 'ExpenseController');  
    //
    Route::post('debit_credit/get_credit_fields', 'DebitCreditController@getCreditFields')->name('debit_credit.get_credit_fields');  
    Route::post('debit_credit/calculate_debit_credit_values', 'DebitCreditController@calculateDebitCreditValues')->name('debit_credit.calculate_debit_credit_values');  
    Route::post('debit_credit/get_color', 'DebitCreditController@getColor')->name('debit_credit.get_color');  
    Route::post('debit_credit/update_form', 'DebitCreditController@updateForm')->name('debit_credit.update_form');  
    Route::post('debit_credit/delete', 'DebitCreditController@delete')->name('debit_credit.delete');  
    Route::resource('debit_credit', 'DebitCreditController');  
    /******************Account Category ROUTES****************/
    Route::resource('account_category', 'AccountCategoryController');  
    /******************Employee ROUTES****************/
    Route::resource('employee', 'EmployeeController');  
    /******************Reports ROUTES****************/
    Route::get('reports', 'ReportsController@index')->name('reports.index');  
    /******************Debit Credit Accounts ROUTES****************/
    Route::resource('debit_credit_account', 'DebitCreditAccountController');  
  });
});

/******************SUPPLIER PANELS ROUTES****************/
Route::group(['prefix' => 'supplier', 'as'=>'supplier.','namespace' => 'Supplier'], function () {
 
  /*******************LOGIN ROUTES*************/
  Route::view('login', 'supplier.auth.index')->name('login');
  Route::post('login','AuthController@login');
  Route::group(['middleware' => 'auth:supplier'], function () { 
    /*******************Logout ROUTES*************/       
    Route::get('logout','AuthController@logout')->name('logout');
    /*******************Dashoard ROUTES*************/
    Route::view('dashboard', 'supplier.dashboard.index')->name('dashboard.index');
    /******************OWN BANK ACCOUNTS ROUTES****************/
    Route::resource('bank_account', 'BankAccountController');  
    /******************Vendor Terminal ROUTES****************/
    Route::resource('vendor_terminal', 'VendorTerminalController');  
    /******************Vendor Account ROUTES****************/
    Route::resource('vendor_account', 'VendorAccountController');  
    /******************SALES ROUTES****************/
    Route::resource('sale', 'PurchaseController');  
    /******************PURCHASE PAYMENTS ROUTES****************/
    Route::resource('purchase_payment', 'PurchasePaymentController');  
    /******************Product ROUTES****************/
    Route::post('product/get_price','ProductController@getPrice')->name('product.get_price');
    Route::resource('product', 'ProductController');
    /******************SUPPLIER TERMINAL ROUTES****************/
    Route::resource('terminal', 'SupplierTerminalController'); 
    /******************SUPPLIER Vehicle ROUTES****************/
    Route::resource('vehicle', 'SupplierVehicleController'); 
    /******************SUPPLIER Purchase ROUTES****************/
    Route::resource('purchase', 'SupplierPurchaseController'); 
  });
});


/******************FRONTEND ROUTES****************/
Route::view('/', 'front.home.index')->name('home.index');
/******************FUNCTIONALITY ROUTES****************/
Route::get('/migrate/install', function() {
  Artisan::call('config:cache');
  Artisan::call('migrate:refresh');
  Artisan::call('db:seed', [ '--class' => DatabaseSeeder::class]);
  Artisan::call('view:clear');
  return 'DONE';
});
Route::get('/migrate', function() {
  Artisan::call('migrate');
  return 'Migration done';
});
Route::get('/cache_clear', function() {
  Artisan::call('config:cache');
  Artisan::call('view:clear');
  Artisan::call('cache:clear');
  return 'Cache Clear DOne';
});
Route::get('/round_figure', function() {
  $purchases =  Purchase::all();
  foreach($purchases as $purchase)
  {
    if($purchase->access > 0)
    {
      $purchase->update([
        'total_amount' => $purchase->access * $purchase->price,
        'access_total_amount' => $purchase->access * $purchase->price
      ]);
    }else{
      $purchase->update([
        'total_amount' => $purchase->qty * $purchase->price,
      ]);
    }
  }
  return 'Sale DOne';
});

