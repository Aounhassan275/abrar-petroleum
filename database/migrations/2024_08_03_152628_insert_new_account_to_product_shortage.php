<?php

use App\Models\DebitCreditAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertNewAccountToProductShortage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DebitCreditAccount::create([
            'name' => 'Product Shortage',
            'account_category_id' => 6,
        ]);  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
