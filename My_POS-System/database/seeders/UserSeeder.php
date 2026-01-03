<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@pos.com',
            'password' => Hash::make('admin@123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Manager Users
        User::create([
            'name' => 'Manager One',
            'email' => 'manager1@pos.com',
            'password' => Hash::make('man1@123'),
            'role' => 'manager',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Manager Two',
            'email' => 'manager2@pos.com',
            'password' => Hash::make('man2@123'),
            'role' => 'manager',
            'is_active' => true,
        ]);

        // Cashier Users
        User::create([
            'name' => 'Cashier One',
            'email' => 'cashier1@pos.com',
            'password' => Hash::make('staff1@123'),
            'role' => 'cashier',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Cashier Two',
            'email' => 'cashier2@pos.com',
            'password' => Hash::make('satff2@123'),
            'role' => 'cashier',
            'is_active' => true,
        ]);

        echo "✅ Users seeded successfully!\n";
        echo "   Login credentials:\n";
        echo "   Admin: admin@pos.com / password\n";
        echo "   Manager: manager1@pos.com / password\n";
        echo "   Cashier: cashier1@pos.com / password\n";
    }
}