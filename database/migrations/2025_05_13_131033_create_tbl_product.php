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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Auto-incrementing Primary Key

            $table->string('product_name', 255); // String with optional length
            // Using foreign key for category relationship
            // Assumes a 'categories' table exists or will be created
            $table->string('category')->nullable(); // Unsigned BIGINT, foreign key to 'categories' table

            $table->decimal('price')->default(0.00); // Decimal for currency (10 total digits, 2 after decimal)
            $table->unsignedInteger('qty')->default(0); // Unsigned Integer for stock count
            $table->string('status')->default('active'); // String for status, maybe with limited length and default
            // Or consider: $table->enum('status', ['active', 'inactive', 'draft'])->default('active');

            $table->string('image', 255)->nullable(); // String for image path, can be null

            $table->timestamps(); // created_at and updated_at
            $table->softDeletes(); // Optional: Add deleted_at for soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};