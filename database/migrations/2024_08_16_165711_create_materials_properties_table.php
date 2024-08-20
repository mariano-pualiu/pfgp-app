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
        Schema::create('materials_properties', function (Blueprint $table) {
            $table->id();
            $table->text('value')->nullable()->default(null);
            $table->foreignId('material_id')->constrained(table: 'materials');
            $table->foreignId('property_id')->constrained(table: 'properties');
            // Add a foreign key for the building_block_id
            $table->nullableMorphs('specification');  // Adds specification_id and specification_type columns
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials_properties');
    }
};
