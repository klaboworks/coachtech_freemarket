<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class MylistTest extends TestCase
{
    // いいねした商品だけが表示される
    public function testDisplayLikedItemAtMylist(): void
    {
        $itemsData = [];
        for ($i = 0; $i < 5; $i++) {
            $itemImage = UploadedFile::fake()->image('item' . $i . '.jpg');
            $imagePath = Storage::disk('public')->putFile('item_images', $itemImage);

            $itemsData[] = [
                'item_image' => $imagePath,
            ];
        }

        Item::factory(5)->createMany($itemsData);
        $user = User::inRandomOrder()->first();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
        $likedItem = Item::where('user_id', '!=', $user->id)->first();
        $otherItems = Item::where('id', '!=', $likedItem->id)
            ->where('user_id', '!=', $user->id)->get();

        // いいね処理
        $response = $this->post(route('like', $likedItem->id), [
            'item_id' => $likedItem->id,
            'user_id' => $user->id,
        ]);
        $response->assertStatus(302);

        // 商品一覧ページでは自分以外の全てのアイテムを表示
        $response = $this->get(route('items.index'));
        $response->assertStatus(200);
        $response->assertSee(asset('storage/' . $likedItem->item_image));
        $response->assertSee($likedItem->item_name);
        foreach ($otherItems as $otherItem) {
            $response->assertSee(asset('storage/' . $otherItem->item_image));
            $response->assertSee($otherItem->item_name);
        }

        // マイリストへ移動、いいねした商品のみが表示されている
        $response = $this->get(route('items.index') . '?page=mylist');
        $response->assertStatus(200);
        $response->assertSee(asset('storage/' . $likedItem->item_image));
        $response->assertSee($likedItem->item_name);
        foreach ($otherItems as $otherItem) {
            $response->assertDontSee(asset('storage/' . $otherItem->item_image));
            $response->assertDontSee($otherItem->item_name);
        }

        $myItem = Item::where('user_id', '=', $user->id)->first();
        Storage::disk('public')->delete($myItem->item_image);
        Storage::disk('public')->delete($likedItem->item_image);
        foreach ($otherItems as $item) {
            Storage::disk('public')->delete($item->item_image);
        }
    }

    // 購入済み商品は「Sold」と表示される
    public function testSoldItemHasLabelAtMylist(): void
    {
        // 売り切れアイテム作成
        $itemsData = [];
        for ($i = 0; $i < 5; $i++) {
            $itemImage = UploadedFile::fake()->image('item' . $i . '.jpg');
            $imagePath = Storage::disk('public')->putFile('item_images', $itemImage);

            $itemsData[] = [
                'item_image' => $imagePath,
                'is_sold' => true,
            ];
        }

        $items = Item::factory(5)->createMany($itemsData);
        $user = User::inRandomOrder()->first();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
        $likedItem = Item::where('user_id', '!=', $user->id)->first();

        // いいね処理
        $response = $this->post(route('like', $likedItem->id), [
            'item_id' => $likedItem->id,
            'user_id' => $user->id,
        ]);
        $response->assertStatus(302);

        // マイリストへ移動
        $response = $this->get(route('items.index') . '?page=mylist');
        $response->assertStatus(200);

        // マイリストの購入済み商品はSoldラベルが表示されている
        $response->assertSee(asset('storage/' . $likedItem->item_image));
        $response->assertSee($likedItem->item_name);
        $response->assertSee('Sold');

        foreach ($items as $item) {
            Storage::disk('public')->delete($item->item_image);
        }
    }

    // 自分が出品した商品は表示されない
    public function testDisplayWithoutMyItemsAtMylist(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $itemsDataA = [];
        for ($i = 0; $i < 2; $i++) {
            $itemImage = UploadedFile::fake()->image('item' . $i . '_a.jpg');
            $imagePath = Storage::disk('public')->putFile('item_images', $itemImage);
            $itemsDataA[] = ['item_image' => $imagePath];
        }

        $itemsDataB = [];
        for ($i = 0; $i < 2; $i++) {
            $itemImage = UploadedFile::fake()->image('item' . $i . '_b.jpg');
            $imagePath = Storage::disk('public')->putFile('item_images', $itemImage);
            $itemsDataB[] = ['item_image' => $imagePath];
        }

        Item::factory(2)->createMany(array_map(function ($data) use ($userA) {
            return array_merge($data, ['user_id' => $userA->id]);
        }, $itemsDataA));


        Item::factory(2)->createMany(array_map(function ($data) use ($userB) {
            return array_merge($data, ['user_id' => $userB->id]);
        }, $itemsDataB));

        $retrievedItemsA = Item::where('user_id', $userA->id)->get();
        $retrievedItemsB = Item::where('user_id', $userB->id)->get();

        // 商品一覧ページでは
        /** @var \App\Models\User $userA */
        $this->actingAs($userA);
        $response = $this->get(route('items.index'));
        $response->assertStatus(200);
        // 自分のアイテムは表示されない
        foreach ($retrievedItemsA as $retrievedItemA) {
            $response->assertDontSee(asset('storage/' . $retrievedItemA->item_image));
            $response->assertDontSee($retrievedItemA->item_name);
        }
        // 自分以外のアイテムは表示される
        foreach ($retrievedItemsB as $retrievedItemB) {
            $response->assertSee(asset('storage/' . $retrievedItemB->item_image));
            $response->assertSee($retrievedItemB->item_name);
        }

        // マイリストへ移動すると
        $response = $this->get(route('items.index') . '?page=mylist');
        $response->assertStatus(200);
        // 自分のアイテムは表示されない
        foreach ($retrievedItemsA as $retrievedItemA) {
            $response->assertDontSee(asset('storage/' . $retrievedItemA->item_image));
            $response->assertDontSee($retrievedItemA->item_name);
        }
        // 自分以外のアイテムも表示されない（いいねをしていないので）
        foreach ($retrievedItemsB as $retrievedItemB) {
            $response->assertDontSee(asset('storage/' . $retrievedItemB->item_image));
            $response->assertDontSee($retrievedItemB->item_name);
        }

        foreach ($retrievedItemsA as $retrievedItemA) {
            Storage::disk('public')->delete($retrievedItemA->item_image);
        }
        foreach ($retrievedItemsB as $retrievedItemB) {
            Storage::disk('public')->delete($retrievedItemB->item_image);
        }
    }

    // 未認証の場合は何も表示されない
    public function testNoItemDisplayedAtMylist(): void
    {
        $items = Item::factory(5)->create();
        $this->assertGuest();
        $response = $this->get(route('items.index') . '?page=mylist');
        $response->assertStatus(200);
        foreach ($items as $item) {
            $response->assertDontSee($item->item_name);
        }
    }
}
