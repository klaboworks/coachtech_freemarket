<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;

class SearchTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testSearchItem(): void
    {
        $itemA = Item::factory()->create(['item_name' => 'とてもいい商品']);
        $itemB = Item::factory()->create(['item_name' => 'すごくいい商品']);

        $response = $this->get(route('items.index'));
        $response->assertStatus(200);
        $response->assertSee($itemA->item_name);
        $response->assertSee($itemB->item_name);

        $searchWord = 'とても';

        // 検索->絞り込み表示確認
        $response = $this->get(route('items.index') . '?search=' . $searchWord);
        $response->assertStatus(200);
        $response->assertSee($itemA->item_name);
        $response->assertDontSee($itemB->item_name);

        // 検索が実行できていればマイリストページへ遷移
        // 検索が実行できていなければ中断される
        $this->assertTrue(session()->has('search_query'), '検索実行てきていないので中断');
        $response = $this->get(route('items.index') . '?page=mylist&search=' . session('search_query'));
        $response->assertStatus(200);

        // マイリストページでも検索ワードが保持されている
        $response->assertSee($searchWord);
    }
}
