<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerVehicleToDebitCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('debit_credits', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_vehicle_id')->nullable()->after('is_hide');
            $table->foreign('customer_vehicle_id')->references('id')->on('customer_vehicles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('debit_credits', function (Blueprint $table) {
            $table->dropColumn('customer_vehicle_id');
        });
    }
}
