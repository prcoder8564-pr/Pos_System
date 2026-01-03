<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and accessories',
                'is_active' => true,
            ],
            [
                'name' => 'Groceries',
                'description' => 'Food items and daily essentials',
                'is_active' => true,
            ],
            [
                'name' => 'Clothing',
                'description' => 'Apparel and fashion items',
                'is_active' => true,
            ],
            [
                'name' => 'Furniture',
                'description' => 'Home and office furniture',
                'is_active' => true,
            ],
            [
                'name' => 'Toys & Games',
                'description' => 'Kids toys and gaming items',
                'is_active' => true,
            ],
            [
                'name' => 'Books & Stationery',
                'description' => 'Books, notebooks, and stationery items',
                'is_active' => true,
            ],
            [
                'name' => 'Sports & Fitness',
                'description' => 'Sports equipment and fitness products',
                'is_active' => true,
            ],
            [
                'name' => 'Beauty & Personal Care',
                'description' => 'Cosmetics and personal care products',
                'is_active' => true,
            ],
            [
                'name' => 'Home & Kitchen',
                'description' => 'Kitchen appliances and home decor',
                'is_active' => true,
            ],
            [
                'name' => 'Automotive',
                'description' => 'Car accessories and automotive parts',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        echo "✅ Categories seeded successfully! (10 categories)\n";
    }
}