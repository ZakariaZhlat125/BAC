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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->nullable();
            $table->text('description')->nullable();
            $table->enum('type', ['explain', 'summary']);
            $table->text('reason')->nullable();
            $table->string('file')->nullable();
            $table->string('video')->nullable();
            // Foreign keys
            $table->foreignId('student_id')
                ->nullable()
                ->constrained('students')
                ->onDelete('cascade');

            $table->foreignId('supervisor_id')
                ->nullable()
                ->constrained('supervisors')
                ->onDelete('cascade');
            $table->foreignId('chapter_id')
                ->constrained('chapters')
                ->onDelete('cascade');
            // Enum instead of string
            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
