<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('answerQuestions', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('answer');
            $table->integer('question_id');
            $table->integer('application_id');

            $table->foreign('application_id')->references('id')->on('adoptionApplication');
            $table->foreign('question_id')->references('id')->on('questionsForm');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answerQuestions');
    }
};
