<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('seller_id')->nullable();
            $table->string('seller_is')->nullable();
            $table->bigInteger('order_id')->nullable();
            $table->bigInteger('customer_id')->nullable();
            $table->decimal('seller_amount', 8,2)->default(0.00);
            $table->decimal('admin_commission', 8,2)->default(0.00);
            $table->string('received_by')->nullable();
            $table->string('status')->nullable();
            $table->decimal('delivery_charge', 8,2)->default(0.00);
            $table->decimal('tax', 8,2)->default(0.00);
            $table->string('delivered_by')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();


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
        Schema::dropIfExists('order_transactions');
    }
}
