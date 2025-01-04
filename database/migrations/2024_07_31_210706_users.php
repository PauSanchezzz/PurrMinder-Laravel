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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name');
            $table->string('lastName');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('documentType_id');
            $table->bigInteger('documentNumber');
            $table->date('birthDate');
            $table->bigInteger('telephoneNumber');
            $table->integer('city_id')->nullable();
            $table->string('address');
            $table->integer('role_id');
            $table->integer('occupation')->nullable();

            $table->foreign('occupation')->references('idOccupation')->on('occupation');
            $table->foreign('city_id')->references('idCity')->on('city');
            $table->foreign('documentType_id')->references('idDocumentType')->on('documentType');
            $table->foreign('role_id')->references('idRole')->on('role');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
