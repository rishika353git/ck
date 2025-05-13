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
        Schema::create('premium', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('monthly_amount')->nullable();
            $table->integer('yearly_amount')->nullable();
            $table->string('posts')->nullable();
            $table->string('blue_tick')->nullable()->comment('1 = yes, 0 = no' );
            $table->string('status')->default(1);
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
        Schema::dropIfExists('premium');
    }
};
