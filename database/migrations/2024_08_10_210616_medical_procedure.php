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
        Schema::create('medicalProcedure', function (Blueprint $table) {
            $table->id();
            $table->date('dateMedicalProcedure');
            $table->decimal('CostMedicalProcedure',10,3);
            $table->string('commentsMedicalProcedure')->nullable();
            $table->string('supportMedicalProcedure')->nullable();
            $table->integer('cat_id');
            $table->integer('typeMedicalProcedure_id');

            $table->foreign('typeMedicalProcedure_id')->references('idTypeMedicalProcedure')->on('typeMedicalProcedure');
            $table->foreign('cat_id')->references('id')->on('cats');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
