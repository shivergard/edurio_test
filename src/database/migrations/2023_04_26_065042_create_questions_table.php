<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained()->onDelete('cascade');
            $table->longText('text');
            $table->smallInteger('type');
            $table->timestamps();

            // Adding Indexes
            $table->index('survey_id');
            $table->index('type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
