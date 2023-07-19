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
            $table->foreignId("topic_id")->constrained()->nullable();
            $table->foreignId("student_id")->constrained();
            $table->string('name')->nullable();
            $table->string('nim')->nullable();
            $table->enum('type', ['skripsi', 'teknologi_tepat_guna', 'jurnal'])->nullable();
            $table->string('title');
            $table->year('year');
            $table->string('status');
            $table->timestamps();
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
