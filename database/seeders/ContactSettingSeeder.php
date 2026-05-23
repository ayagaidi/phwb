<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\ContactSetting::truncate();

        \App\Models\ContactSetting::create([
            'phone' => '+218 21 444 1234',
            'email' => 'info@phwb.org',
            'address_ar' => 'طرابلس - ليبيا، حي السراج، شارع الجمهورية، مبنى رقم 15',
            'address_en' => 'Tripoli - Libya, Al-Sarraj District, Al-Jumhuriya Street, Building No. 15',
            'whatsapp' => '+218 92 123 4567',
            'facebook' => 'https://facebook.com/phwb.libya',
            'instagram' => 'https://instagram.com/phwb.libya',
            'working_hours_ar' => 'الأحد - الخميس: 8:00 صباحاً - 4:00 مساءً',
            'working_hours_en' => 'Sunday - Thursday: 8:00 AM - 4:00 PM',
        ]);
    }
}
