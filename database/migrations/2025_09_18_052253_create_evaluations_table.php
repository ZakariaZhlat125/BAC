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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('rating'); // مثال: 1 إلى 5 نجوم
            $table->text('feedback')->nullable(); // ملاحظات التقييم

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // العلاقة مع المحتوى
            $table->foreignId('content_id')
                ->constrained('contents')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
