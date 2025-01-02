<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->count(3)->create([
            'password' => 'pass'
        ]);

        $this->call([
            ConditionsTableSeeder::class,
            CategoriesTableSeeder::class,
            ItemsTableSeeder::class,
            PaymentsTableSeeder::class,
        ]);
    }
}
