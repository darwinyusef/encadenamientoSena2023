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
        Schema::create('selection', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('students_id')->nullable();
            $table->foreign('students_id')->references('id')->on('students');
            $table->unsignedBigInteger('programs_a')->nullable();
            $table->foreign('programs_a')->references('id')->on('programs');
            $table->unsignedBigInteger('programs_b')->nullable();
            $table->foreign('programs_b')->references('id')->on('programs');
            $table->timestamp('accept', $precision = 0)->nullable();
            $table->boolean('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('selection');
    }
};
