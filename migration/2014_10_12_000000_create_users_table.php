<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();

            $table->string('f_name')->nullable();
            $table->string('l_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('image')->default('img1.jpg');
            $table->string('street_address')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('zip')->nullable();
            $table->string('house_no')->nullable();
            $table->string('apartment_no')->nullable();
            $table->string('cm_firebase_token')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->string('payment_card_last_four')->nullable();
            $table->string('payment_card_brand')->nullable();
            $table->string('login_medium')->nullable();
            $table->string('social_id')->nullable();
            $table->tinyInteger('is_phone_verified')->default(0);
            $table->string('temporary_token')->nullable();
            $table->tinyInteger('is_email_verified')->default(0);




            
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
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
        Schema::dropIfExists('users');
    }
};
