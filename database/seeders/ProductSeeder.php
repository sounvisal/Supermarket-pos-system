<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Products;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing products
        DB::table('products')->truncate();
        
        // Create sample products
        $products = [
            [
                'product_name' => 'Milk',
                'price' => 2.99,
                'qty' => 100,
                'category' => 'dairy',
                'status' => 1,
                'image' => 'default.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Eggs',
                'price' => 3.49,
                'qty' => 75,
                'category' => 'dairy',
                'status' => 1,
                'image' => 'default.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Bread',
                'price' => 2.50,
                'qty' => 60,
                'category' => 'bakery',
                'status' => 1,
                'image' => 'default.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Chicken',
                'price' => 7.99,
                'qty' => 45,
                'category' => 'meat',
                'status' => 1,
                'image' => 'default.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Apples',
                'price' => 3.99,
                'qty' => 120,
                'category' => 'fruits',
                'status' => 1,
                'image' => 'default.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Bananas',
                'price' => 1.99,
                'qty' => 150,
                'category' => 'fruits',
                'status' => 1,
                'image' => 'default.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Carrots',
                'price' => 2.19,
                'qty' => 90,
                'category' => 'vegetables',
                'status' => 1,
                'image' => 'default.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Pasta',
                'price' => 1.50,
                'qty' => 200,
                'category' => 'snacks',
                'status' => 1,
                'image' => 'default.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Soda',
                'price' => 1.25,
                'qty' => 180,
                'category' => 'beverages',
                'status' => 1,
                'image' => 'default.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Paper Towels',
                'price' => 4.99,
                'qty' => 70,
                'category' => 'household',
                'status' => 1,
                'image' => 'default.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        // Insert the products
        Products::insert($products);
        
        $this->command->info('Inserted ' . count($products) . ' sample products!');
    }
} 