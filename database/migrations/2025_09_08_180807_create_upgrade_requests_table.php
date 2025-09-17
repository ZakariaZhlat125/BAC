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
        Schema::create('upgrade_requests', function (Blueprint $table) {
            $table->id();

            // Columns
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('reason');
            $table->text('attach_file');

            // Foreign keys
            $table->foreignId('student_id')
                ->nullable()
                ->constrained('students', 'id')
                ->onDelete('cascade');
            $table->foreignId('supervisor_id')
                ->nullable()
                ->constrained('supervisors', 'id')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upgrade_requests');
    }
};
