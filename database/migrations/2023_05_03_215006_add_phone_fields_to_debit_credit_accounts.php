<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneFieldsToDebitCreditAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('debit_credit_accounts', function (Blueprint $table) {
            $table->string('phone')->nullable()->before('created_at');
            $table->string('address')->nullable()->before('created_at');  
            $table->string('designation')->nullable()->before('created_at');  
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
            $table->dropColumn('phone');
            $table->dropColumn('address');
            $table->dropColumn('designation');
        });
    }
}
