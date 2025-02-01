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
            ->assertSee($allItems[0]->name)
            ->assertSee($allItems[1]->name)
            ->assertSee($allItems[2]->name)
            ->assertSee($allItems[3]->name)
            ->assertSee($allItems[4]->name);
    }

    // 購入済み商品は「Sold」と表示される
    public function testItemsWithSoldLabel()
    {
        Item::factory()->create(['is_sold' => true]);

        $response = $this->get(route('items.index'));
        $response->assertStatus(200);

        $response->assertSee('sold');
    }

    // 自分の商品を除外した全商品を取得する
    public function testDisplayWithoutMyItems()
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

        $response->assertDontSee($retrievedItemsA[0]->name);
        $response->assertDontSee($retrievedItemsA[1]->name);

        $response->assertSee($retrievedItemsB[0]->name);
        $response->assertSee($retrievedItemsB[1]->name);
        $response->assertSee($retrievedItemsB[2]->name);
    }
}
