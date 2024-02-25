<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::connection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId("topic_id")->nullable()->constrained()->onDelete('set null');
            $table->foreignId("student_id")->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('nim')->nullable();
            $table->enum('type', ['thesis', 'appropriate_technology', 'journal'])->nullable();
            $table->string('title');
            $table->string('year');
            $table->enum('status', ['done', 'on_process']);
            $table->string('adding_topic')->nullable();
            $table->string('comment')->nullable();
            $table->string('slug')->nullable()->unique();
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
