<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecturer', function (Blueprint $table) {
            $table->id('ID_lecturer');
            $table->unsignedBigInteger('ID_user');
            $table->foreign('ID_user')->references('ID_user')->on('user')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('ID_course');
            $table->foreign('ID_course')->references('ID_course')->on('course')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('lecturer');
    }
}
