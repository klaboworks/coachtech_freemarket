<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class ItemsIndexTest extends TestCase
{
    // 全商品を表示する
    public function testDisplayAllItems(): void
    {
        $allItems = Item::factory(5)->create();
        $response = $this->get(route('items.index'));
        $response->assertStatus(200);

        $this->assertEquals(5, $allItems->count());
        $response
            ->assertSee($allItems[0]->item_name)
            ->assertSee($allItems[1]->item_name)
            ->assertSee($allItems[2]->item_name)
            ->assertSee($allItems[3]->item_name)
            ->assertSee($allItems[4]->item_name);
    }

    // 購入済み商品は「Sold」と表示される
    public function testItemsWithSoldLabel(): void
    {
        Item::factory()->create(['is_sold' => true]);

        $response = $this->get(route('items.index'));
        $response->assertStatus(200);

        $response->assertSee('sold');
    }

    // 自分の商品を除外した全商品を取得する
    public function testDisplayWithoutMyItems(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        /** @var \App\Models\User $userA */
        /** @var \App\Models\User $userB */
        Item::factory(2)->create(['user_id' => $userA->id]);
        Item::factory(3)->create(['user_id' => $userB->id]);

        $retrievedItemsA = Item::where('user_id', $userA->id)->get();
        $retrievedItemsB = Item::where('user_id', $userB->id)->get();

        $this->actingAs($userA);
        $response = $this->get(route('items.index'));
        $response->assertStatus(200);

        // 自分のアイテムは表示されない
        $response->assertDontSee($retrievedItemsA[0]->item_name);
        $response->assertDontSee($retrievedItemsA[1]->item_name);

        // 自分以外のアイテムは表示される
        $response->assertSee($retrievedItemsB[0]->item_name);
        $response->assertSee($retrievedItemsB[1]->item_name);
        $response->assertSee($retrievedItemsB[2]->item_name);
    }
}
