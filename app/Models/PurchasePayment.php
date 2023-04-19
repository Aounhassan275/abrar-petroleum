<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;

class PurchasePayment extends Model
{
    protected $fillable = [
        'date', 'amount','vendor_account_id','purchase_id','bank_account_id','image'
    ];
    
    protected $casts = [
        'date' => 'date',
    ];
    
    public function setImageAttribute($value){
        $this->attributes['image'] = ImageHelper::saveImage($value,'/uploaded_images/');
    }
    public function vendorAccount()
    {
        return $this->belongsTo(VendorAccount::class,'vendor_account_id');
    }
    public function purchase()
    {
        return $this->belongsTo(Purchase::class,'purchase_id');
    }
}
