<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;
use App\Models\Payment;
use App\Models\User;

class MylistTest extends TestCase
{
    // いいねした商品だけが表示される
    public function testDisplayLikedItemAtMylist(): void
    {
        Item::factory(5)->create();
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

        // 商品一覧ページでは自分意外の全てのアイテムを表示
        $response = $this->get(route('items.index'));
        $response->assertStatus(200);
        $response->assertSee($likedItem->item_name);
        foreach ($otherItems as $otherItem) {
            $response->assertSee($otherItem->item_name);
        }

        // マイリストへ移動
        $response = $this->get(route('items.index') . '?page=mylist');
        $response->assertStatus(200);
        $response->assertSee($likedItem->item_name);
        foreach ($otherItems as $otherItem) {
            $response->assertDontSee($otherItem->item_name);
        }
    }

    // 購入済み商品は「Sold」と表示される
    public function testSoldItemHasLabelAtMylist(): void
    {
        // 売り切れアイテム作成
        Item::factory(5)->create(['is_sold' => true]);
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
        $response->assertSee($likedItem->item_name);
        $response->assertSee('Sold');
    }

    // 自分が出品した商品は表示されない
    public function testDisplayWithoutMyItemsAtMylist(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        /** @var \App\Models\User $userA */
        /** @var \App\Models\User $userB */
        Item::factory(2)->create(['user_id' => $userA->id]);
        Item::factory(3)->create(['user_id' => $userB->id]);

        $retrievedItemsA = Item::where('user_id', $userA->id)->get();
        $retrievedItemsB = Item::where('user_id', $userB->id)->get();

        // 商品一覧ページでは
        $this->actingAs($userA);
        $response = $this->get(route('items.index'));
        $response->assertStatus(200);

        // 自分のアイテムは表示されない
        $response->assertDontSee($retrievedItemsA[0]->name);
        $response->assertDontSee($retrievedItemsA[1]->name);

        // 自分以外のアイテムは表示される
        $response->assertSee($retrievedItemsB[0]->name);
        $response->assertSee($retrievedItemsB[1]->name);
        $response->assertSee($retrievedItemsB[2]->name);

        // マイリストへ移動すると
        $response = $this->get(route('items.index') . '?page=mylist');
        $response->assertStatus(200);

        // 自分のアイテムは表示されない
        $response->assertDontSee($retrievedItemsA[0]->item_name);
        $response->assertDontSee($retrievedItemsA[1]->item_name);

        // 自分以外のアイテムも表示されない（いいねをしていないので）
        $response->assertDontSee($retrievedItemsB[0]->item_name);
        $response->assertDontSee($retrievedItemsB[1]->item_name);
        $response->assertDontSee($retrievedItemsB[2]->item_name);
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
