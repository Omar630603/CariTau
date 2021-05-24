<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Fix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quiz', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('material', function (Blueprint $table) {
            $table->string('image')->after('description')->default('Material_images/default.png');
        });
        Schema::table('file', function (Blueprint $table) {
            $table->string('file_title')->after('ID_material');
            $table->string('description')->after('file_title');
            $table->mediumText('icon')->after('description');
        });
        Schema::create('quiz_user', function (Blueprint $table) {
            $table->id('ID_quiz_user');
            $table->unsignedBigInteger('ID_user');
            $table->foreign('ID_user')->references('ID_user')->on('user')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('ID_quiz');
            $table->foreign('ID_quiz')->references('ID_quiz')->on('quiz')->onDelete('cascade')->onUpdate('cascade');
            $table->char('score');
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
        //
    }
}
