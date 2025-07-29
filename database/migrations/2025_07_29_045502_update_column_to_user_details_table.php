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
        Schema::table('admins', function (Blueprint $table) {
           $table->string('bvc_reg_number')->nullable()->after('status');
           $table->double('chamber_visit')->nullable()->after('bvc_reg_number');
           $table->string('home_visit')->nullable()->after('chamber_visit');
           $table->text('degree')->nullable()->after('home_visit');
           $table->text('full_address')->nullable()->after('degree');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('bvc_reg_number');
            $table->dropColumn('chamber_visit');
            $table->dropColumn('home_visit');
            $table->dropColumn('degree');
            $table->dropColumn('full_address');
        });
    }
};
