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
        Schema::create('forum_question_reaction', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('question_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->tinyInteger('status')->default(2)->comment('0 = upvote, 1 = downvote, 2 = remove');

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
        Schema::dropIfExists('forum_question_reaction');
    }
};
