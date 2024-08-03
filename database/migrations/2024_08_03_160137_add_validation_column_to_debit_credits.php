<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValidationColumnToDebitCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('debit_credits', function (Blueprint $table) {
            $table->boolean('supplier_validation')->default(1)->nullable()->after('supplier_purchase_id');
            $table->boolean('site_validation')->default(1)->nullable()->after('supplier_purchase_id');
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
            $table->dropColumn('supplier_validation');
            $table->dropColumn('site_validation');
        });
    }
}
