<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDebitCreditAccountIdColumnToSupplierPurchases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supplier_purchases', function (Blueprint $table) {
            $table->unsignedBigInteger('debit_credit_account_id')->nullable()->after('supplier_id');
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
        Schema::table('supplier_purchases', function (Blueprint $table) {
            $table->dropColumn('debit_credit_account_id');
        });
    }
}
