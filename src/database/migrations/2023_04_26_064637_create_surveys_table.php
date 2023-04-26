<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration
{
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50);
            $table->longText('description');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

            // Adding Indexes
            $table->index('title');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('surveys');
    }
}
