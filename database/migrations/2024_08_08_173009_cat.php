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
        Schema::create('cats', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('nameCat');
            $table->string('imageCat');
            $table->string('descriptionCat');
            $table->integer('ageCat');
            $table->integer('calendar_id');
            $table->double('weightCat');
            $table->integer('sexCat_id');
            $table->boolean('specialCondition');
            $table->integer('specialCondition_id')->nullable();
            $table->integer('catHealth_id');
            $table->integer('personality_id');
            $table->boolean('availabilityCat');

            $table->foreign('calendar_id')->references('idCalendar')->on('calendar');
            $table->foreign('sexCat_id')->references('idSex')->on('sex');
            $table->foreign('specialCondition_id')->references('idSpecialCondition')->on('specialCondition');
            $table->foreign('catHealth_id')->references('idCatHealth')->on('catHealth');
            $table->foreign('personality_id')->references('idSex')->on('sex');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cats');
    }
};
