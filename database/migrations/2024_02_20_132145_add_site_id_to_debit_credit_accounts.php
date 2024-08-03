<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSiteIdToDebitCreditAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('debit_credit_accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id')->nullable()->after('user_id');
            $table->foreign('site_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('debit_credit_accounts', function (Blueprint $table) {
            $table->dropColumn('site_id');
        });
    }
}
