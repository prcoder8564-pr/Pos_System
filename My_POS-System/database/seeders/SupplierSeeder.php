<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Rajesh Kumar',
                'company' => 'Tech Suppliers Pvt Ltd',
                'phone' => '9876543210',
                'email' => 'rajesh@techsuppliers.com',
                'address' => '123 MG Road, Rajkot, Gujarat',
                'is_active' => true,
            ],
            [
                'name' => 'Priya Patel',
                'company' => 'Fresh Grocers',
                'phone' => '9876543211',
                'email' => 'priya@freshgrocers.com',
                'address' => '456 Kalawad Road, Rajkot, Gujarat',
                'is_active' => true,
            ],
            [
                'name' => 'Amit Shah',
                'company' => 'Fashion Hub Suppliers',
                'phone' => '9876543212',
                'email' => 'amit@fashionhub.com',
                'address' => '789 University Road, Rajkot, Gujarat',
                'is_active' => true,
            ],
            [
                'name' => 'Sneha Desai',
                'company' => 'Furniture World',
                'phone' => '9876543213',
                'email' => 'sneha@furnitureworld.com',
                'address' => '321 Gondal Road, Rajkot, Gujarat',
                'is_active' => true,
            ],
            [
                'name' => 'Vikram Singh',
                'company' => 'Toy Kingdom Distributors',
                'phone' => '9876543214',
                'email' => 'vikram@toykingdom.com',
                'address' => '654 Yagnik Road, Rajkot, Gujarat',
                'is_active' => true,
            ],
            [
                'name' => 'Meera Joshi',
                'company' => 'Book Depot',
                'phone' => '9876543215',
                'email' => 'meera@bookdepot.com',
                'address' => '987 Raiya Road, Rajkot, Gujarat',
                'is_active' => true,
            ],
            [
                'name' => 'Karan Mehta',
                'company' => 'Sports Arena Suppliers',
                'phone' => '9876543216',
                'email' => 'karan@sportsarena.com',
                'address' => '147 Kotecha Chowk, Rajkot, Gujarat',
                'is_active' => true,
            ],
            [
                'name' => 'Anjali Sharma',
                'company' => 'Beauty Plus',
                'phone' => '9876543217',
                'email' => 'anjali@beautyplus.com',
                'address' => '258 Kalavad Road, Rajkot, Gujarat',
                'is_active' => true,
            ],
            [
                'name' => 'Rohit Pandya',
                'company' => 'Home Essentials',
                'phone' => '9876543218',
                'email' => 'rohit@homeessentials.com',
                'address' => '369 150 Feet Ring Road, Rajkot, Gujarat',
                'is_active' => true,
            ],
            [
                'name' => 'Kavita Rao',
                'company' => 'Auto Parts India',
                'phone' => '9876543219',
                'email' => 'kavita@autopartsindia.com',
                'address' => '741 Morbi Road, Rajkot, Gujarat',
                'is_active' => true,
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        echo "✅ Suppliers seeded successfully! (10 suppliers)\n";
    }
}