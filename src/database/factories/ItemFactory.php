<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\URL;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    private static $counter = 1;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'condition_id' => \App\Models\Condition::factory(),
            'user_id' => \App\Models\User::factory(),
            'item_image' => fake()->imageUrl(),
            'item_name' => fake()->name(),
            'brand_name' => fake()->word(),
            'price' => fake()->numberBetween(100, 1000),
            'item_description' => fake()->realText(100),
            'is_sold' => fake()->boolean(),
        ];
    }

    // private function condition()
    // {
    //     $value = self::$counter;
    //     self::$counter++;
    //     if (self::$counter > 3) {
    //         self::$counter = 1;
    //     }
    //     return $value;
    // }

    // private function itemName()
    // {
    //     static $count = 1;
    //     return 'item_' . $count++;
    // }

    // private function brandName()
    // {
    //     static $count = 1;
    //     return 'brand_' . $count++;
    // }

    // private function price()
    // {
    //     static $count = 1000;
    //     static $callCount = 0;

    //     $callCount++;

    //     if ($callCount == 1) {
    //         return $count;
    //     } else {
    //         $count += 1000;
    //         return $count;
    //     }
    // }

    // private function itemDescription()
    // {
    //     static $count = 1;
    //     return 'description_' . $count++;
    // }
}
