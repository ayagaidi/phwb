<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
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
        ];

        \App\Models\User::where('role', 'owner')->update([
            'permissions' => array_map(fn($actions) => $actions, $sections)
        ]);
    }
}
