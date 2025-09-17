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
        Schema::create('student_participations', function (Blueprint $table) {
            $table->id(); // ParticipationID
            $table->text('description')->nullable();
            $table->string('attendance_status', 50)->nullable();
            $table->text('feedback')->nullable();

            // Foreign keys
            $table->foreignId('student_id')
                ->nullable()
                ->constrained('students')
                ->onDelete('cascade');

            $table->unsignedBigInteger('event_id')->nullable();
            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_participations');
    }
};
