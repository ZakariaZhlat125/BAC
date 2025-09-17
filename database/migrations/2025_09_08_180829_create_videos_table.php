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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->text('video_url')->nullable();
            $table->text('description')->nullable();

            // Foreign keys
            $table->foreignId('student_id')
                ->nullable()
                ->constrained('students')
                ->onDelete('cascade');

            $table->unsignedBigInteger('chapter_id')->nullable();
            $table->foreign('chapter_id')
                ->references('id')
                ->on('chapters')
                ->onDelete('cascade');

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
