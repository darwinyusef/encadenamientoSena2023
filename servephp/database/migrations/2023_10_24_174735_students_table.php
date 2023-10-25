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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('allname')->nullable();
            $table->string('email')->nullable();
            $table->string('document')->nullable();
            $table->string('typedocument')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_attendant')->nullable();
            $table->string('ie')->nullable();
            $table->boolean('active')->nullable($value = true);
            $table->enum('register', ['INITIAL', 'CONNECTED', 'SELECTION', 'REGISTERED', 'ALL_DOCUMENT']); // CONECTED = CONTECTADO, REGISTERD = MATRICULADO
            $table->timestamp('asistencia', $precision = 0)->nullable();
            $table->timestamp('personal_data', $precision = 0)->nullable();
            $table->timestamp('modify_document', $precision = 0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('students');
    }
};
