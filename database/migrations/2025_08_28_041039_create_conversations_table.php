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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // group chat có tên
            $table->string('name')->nullable();
            // 1-1 hay group
            $table->boolean('is_direct')->default(true);

            // xóa user => xóa conversation do user tạo (tùy chọn)
            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();
                
            // phục vụ list/sort
            $table->index(['is_direct', 'updated_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
