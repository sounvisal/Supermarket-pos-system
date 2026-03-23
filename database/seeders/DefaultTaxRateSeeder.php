<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TaxRate;

class DefaultTaxRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TaxRate::create([
            'name' => 'Default Tax Rate',
            'rate' => 6.0, // 6% tax rate
            'is_default' => true,
            'apply_to_all_products' => true,
            'description' => 'Default tax rate for all products'
        ]);
    }
}
