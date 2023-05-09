<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('survey_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('answer_id')->nullable();
            $table->string('respondent_ident', 50);
            $table->longText('answer');
            $table->timestamps();
            
            $table->foreign('survey_id')->references('id')->on('surveys');
            $table->index('survey_id');
            $table->foreign('question_id')->references('id')->on('questions');
            $table->index('question_id');
            $table->foreign('answer_id')->references('id')->on('answers');
            $table->index('answer_id');
            $table->index('respondent_ident');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('responses');
    }
}