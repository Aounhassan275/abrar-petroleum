<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSiteIdToDebitCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('debit_credits', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id')->nullable()->after('user_id');
            $table->foreign('site_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('debit_credit_id')->nullable()->after('user_id');
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
            $table->dropColumn('site_id');
            $table->dropColumn('debit_credit_id');
        });
    }
}
