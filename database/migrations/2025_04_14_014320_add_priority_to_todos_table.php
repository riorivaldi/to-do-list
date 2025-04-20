<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('completed')->default(false); // Pastikan boolean
            $table->timestamps();
            $table->boolean('pinned')->default(false); // untuk sematkan
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium'); // untuk level
        });

    }

    /**
     * Kembalikan perubahan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
