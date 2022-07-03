<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->nullable();
            $table->string('customer_type')->nullable();
            $table->string('payment_status')->default('unpaid');
            $table->string('order_status')->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('transaction_ref')->nullable();
            $table->double('order_amount')->default(0);
            $table->text('shipping_address')->nullable();
            $table->double('discount_amount')->default(0);
            $table->string('discount_type')->nullable();
            $table->string('coupon_code')->nullable();
            $table->integer('shipping_method_id')->nullable();
            $table->double('shipping_cost', 8,2)->default(0.00);
            $table->string('order_group_id')->default('def-order-group');
            $table->string('verification_code')->default(0);
            $table->bigInteger('seller_id')->nullable();
            $table->string('seller_is')->nullable();
            $table->text('shipping_address_data')->nullable();
            $table->bigInteger('delivery_man_id')->nullable();
            $table->text('order_note')->nullable();
            $table->bigInteger('billing_address')->nullable();
            $table->text('billing_address_data')->nullable();
            $table->string('order_type')->nullable();
            $table->double('extra_discount', 8,2)->default(0.00);
            $table->string('extra_discount_type')->nullable();
            $table->tinyInteger('checked')->default(0);
            $table->string('shipping_type')->nullable();
            $table->string('delivery_type')->nullable();
            $table->string('delivery_service_name')->nullable();
            $table->string('third_party_delivery_tracking_id')->nullable();


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
        Schema::dropIfExists('orders');
    }
}
