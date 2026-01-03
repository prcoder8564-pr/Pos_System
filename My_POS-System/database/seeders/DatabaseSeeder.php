<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            SupplierSeeder::class,
            CustomerSeeder::class,
            ProductSeeder::class,
            SettingSeeder::class,
        ]);

        echo "\n🎉 All seeders completed successfully!\n";
        echo "════════════════════════════════════════\n";
        echo "Database is now populated with:\n";
        echo "  • 5 Users (1 Admin, 2 Managers, 2 Cashiers)\n";
        echo "  • 10 Categories\n";
        echo "  • 10 Suppliers\n";
        echo "  • 20 Customers\n";
        echo "  • 50 Products (with stock)\n";
        echo "  • 8 Settings\n";
        echo "════════════════════════════════════════\n";
        echo "Login at: http://localhost:8000/login\n";
        echo "Email: admin@pos.com\n";
        echo "Password: password\n";
        echo "════════════════════════════════════════\n";
    }
}