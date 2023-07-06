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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('topic_id')->nullable();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('lecturer1_id')->nullable();
            $table->unsignedBigInteger('lecturer2_id')->nullable();
            $table->string('name')->nullable();
            $table->string('nim')->nullable();
            $table->enum('type', ['skripsi', 'teknologi_tepat_guna', 'jurnal'])->nullable();
            $table->string('title');
            $table->year('year');
            $table->string('status');
            $table->timestamps();

            // "cascade" -> if row student_id is deleted, id proposal will delete too  
            $table->foreign('student_id')->references('id')->on('students')->cascadeOnDelete();
            
            // "set null" -> if row id topic, lecturer1, lecturer2 is deleted, proposal will set null  
            $table->foreign('topic_id')->references('id')->on('topics')->nullOnDelete();
            $table->foreign('lecturer1_id')->references('id')->on('lecturers')->nullOnDelete();
            $table->foreign('lecturer2_id')->references('id')->on('lecturers')->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
