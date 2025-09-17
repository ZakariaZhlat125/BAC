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
        Schema::create('summaries', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50); // مثل (اقتراح، تعديل، ملاحظات)
            $table->text('notes')->nullable(); // الملخص / الملاحظات من المشرف
            $table->foreignId('content_id')
                ->constrained('contents')
                ->onDelete('cascade');
            $table->foreignId('supervisor_id')
                ->constrained('supervisors')
                ->onDelete('cascade');

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('summaries');
    }
};
