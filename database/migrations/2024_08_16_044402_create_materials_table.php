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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // $table->text('properties');

            // $table->string('visibility');
            // $table->text('shared_with');

            $table->foreignId('framework_id')->constrained(table: 'frameworks');
            $table->foreignId('node_id')->constrained(table: 'nodes');
            $table->foreignId('linker_id')->constrained(table: 'linkers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
