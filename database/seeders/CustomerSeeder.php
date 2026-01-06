<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Ramesh Patel',
                'phone' => '9988776655',
                'email' => 'ramesh@gmail.com',
                'address' => '12 Vikas Society, Rajkot',
                'total_purchases' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Jayesh Shah',
                'phone' => '9988776657',
                'email' => 'jayesh@gmail.com',
                'address' => '56 Patel Colony, Rajkot',
                'total_purchases' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Nisha Modi',
                'phone' => '9988776658',
                'email' => 'nisha@gmail.com',
                'address' => '78 Krishna Kunj, Rajkot',
                'total_purchases' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Hardik Trivedi',
                'phone' => '9988776659',
                'email' => 'hardik@gmail.com',
                'address' => '90 Green Avenue, Rajkot',
                'total_purchases' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Pooja Joshi',
                'phone' => '9988776660',
                'email' => 'pooja@gmail.com',
                'address' => '11 Akshar Society, Rajkot',
                'total_purchases' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Neha Bhavsar',
                'phone' => '9988776672',
                'email' => 'neha@gmail.com',
                'address' => '104 Krishna Tower, Rajkot',
                'total_purchases' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Pratik Makwana',
                'phone' => '9988776673',
                'email' => 'pratik@gmail.com',
                'address' => '105 Raj Heritage, Rajkot',
                'total_purchases' => 0,
                'is_active' => true,
            ],
            
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }

        echo "✅ Customers seeded successfully! (20 customers)\n";
    }
}