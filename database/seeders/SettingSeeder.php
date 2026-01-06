<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'business_name', 'value' => 'My POS Store', 'type' => 'text'],
            ['key' => 'business_phone', 'value' => '9876543210', 'type' => 'text'],
            ['key' => 'business_email', 'value' => 'info@myposstore.com', 'type' => 'text'],
            ['key' => 'business_address', 'value' => 'Rajkot, Gujarat, India', 'type' => 'text'],
            ['key' => 'tax_rate', 'value' => '18', 'type' => 'number'],
            ['key' => 'currency_symbol', 'value' => '₹', 'type' => 'text'],
            ['key' => 'receipt_footer', 'value' => 'Thank you for your business!', 'type' => 'text'],
            ['key' => 'low_stock_alert', 'value' => '10', 'type' => 'number'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }

        echo "✅ Settings seeded successfully!\n";
    }
}