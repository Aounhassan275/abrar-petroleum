<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Validator::extend('qty_access_check', function ($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();
            $key = str_replace(['qty.', 'access.', 'shortage.'], '', $attribute);
            $qty = $data['qty'][$key] ?? 0;
            $access = $data['access'][$key] ?? 0;
            $shortage = $data['shortage'][$key] ?? 0;

            if (($qty == 0 && $shortage == 0 && $access > 0) || ($qty > 0 && $access == 0 && $shortage == 0) || ($shortage > 0 && $access == 0 && $qty == 0)) {
                return true;
            }

            return false;
        },'You can only add quantity, access or shortage at one time.');
    }
}
