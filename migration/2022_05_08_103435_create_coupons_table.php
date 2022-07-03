<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_type')->nullable();
            $table->string('title')->nullable();
            $table->string('code')->nullable();
            $table->string('start_date')->nullable();
            $table->string('expire_date')->nullable();
            $table->decimal('min_purchase', 8, 2)->default(0.00);
            $table->decimal('max_discount', 8, 2)->default(0.00);
            $table->decimal('discount', 8, 2)->default(0.00);
            $table->string('discount_type')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('limit')->nullable();

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
        Schema::dropIfExists('coupons');
    }
}
