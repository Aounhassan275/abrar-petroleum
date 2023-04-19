<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $fillable = [
        'name','phone','email','address','home_content'
    ];
    public static function name(){
        $information = Information::find(1);
        return @$information->name;
    }
    public static function phone(){
        $information = Information::find(1);
        return @$information->phone;
    }
    public static function email(){
        $information = Information::find(1);
        return @$information->email;
    }
    public static function address(){
        $information = Information::find(1);
        return @$information->address;
    }
    public static function homeContent(){
        $information = Information::find(1);
        return @$information->home_content;
    }
}
