<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class ItemsIndexTest extends TestCase
{
    // protected function setUp(): void
    // {
    //     parent::setUp();
    //     $this->seedItems();
    // }

    public function testDisplayAllItems(): void
    {
        $this->seedItems();
        $response = $this->get(route('items.index'));
        $response->assertStatus(200);
    }

    public function testDisplayWithoutMyItems()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        /** @var \App\Models\User $userA */ // User モデルのパスに合わせて修正
        /** @var \App\Models\User $userB */ // User モデルのパスに合わせて修正
        Item::factory(2)->create(['user_id' => $userA->id]);
        Item::factory(3)->create(['user_id' => $userB->id]);

        $retrievedItemsA = Item::where('user_id', $userA->id)->get();
        $retrievedItemsB = Item::where('user_id', $userB->id)->get();

        $this->actingAs($userA);
        $response = $this->get(route('items.index'));

        $response->assertDontSee($retrievedItemsA[0]->name);
        $response->assertDontSee($retrievedItemsA[1]->name);

        $response->assertSee($retrievedItemsB[0]->name);
        $response->assertSee($retrievedItemsB[1]->name);
        $response->assertSee($retrievedItemsB[2]->name);
        $response->assertStatus(200);
    }

    // public function testSoldItemsHaveLabel(): void
    // {
    //     $response = $this->get(route('items.index'));
    //     $response->assertStatus(200);
    //     $response->assertSee('Sold');


    //     // 購入済みアイテムを表示する…？
    //     $soldOutItems = Item::where('is_sold', true)->get();
    //     foreach ($soldOutItems as $item) {
    //         $response->assertSee($item->item_name);
    //     }
    // }

    // public function testDisplayWithoutMyItems(): void
    // {
    //     $user = User::find(1);

    //     $ownItems = Item::where('user_id', $user->id)->get();
    //     $otherItems = Item::where('user_id', '!=', $user->id)->get();

    //     $response = $this->actingAs($user)->get(route('items.index'));
    //     $response->assertStatus(200);
    //     $this->assertAuthenticatedAs($user);

    //     foreach ($ownItems as $item) {
    //         $response->assertDontSee($item->item_name);
    //     }

    //     foreach ($otherItems as $item) {
    //         $response->assertSee($item->item_name);
    //     }
    // }
}
