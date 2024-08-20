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
        Schema::create('building_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->text('elements');
            $table->string('type');
            // $table->string('visibility');
            // $table->text('shared_with');
            // $table->text('schema');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('building_blocks');
    }
};
