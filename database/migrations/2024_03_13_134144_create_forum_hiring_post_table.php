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
        Schema::create('forum_hiring_post', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('job_title')->nullable();
            $table->string('entity_name')->nullable();
            $table->tinyInteger('workplace')->nullable()->comment('0 = Onsite, 1 = Hybrid');
            $table->string('job_location')->nullable();
            $table->string('job_description')->nullable();
            $table->tinyInteger('job_type')->nullable()->comment('0 = Internship, 1 = Full-time, 2 = Part-time');
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
        Schema::dropIfExists('forum_hiring_post');
    }
};
