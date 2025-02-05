<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Item;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
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

    /**
     * Configure the model's state to generate related CategoryItem and Category data.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Item $item) {
            $categoryNames = ['category1', 'category2'];

            foreach ($categoryNames as $categoryName) {
                $category = Category::firstOrCreate(['category_name' => $categoryName]);
                $item->categories()->attach($category->id);
            }

            $user = User::inRandomOrder()->first();
            Comment::factory()->create(['item_id' => $item->id, 'user_id' => $user->id]);
        });
    }
}
