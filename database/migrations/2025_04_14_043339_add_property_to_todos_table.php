<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPropertyToTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->enum('property', ['low', 'medium', 'high'])->default('low');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->dropColumn('property');
        });
    }
}
