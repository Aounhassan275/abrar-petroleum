<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPetrolAndDieselRedZoneToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('petrol_red_zone')->nullable()->after('type');
            $table->string('diesel_red_zone')->nullable()->after('type');
            $table->string('petrol_low_stock')->nullable()->after('type');
            $table->string('diesel_low_stock')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('petrol_red_zone');
            $table->dropColumn('diesel_red_zone');
            $table->dropColumn('petrol_low_stock');
            $table->dropColumn('diesel_low_stock');
        });
    }
}
