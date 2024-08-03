<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupplierPurchaseIdToDebitCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('debit_credits', function (Blueprint $table) {
            $table->unsignedBigInteger('supplier_purchase_id')->nullable()->after('user_id');
            $table->foreign('supplier_purchase_id')->references('id')->on('supplier_purchases')->onDelete('cascade');
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
            $table->dropColumn('supplier_purchase_id');
        });
    }
}
