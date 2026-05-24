<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DonationMethod;

class DonationMethodSeeder extends Seeder
{
    public function run(): void
    {
        DonationMethod::truncate();

        $methods = [
            [
                'name' => 'الدعم الشهري',
                'name_en' => 'Monthly Support',
                'description' => 'كن متبرعًا مستدامًا مع هدايا شهرية متكررة. تبرع الآن',
                'description_en' => 'Become a sustainable donor with recurring monthly gifts. Donate Now',
                'image' => null,
            ],
            [
                'name' => 'التبرع مرة واحدة',
                'name_en' => 'One-time Donation',
                'description' => 'قدم تبرعًا واحدًا لدعم مبادراتنا الحالية',
                'description_en' => 'Make a one-time donation to support our current initiatives',
                'image' => null,
            ],
        ];

        foreach ($methods as $method) {
            DonationMethod::create($method);
        }
    }
}
