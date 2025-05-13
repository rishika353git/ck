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
            // first api
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile')->unique();
            $table->string('password');
            // otp verifection api
            $table->timestamp('mobile_verified_at')->nullable();
            $table->boolean('mobile_verified')->default(0)->comment('0 = pending, 1 = verified');
            // user roll api
            $table->boolean('user_roll')->default(0)->comment('1 = student, 2 = advocate');
            // card store and verifection api
            $table->string('card_front')->nullable();
            $table->string('card_back')->nullable();
            $table->boolean('card_verified')->default(0)->comment('0 = pending, 1 = approve, 2 = reject, 3 = blocked');
            // profile update api
            $table->string('profile')->default('profile not updated');
            $table->rememberToken();
            $table->string('reason')->nullable();
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
