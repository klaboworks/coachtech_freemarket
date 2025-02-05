<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class ItemsIndexTest extends TestCase
{
    // 全商品を表示する
    public function testDisplayAllItems(): void
    {
        $itemsData = [];
        for ($i = 0; $i < 5; $i++) {
            $itemImage = UploadedFile::fake()->image('item' . $i . '.jpg');
            $imagePath = Storage::disk('public')->putFile('item_images', $itemImage);

            $itemsData[] = [
                'item_image' => $imagePath,
            ];
        }

        $allItems = Item::factory(5)->createMany($itemsData);

        $response = $this->get(route('items.index'));
        $response->assertStatus(200);

        $this->assertEquals(5, $allItems->count());

        // アイテム画像とアイテム名が正しく表示されているか
        foreach ($allItems as $item) {
            $response->assertSee(asset('storage/' . $item->item_image));
            $response->assertSee($item->item_name);
        }

        foreach ($allItems as $item) {
            Storage::disk('public')->delete($item->item_image);
        }
    }

    // 購入済み商品は「Sold」と表示される
    public function testItemsWithSoldLabel(): void
    {
        $itemImage = UploadedFile::fake()->image('item.jpg');
        $imagePath = Storage::disk('public')->putFile('item_images', $itemImage);

        $item = Item::factory()->create([
            'item_image' => $imagePath,
            'is_sold' => true,
        ]);

        $response = $this->get(route('items.index'));
        $response->assertStatus(200);

        $response->assertSee(asset('storage/' . $item->item_image));
        $response->assertSee($item->item_name);
        $response->assertSee('Sold');

        Storage::disk('public')->delete($imagePath);
    }

    // 自分の商品を除外した全商品を取得する
    public function testDisplayAllWithoutMyItems(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $itemsDataA = [];
        for ($i = 0; $i < 2; $i++) {
            $itemImage = UploadedFile::fake()->image('item' . $i . '_a.jpg'); // a,bを区別
            $imagePath = Storage::disk('public')->putFile('item_images', $itemImage);
            $itemsDataA[] = ['item_image' => $imagePath]; // 連想配列で格納
        }

        $itemsDataB = [];
        for ($i = 0; $i < 2; $i++) {
            $itemImage = UploadedFile::fake()->image('item' . $i . '_b.jpg'); // a,bを区別
            $imagePath = Storage::disk('public')->putFile('item_images', $itemImage);
            $itemsDataB[] = ['item_image' => $imagePath]; // 連想配列で格納
        }

        Item::factory(2)->createMany(array_map(function ($data) use ($userA) {
            return array_merge($data, ['user_id' => $userA->id]);
        }, $itemsDataA));


        Item::factory(2)->createMany(array_map(function ($data) use ($userB) {
            return array_merge($data, ['user_id' => $userB->id]);
        }, $itemsDataB));


        $retrievedItemsA = Item::where('user_id', $userA->id)->get();
        $retrievedItemsB = Item::where('user_id', $userB->id)->get();

        /** @var \App\Models\User $userA */
        $this->actingAs($userA);
        $response = $this->get(route('items.index'));
        $response->assertStatus(200);

        // 自分のアイテムは表示されない
        foreach ($retrievedItemsA as $retrievedItemA) {
            $response->assertDontSee($retrievedItemA->item_name);
            $response->assertDontSee(asset('storage/' . $retrievedItemA->item_image));
        }

        // 自分以外のアイテムは表示される
        foreach ($retrievedItemsB as $retrievedItemB) {
            $response->assertSee($retrievedItemB->item_name);
            $response->assertSee(asset('storage/' . $retrievedItemB->item_image));
        }

        foreach ($retrievedItemsA as $retrievedItemA) {
            Storage::disk('public')->delete($retrievedItemA->item_image);
        }
        foreach ($retrievedItemsB as $retrievedItemB) {
            Storage::disk('public')->delete($retrievedItemB->item_image);
        }
    }
}
