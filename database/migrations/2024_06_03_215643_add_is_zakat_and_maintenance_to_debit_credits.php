<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsZakatAndMaintenanceToDebitCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('debit_credits', function (Blueprint $table) {
            $table->boolean('is_zakat')->nullable()->default(0)->after('is_salary_transfer');
            $table->boolean('is_maintenance')->nullable()->default(0)->after('is_salary_transfer');
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
            $table->dropColumn('is_zakat');
            $table->dropColumn('is_maintenance');
        });
    }
}
