<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question', function (Blueprint $table) {
            $table->id('ID_question');
            $table->unsignedBigInteger('ID_quiz');
            $table->foreign('ID_quiz')->references('ID_quiz')->on('quiz')->onDelete('cascade')->onUpdate('cascade');
            $table->string('question');
            $table->string('option_one');
            $table->string('option_two');
            $table->string('option_three');
            $table->string('option_four');
            $table->string('correctAnswer');
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
        Schema::dropIfExists('question');
    }
}
