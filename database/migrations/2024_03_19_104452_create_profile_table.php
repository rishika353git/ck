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
        Schema::create('profile', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->unsignedInteger('year_of_enrollment')->default(0);
            $table->string('current_designation')->default("");
            $table->json('previous_experiences');
            $table->json('home_courts');
            $table->json('area_of_practice');
            $table->string('law_school')->default("");
            $table->string('batch')->default("");
            $table->string('linkedin_profile')->nullable(); // Changed to nullable
            $table->text('description')->nullable(); // Changed default("") to nullable()
            $table->string('profile_tagline')->default("");
            $table->json('top_5_skills');
            $table->boolean('total_follow')->default(false); // Changed to boolean and default value
            $table->unsignedInteger('total_followers')->default(0);
            $table->unsignedInteger('questions_asked')->default(0);
            $table->unsignedInteger('answers_given')->default(0);
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
        Schema::dropIfExists('profile');
    }
};
