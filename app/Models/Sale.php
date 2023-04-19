<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'type','sale_mode','previous_reading','current_reading','qty','price','total_amount',
        'user_id','machine_id','product_id','customer_id','customer_vehicle_id','sale_date'
    ];
    protected $casts = [
        'sale_date' => 'date',
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function site()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    public function machine()
    {
        return $this->belongsTo(Machine::class,'machine_id');
    }
    public function vehicle()
    {
        return $this->belongsTo(CustomerVehicle::class,'customer_vehicle_id');
    }
}
