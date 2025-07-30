<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            kelasSeeder::class,
            // Add other seeders here as needed
            // Example: UserSeeder::class,
            // Example: ProductSeeder::class,
        ]);
    }
}
