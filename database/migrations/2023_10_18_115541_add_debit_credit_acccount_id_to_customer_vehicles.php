<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDebitCreditAcccountIdToCustomerVehicles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_vehicles', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('debit_credit_account_id')->nullable();
            $table->foreign('debit_credit_account_id')->references('id')->on('debit_credit_accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_vehicles', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('debit_credit_account_id');
        });
    }
}
