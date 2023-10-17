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
            $table->foreignId("topic_id")->nullable()->constrained()->onDelete('set null');
            $table->foreignId("student_id")->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('nim');
            $table->enum('type', ['thesis', 'appropriate_technology', 'journal'])->nullable();
            $table->string('title');
            $table->year('year');
            $table->enum('status', ['done', 'on_process']);
            $table->string('adding_topic')->nullable();
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
