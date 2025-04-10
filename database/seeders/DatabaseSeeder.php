<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar los seeders
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            BrandSeeder::class,
            SupplierSeeder::class
        ]);
    }
}
