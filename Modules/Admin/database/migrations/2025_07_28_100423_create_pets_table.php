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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('subcategory_id');
            $table->unsignedBigInteger('breed_id');
            $table->date('birthday');
            $table->decimal('weight', 8, 2);
            $table->string('sex');
            $table->text('current_medications')->nullable();
            $table->text('medication_allergies')->nullable();
            $table->text('health_conditions')->nullable();
            $table->text('special_notes')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('pet_categories')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('pet_subcategories')->onDelete('cascade');
            $table->foreign('breed_id')->references('id')->on('pet_breeds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
