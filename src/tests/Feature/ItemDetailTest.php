<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    // すべての情報が商品詳細ページに表示されている
    public function testItemInfoDisplayed(): void
    {
        $item = Item::factory()->create();

        $response = $this->get(route('item.detail', $item->id));
        $response->assertStatus(200);
        $response
            ->assertSee($item->getImagePath($item->item_image))
            ->assertSee($item->item_name)
            ->assertSee($item->brand_name)
            ->assertSee($item->price)
            ->assertSee($item->favorites->count())
            ->assertSee($item->comments->count())
            ->assertSee($item->item_description)
            ->assertSee($item->categories->count())
            ->assertSee($item->condition->condition);

        // コメントユーザー情報、コメント内容表示
        foreach ($item->comments as $comment) {
            $response->assertSee($comment->avatar);
            $response->assertSee($comment->name);
            $response->assertSee($comment->pivot->comment);
        }
    }

    // 複数選択されたカテゴリが商品詳細ページに表示されている
    public function testRelatedCategoriesDisplayed(): void
    {
        $item = Item::factory()->create();

        $response = $this->get(route('item.detail', $item->id));
        $response->assertStatus(200);

        $this->assertEquals(2, $item->categories->count());
    }
}
