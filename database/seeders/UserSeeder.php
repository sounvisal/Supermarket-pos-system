<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a manager user
        User::create([
            'name' => 'Manager User',
            'email' => 'manager@redpanda.com',
            'employee_id' => 'M001',
            'password' => Hash::make('password'),
            'role' => 'manager',
        ]);

        // Create a cashier user
        User::create([
            'name' => 'Cashier User',
            'email' => 'cashier@redpanda.com',
            'employee_id' => 'C001',
            'password' => Hash::make('password'),
            'role' => 'cashier',
        ]);

        // Create a stock staff user
        User::create([
            'name' => 'Stock User',
            'email' => 'stock@redpanda.com',
            'employee_id' => 'S001',
            'password' => Hash::make('password'),
            'role' => 'stock',
        ]);
    }
} 