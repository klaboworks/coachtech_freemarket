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
        $users = User::factory()->count(3)->create([
            'password' => 'pass'
        ]);
        $users[0]->avatar = 'user1.png';
        $users[0]->save();

        $this->call([
            ConditionsTableSeeder::class,
            CategoriesTableSeeder::class,
            ItemsTableSeeder::class,
            CategoryItemTableSeeder::class,
            PaymentsTableSeeder::class,
        ]);
    }
}
