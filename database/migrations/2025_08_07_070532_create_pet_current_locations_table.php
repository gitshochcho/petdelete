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
        Schema::create('pet_current_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pet_id')->constrained('pets')->onDelete('cascade');
            $table->decimal('lat', 10, 8)->comment('Latitude coordinate');
            $table->decimal('long', 11, 8)->comment('Longitude coordinate');
            $table->string('location')->nullable()->comment('Human readable location name');
            $table->timestamp('get_time')->comment('Time when location was recorded');
            $table->timestamps();

            // Index for better performance
            $table->index(['pet_id', 'get_time']);
            $table->index(['lat', 'long']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_current_locations');
    }
};
