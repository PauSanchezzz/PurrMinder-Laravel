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
        Schema::create('evaluation', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('comments')->nullable();
            $table->integer('application_id');
            $table->integer('evaluationStatus_id');

            $table->foreign('application_id')->references('id')->on('adoptionApplication');
            $table->foreign('evaluationStatus_id')->references('id')->on('evaluationStatus');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation');
            }
};
