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
        Schema::create('pet_breeds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pet_subcategory_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('typical_weight_min', 8, 2);
            $table->decimal('typical_weight_max', 8, 2);
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->foreign('pet_subcategory_id')->references('id')->on('pet_subcategories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_breeds');
    }
};
