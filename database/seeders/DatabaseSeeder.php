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
            'permissions' => [
                'dashboard' => ['view'],
                'users' => ['view', 'create', 'edit', 'delete'],
                'programs' => ['view', 'create', 'edit', 'delete'],
                'sliders' => ['view', 'create', 'edit', 'delete'],
                'volunteer-content' => ['view', 'update'],
                'articles' => ['view', 'create', 'edit', 'delete'],
                'membership-applications' => ['view', 'export', 'update'],
                'donation-methods' => ['view', 'create', 'edit', 'delete'],
                'org-structure' => ['view', 'create', 'edit', 'delete'],
                'contact-settings' => ['view', 'update'],
            ],
        ]);

        $this->call([
            OrganizationalUnitSeeder::class,
            ContactSettingSeeder::class,
            VolunteerContentSeeder::class,
            DonationMethodSeeder::class,
            ProgramSeeder::class,
            ArticleSeeder::class,
            PermissionSeeder::class,
        ]);
    }
}
