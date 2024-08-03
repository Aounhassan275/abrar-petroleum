<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccessAndShortageColumnToSupplierPurchases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supplier_purchases', function (Blueprint $table) {
            $table->string('access_total_amount')->default(0)->nullable()->after('access');
            $table->string('shortage')->default(0)->nullable()->after('access');
            $table->string('shortage_total_amount')->default(0)->nullable()->after('access');
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
            $table->dropColumn('access_total_amount');
            $table->dropColumn('shortage');
            $table->dropColumn('shortage_total_amount');
        });
    }
}
