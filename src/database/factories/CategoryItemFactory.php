<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CategoryItem>
 */
class CategoryItemFactory extends Factory
{
    private static $counter1 = 1;
    private static $counter2 = 1;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => \App\Models\Category::factory(),
            'item_id' => \App\Models\Item::factory(),
        ];
    }

    // private function categoryId()
    // {
    //     $value = self::$counter1;
    //     self::$counter1++;
    //     if (self::$counter1 > 10) {
    //         self::$counter1 = 1;
    //     }
    //     return $value;
    // }

    // private function itemId()
    // {
    //     $value = self::$counter2;
    //     self::$counter2++;
    //     if (self::$counter2 > 5) {
    //         self::$counter2 = 1;
    //     }
    //     return $value;
    // }
}
