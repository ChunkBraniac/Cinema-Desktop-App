<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Admin::factory()->create([
            'admin_name' => 'Obah Anthony',
            'admin_email' => 'anthonyobah37@gmail.com',
            'admin_password' => bcrypt('123456'),
            'role' => 'admin',
        ]);
    }
}
