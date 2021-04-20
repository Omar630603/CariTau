<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score', function (Blueprint $table) {
            $table->id('ID_score');
            $table->unsignedBigInteger('ID_question');
            $table->foreign('ID_question')->references('ID_question')->on('question')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('ID_user');
            $table->foreign('ID_user')->references('ID_user')->on('user')->onDelete('cascade')->onUpdate('cascade');
            $table->string('userAnswer');
            $table->Integer('score');
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
        Schema::dropIfExists('score');
    }
}
