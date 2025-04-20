<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->boolean('pinned')->default(false); // Menambahkan kolom pinned
        });
    }

    public function down(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->dropColumn('pinned'); // Menghapus kolom pinned saat rollback
        });
    }
};
