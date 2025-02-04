<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\Condition;
use App\Models\Category;
use App\Models\Item;

class SellTest extends TestCase
{
    public function testSellItem(): void
    {
        Storage::fake('public');
        $image = UploadedFile::fake()->image('test.jpg');

        /** @var \App\Models\User $user */
        $user = $this->createUser();
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();
        $condition = Condition::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
        $response = $this->get(route('sell.create'));
        $response->assertStatus(200);

        $response = $this->post(route('sell.store'), [
            'condition_id' => $condition->id,
            'user_id' => $user->id,
            'item_image' => $image,
            'item_name' => 'testItem',
            'brand_name' => 'testBrand',
            'price' => 1000,
            'item_description' => 'This item is very good!',
            'is_sold' => false,
            'categories' => [$category1->id, $category2->id],
        ]);
        $response->assertStatus(302);

        // 画像保存検証
        $files = Storage::disk('public')->files('item_images');
        $this->assertCount(1, array_filter($files, function ($file) use ($image) {
            return str_contains($file, $image->hashName());
        }));

        // itemsテーブル検証
        $this->assertDatabaseHas('items', [
            'condition_id' => $condition->id,
            'user_id' => $user->id,
            'item_name' => 'testItem',
            'brand_name' => 'testBrand',
            'price' => 1000,
            'item_description' => 'This item is very good!',
            'is_sold' => false,
        ]);

        $item = Item::where('item_name', 'testItem')->first();

        // category_itemテーブル検証
        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $category1->id,
        ]);
        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $category2->id,
        ]);

        // 複数カテゴリーを検証
        $this->assertDatabaseCount('category_item', 2);

        $itemCategories = $item->categories->pluck('id')->toArray();
        $this->assertEquals([$category1->id, $category2->id], $itemCategories);
    }
}
