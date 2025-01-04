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
        Schema::create('death', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->date('dateOfDeath');
            $table->decimal('associatedCosts',10,3);
            $table->string('comments')->nullable();
            $table->integer('cat_id');
            $table->integer('reasonOfDeath_id');

            $table->foreign('cat_id')->references('id')->on('cats');
            $table->foreign('reasonOfDeath_id')->references('idReasonOfDeath')->on('reasonOfDeath');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('death');
    }
};
