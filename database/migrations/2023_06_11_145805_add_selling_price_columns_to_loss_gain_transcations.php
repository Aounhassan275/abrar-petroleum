<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSellingPriceColumnsToLossGainTranscations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loss_gain_transcations', function (Blueprint $table) {
            $table->date('date')->nullable()->before('created_at');
            $table->double('old_selling_price')->nullable()->before('created_at');
            $table->double('new_selling_price')->nullable()->before('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loss_gain_transcations', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->dropColumn('old_selling_price');
            $table->dropColumn('new_selling_price');
        });
    }
}
