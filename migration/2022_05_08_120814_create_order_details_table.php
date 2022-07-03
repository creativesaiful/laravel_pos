<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('seller_id')->nullable();
            $table->text('product_details')->nullable();
            $table->integer('qty')->default(0);
            $table->double('price', 8,2)->default(0.00);
            $table->double('tax', 8,2)->default(0.00);
            $table->double('discount', 8,2)->default(0.00);
            $table->string('delivery_status')->default('pending');
            $table->string('payment_status')->default('unpaid');
            $table->integer('shipping_method_id')->nullable();
            $table->string('variant')->nullable();
            $table->string('variation')->nullable();
            $table->string('discount_type')->nullable();
            $table->tinyInteger('is_stock_decreased')->default(1);
            $table->integer('refund_request')->default(0);



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
        Schema::dropIfExists('order_details');
    }
}
