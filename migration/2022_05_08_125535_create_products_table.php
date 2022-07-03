<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('added_by')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('category_ids')->nullable();
            $table->integer('brand_id')->nullable();
            $table->string('unit')->nullable();
            $table->integer('min_qty')->default(1);
            $table->tinyInteger('refundable')->default(1);
            $table->string('images')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('featured')->nullable();
            $table->string('flash_deal')->nullable();
            $table->string('video_provider')->nullable();
            $table->string('video_url')->nullable();
            $table->string('colors')->nullable();
            $table->tinyInteger('variant_product')->default(0);
            $table->string('attributes')->nullable();
            $table->text('choice_options')->nullable();
            $table->text('variation')->nullable();
            $table->tinyInteger('published')->default(0);
            $table->double('unit_price')->default(0);
            $table->double('purchase_price')->default(0);
            $table->string('tax')->nullable();
            $table->string('tax_type')->nullable();
            $table->double('discount')->default(0);
            $table->string('discount_type')->nullable();
            $table->integer('current_stock')->nullable();
            $table->text('details')->nullable();
            $table->tinyInteger('free_shipping')->default(0);
            $table->string('attachment')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('featured_status')->default(1);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_image')->nullable();
            $table->tinyInteger('request_status')->default(0);
            $table->string('denied_note')->nullable();
            $table->double('shipping_cost', 8,2)->nullable();
            $table->tinyInteger('multiply_qty')->nullable();
            $table->double('temp_shipping_cost',8,2)->nullable();
            $table->tinyInteger('is_shipping_cost_updated')->nullable();

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
        Schema::dropIfExists('products');
    }
}
