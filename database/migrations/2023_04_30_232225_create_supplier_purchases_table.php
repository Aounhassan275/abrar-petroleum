<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('price');
            $table->string('qty');
            $table->string('access')->default(0);
            $table->string('total_amount');
            $table->string('status')->default('In Process');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->unsignedBigInteger('supplier_vehicle_id')->nullable();
            $table->foreign('supplier_vehicle_id')->references('id')->on('supplier_vehicles')->onDelete('cascade');
            $table->unsignedBigInteger('supplier_terminal_id')->nullable();
            $table->foreign('supplier_terminal_id')->references('id')->on('supplier_terminals')->onDelete('cascade');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier_purchases');
    }
}
