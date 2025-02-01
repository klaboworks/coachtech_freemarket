<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class MylistTest extends TestCase
{
    // いいねした商品だけが表示される
    public function testDisplayLikedItem(): void
    {
        Item::factory(5)->create();
        $user = User::inRandomOrder()->first();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
        $likedItem = Item::where('user_id', '!=', $user->id)->first();
        $otherItems = Item::where('id', '<>', $likedItem->id)
            ->where('user_id', '!=', $user->id)->get();

        // いいね処理
        $response = $this->post(route('like', $likedItem->id), [
            'item_id' => $likedItem->id,
            'user_id' => $user->id,
        ]);
        $response->assertStatus(302);

        $response = $this->get(route('items.index'));
        $response->assertStatus(200);
        $response->assertSee($likedItem->item_name);
        foreach ($otherItems as $otherItem) {
            $response->assertSee($otherItem->item_name);
        }

        $response = $this->get(route('items.index') . '?page=mylist');
        $response->assertStatus(200);
        $response->assertSee($likedItem->item_name);
        foreach ($otherItems as $otherItem) {
            $response->assertDontSee($otherItem->item_name);
        }
    }

    public function testBoughtItemHasLabel()
    {
        Item::factory(5)->create(['is_sold' => false]);
        $user = User::inRandomOrder()->first();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        // 購入処理
        $boughtItem = Item::inRandomOrder()->first();
        $response = $this->post(route('purchase.store', $boughtItem->id), [
            'item_id' => $boughtItem->id,
            'user_id' => $user->id,
        ]);
        $response->assertStatus(302);
    }
}
