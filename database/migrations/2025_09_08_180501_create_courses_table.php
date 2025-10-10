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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->string('title', 100)->nullable();
            $table->string('specialization', 100)->nullable();
            $table->string('semester', 50)->nullable();
            $table->string('image')->nullable();
            $table->unsignedTinyInteger('difficulty')->default(1)->comment('1 = سهل ، 10 = صعب');

            // Foreign key to students table
            $table->foreignId('student_id')
                ->nullable()
                ->constrained('students')
                ->onDelete('cascade');
            $table->foreignId('year_id')
                ->nullable()
                ->constrained('years')
                ->onDelete('cascade');
            $table->foreignId('supervisor_id')
                ->constrained('supervisors')
                ->onDelete('cascade');
            $table->foreignId('specialization_id')
                ->nullable()
                ->constrained('specializations')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
