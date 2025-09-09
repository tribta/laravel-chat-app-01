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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // để trống nếu sau này gửi file-only
            $table->text('body')->nullable();

            $table->foreignId('conversation_id')
                ->constrained()
                ->cascadeOnDelete();

            // người gửi
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // phân trang cột conversation_id theo thời gian
            $table->index(['conversation_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
