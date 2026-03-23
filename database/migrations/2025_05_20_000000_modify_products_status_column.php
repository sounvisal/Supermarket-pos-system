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
        Schema::table('products', function (Blueprint $table) {
            // Drop the existing status column
            $table->dropColumn('status');
            
            // Add it back as an integer with default 1
            $table->tinyInteger('status')->default(1)->after('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the integer status column
            $table->dropColumn('status');
            
            // Add back the original string column
            $table->string('status')->default('active')->after('category');
        });
    }
}; 