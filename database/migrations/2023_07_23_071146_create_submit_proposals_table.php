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
        Schema::create('submit_proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId("proposal_process_id")->constrained()->cascadeOnDelete();
            $table->foreignId("topic_id")->nullable()->constrained()->onDelete('set null');
            $table->string("title");
            $table->bigInteger("similarity")->nullable();
            $table->string("proposal");
            $table->string("adding_topic")->nullable();
            $table->boolean("accord")->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submit_proposals');
    }
};
