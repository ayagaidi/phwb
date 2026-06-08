<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@phwb.org',
            'password' => bcrypt('admin123'),
            'role' => 'owner',
        ]);

        $this->call([
            OrganizationalUnitSeeder::class,
            ContactSettingSeeder::class,
            VolunteerContentSeeder::class,
            DonationMethodSeeder::class,
            ProgramSeeder::class,
            ArticleSeeder::class,
        ]);
    }
}
