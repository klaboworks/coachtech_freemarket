<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class ItemsIndexTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh --seed');
    }

    public function testDisplayAllItems(): void
    {
        $response = $this->get(route('items.index'));
        $response->assertStatus(200);

        $items = Item::all();
        foreach ($items as $item) {
            $response->assertSee($item->item_image);
            $response->assertSee($item->item_name);
        }
    }

    public function testSoldItemsHaveLabel(): void
    {
        $response = $this->get(route('items.index'));
        $response->assertStatus(200);
        $response->assertSee('Sold');


        // 購入済みアイテムを表示する…？
        $soldOutItems = Item::where('is_sold', true)->get();
        foreach ($soldOutItems as $item) {
            $response->assertSee($item->item_name);
        }
    }

    public function testDisplayWithoutMyItems(): void
    {
        $user = User::find(1);

        $ownItems = Item::where('user_id', $user->id)->get();
        $otherItems = Item::where('user_id', '!=', $user->id)->get();

        $response = $this->actingAs($user)->get(route('items.index'));
        $response->assertStatus(200);
        $this->assertAuthenticatedAs($user);

        foreach ($ownItems as $item) {
            $response->assertDontSee($item->item_name);
        }

        foreach ($otherItems as $item) {
            $response->assertSee($item->item_name);
        }
    }
}
