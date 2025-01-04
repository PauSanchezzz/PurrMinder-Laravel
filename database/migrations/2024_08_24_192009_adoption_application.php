<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('adoptionApplication', function (Blueprint $table){
            $table->id()->autoIncrement();
            $table->integer('cat_id');
            $table->integer('adopter_id');

            $table->foreign('adopter_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adoptionApplication');
    }
};
