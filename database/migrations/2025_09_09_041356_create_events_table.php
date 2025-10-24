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
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // EventID

            $table->string('event_name', 100)->nullable();
            $table->date('event_date')->nullable();
            $table->time('event_time')->nullable();
            $table->string('location', 100)->nullable();
            $table->text('attendees')->nullable();
            $table->text('description')->nullable();
            $table->string('attach', 255)->nullable();

            // Foreign keys
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->foreign('supervisor_id')
                ->references('id')
                ->on('supervisors')
                ->onDelete('cascade');

            $table->foreignId('student_id')
                ->nullable()
                ->constrained('students')
                ->onDelete('cascade');

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
