<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Stock;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Electronics (Category 1)
            ['name' => 'Samsung Galaxy S23', 'category_id' => 1, 'cost_price' => 45000, 'selling_price' => 55000, 'stock' => 15],
            ['name' => 'Apple iPhone 14', 'category_id' => 1, 'cost_price' => 65000, 'selling_price' => 75000, 'stock' => 10],
            ['name' => 'Sony Headphones WH-1000XM4', 'category_id' => 1, 'cost_price' => 15000, 'selling_price' => 18000, 'stock' => 25],
            ['name' => 'Dell Laptop Inspiron 15', 'category_id' => 1, 'cost_price' => 35000, 'selling_price' => 42000, 'stock' => 8],
            ['name' => 'LG LED TV 43 inch', 'category_id' => 1, 'cost_price' => 25000, 'selling_price' => 30000, 'stock' => 12],
            
            // Groceries (Category 2)
            ['name' => 'Tata Salt 1kg', 'category_id' => 2, 'cost_price' => 15, 'selling_price' => 20, 'stock' => 200],
            ['name' => 'Fortune Sunflower Oil 1L', 'category_id' => 2, 'cost_price' => 120, 'selling_price' => 150, 'stock' => 100],
            ['name' => 'India Gate Basmati Rice 5kg', 'category_id' => 2, 'cost_price' => 350, 'selling_price' => 450, 'stock' => 50],
            ['name' => 'Amul Butter 500g', 'category_id' => 2, 'cost_price' => 220, 'selling_price' => 260, 'stock' => 75],
            ['name' => 'Britannia Good Day Biscuits', 'category_id' => 2, 'cost_price' => 25, 'selling_price' => 30, 'stock' => 150],
            
            // Clothing (Category 3)
            ['name' => 'Levis Mens Jeans', 'category_id' => 3, 'cost_price' => 1200, 'selling_price' => 1800, 'stock' => 30],
            ['name' => 'Nike T-Shirt', 'category_id' => 3, 'cost_price' => 600, 'selling_price' => 900, 'stock' => 45],
            ['name' => 'Adidas Running Shoes', 'category_id' => 3, 'cost_price' => 2000, 'selling_price' => 2800, 'stock' => 20],
            ['name' => 'Puma Track Pants', 'category_id' => 3, 'cost_price' => 800, 'selling_price' => 1200, 'stock' => 35],
            ['name' => 'Woodland Formal Shoes', 'category_id' => 3, 'cost_price' => 1500, 'selling_price' => 2200, 'stock' => 18],
            
            // Furniture (Category 4)
            ['name' => 'Godrej Office Chair', 'category_id' => 4, 'cost_price' => 3500, 'selling_price' => 5000, 'stock' => 10],
            ['name' => 'Nilkamal Plastic Table', 'category_id' => 4, 'cost_price' => 1200, 'selling_price' => 1800, 'stock' => 15],
            ['name' => 'IKEA Study Desk', 'category_id' => 4, 'cost_price' => 4000, 'selling_price' => 6000, 'stock' => 8],
            ['name' => 'Wakefit Sofa 3 Seater', 'category_id' => 4, 'cost_price' => 12000, 'selling_price' => 16000, 'stock' => 5],
            ['name' => 'Kurl-on Mattress Queen Size', 'category_id' => 4, 'cost_price' => 8000, 'selling_price' => 11000, 'stock' => 7],
            
            // Toys & Games (Category 5)
            ['name' => 'Lego City Building Set', 'category_id' => 5, 'cost_price' => 1500, 'selling_price' => 2200, 'stock' => 25],
            ['name' => 'Hot Wheels Car Pack', 'category_id' => 5, 'cost_price' => 300, 'selling_price' => 450, 'stock' => 60],
            ['name' => 'Barbie Doll Set', 'category_id' => 5, 'cost_price' => 800, 'selling_price' => 1200, 'stock' => 40],
            ['name' => 'Nerf Blaster Gun', 'category_id' => 5, 'cost_price' => 1200, 'selling_price' => 1800, 'stock' => 20],
            ['name' => 'Chess Board Premium', 'category_id' => 5, 'cost_price' => 400, 'selling_price' => 600, 'stock' => 30],
            
            // Books & Stationery (Category 6)
            ['name' => 'Classmate Notebook Pack of 6', 'category_id' => 6, 'cost_price' => 120, 'selling_price' => 180, 'stock' => 100],
            ['name' => 'Reynolds Pen Set', 'category_id' => 6, 'cost_price' => 50, 'selling_price' => 80, 'stock' => 200],
            ['name' => 'Harry Potter Complete Set', 'category_id' => 6, 'cost_price' => 1500, 'selling_price' => 2200, 'stock' => 15],
            ['name' => 'Oxford Dictionary', 'category_id' => 6, 'cost_price' => 300, 'selling_price' => 450, 'stock' => 25],
            ['name' => 'Art Supplies Kit', 'category_id' => 6, 'cost_price' => 600, 'selling_price' => 900, 'stock' => 35],
            
            // Sports & Fitness (Category 7)
            ['name' => 'Cosco Football Size 5', 'category_id' => 7, 'cost_price' => 400, 'selling_price' => 600, 'stock' => 40],
            ['name' => 'Yonex Badminton Racket', 'category_id' => 7, 'cost_price' => 800, 'selling_price' => 1200, 'stock' => 25],
            ['name' => 'Nivia Cricket Bat', 'category_id' => 7, 'cost_price' => 1200, 'selling_price' => 1800, 'stock' => 18],
            ['name' => 'Gym Dumbbell Set 10kg', 'category_id' => 7, 'cost_price' => 1000, 'selling_price' => 1500, 'stock' => 20],
            ['name' => 'Yoga Mat Premium', 'category_id' => 7, 'cost_price' => 400, 'selling_price' => 650, 'stock' => 50],
            
            // Beauty & Personal Care (Category 8)
            ['name' => 'Lakme Face Cream', 'category_id' => 8, 'cost_price' => 150, 'selling_price' => 220, 'stock' => 80],
            ['name' => 'Dove Shampoo 650ml', 'category_id' => 8, 'cost_price' => 250, 'selling_price' => 350, 'stock' => 100],
            ['name' => 'Gillette Razor Pack', 'category_id' => 8, 'cost_price' => 180, 'selling_price' => 260, 'stock' => 70],
            ['name' => 'Nivea Body Lotion 400ml', 'category_id' => 8, 'cost_price' => 200, 'selling_price' => 300, 'stock' => 60],
            ['name' => 'Maybelline Lipstick', 'category_id' => 8, 'cost_price' => 300, 'selling_price' => 450, 'stock' => 55],
            
            // Home & Kitchen (Category 9)
            ['name' => 'Prestige Pressure Cooker 5L', 'category_id' => 9, 'cost_price' => 1200, 'selling_price' => 1800, 'stock' => 22],
            ['name' => 'Philips Mixer Grinder', 'category_id' => 9, 'cost_price' => 2500, 'selling_price' => 3500, 'stock' => 12],
            ['name' => 'Milton Water Bottle 1L', 'category_id' => 9, 'cost_price' => 150, 'selling_price' => 250, 'stock' => 90],
            ['name' => 'Hawkins Non-stick Pan', 'category_id' => 9, 'cost_price' => 600, 'selling_price' => 900, 'stock' => 35],
            ['name' => 'Cello Storage Container Set', 'category_id' => 9, 'cost_price' => 400, 'selling_price' => 600, 'stock' => 45],
            
            // Automotive (Category 10)
            ['name' => 'MRF Bike Tyre', 'category_id' => 10, 'cost_price' => 1500, 'selling_price' => 2200, 'stock' => 15],
            ['name' => 'Car Air Freshener', 'category_id' => 10, 'cost_price' => 100, 'selling_price' => 180, 'stock' => 100],
            ['name' => 'Mobil Engine Oil 1L', 'category_id' => 10, 'cost_price' => 350, 'selling_price' => 500, 'stock' => 50],
            ['name' => 'Car Seat Cover Set', 'category_id' => 10, 'cost_price' => 800, 'selling_price' => 1200, 'stock' => 25],
            ['name' => 'Bosch Wiper Blades', 'category_id' => 10, 'cost_price' => 400, 'selling_price' => 650, 'stock' => 40],
        ];

        foreach ($products as $index => $productData) {
            // Generate SKU and Barcode
            $sku = 'SKU' . str_pad($index + 1, 6, '0', STR_PAD_LEFT);
            $barcode = 'BAR' . str_pad($index + 1, 10, '0', STR_PAD_LEFT);
            
            $stockQty = $productData['stock'];
            unset($productData['stock']);

            // Create Product
            $product = Product::create([
                'category_id' => $productData['category_id'],
                'name' => $productData['name'],
                'sku' => $sku,
                'barcode' => $barcode,
                'cost_price' => $productData['cost_price'],
                'selling_price' => $productData['selling_price'],
                'alert_quantity' => 10,
                'image' => null,
                'description' => 'High quality ' . strtolower($productData['name']),
                'is_active' => true,
            ]);

            // Create Stock for this product
            Stock::create([
                'product_id' => $product->id,
                'quantity' => $stockQty,
                'last_updated' => now(),
            ]);
        }

        echo "✅ Products seeded successfully! (50 products with stock)\n";
    }
}