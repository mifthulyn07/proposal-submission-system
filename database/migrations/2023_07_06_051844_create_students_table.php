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
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("dosen_pa_id")->nullable();
            $table->string("nim")->nullable();
            $table->string("class")->nullable();
            $table->timestamps();

            // "cascade" -> if row users is deleted, id student will delete too  
            $table->foreign("user_id")->references("id")->on("users")->cascadeOnDelete();

            // "set null" -> if row id topic, lecturer1, lecturer2 is deleted, proposal will set null  
            $table->foreign("dosen_pa_id")->references("id")->on("lecturers")->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
