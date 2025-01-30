<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh --seed');
    }

    // すべての情報が商品詳細ページに表示されている
    public function testItemInfoDisplayed(): void
    {
        $item = Item::find(1);
        $response = $this->get(route('item.detail', $item->id));
        $response->assertStatus(200)
            ->assertSee($item->item_image)
            ->assertSee($item->item_name)
            ->assertSee($item->brand_name)
            ->assertSee($item->price)
            ->assertSee($item->favorites->count())
            ->assertSee($item->comments->count())
            ->assertSee($item->description)
            ->assertSee($item->condition->condition);

        //カテゴリ???

        foreach ($item->comments as $comment) {
            $response->assertSee($comment->pivot->comment) //コメント内容
                ->assertSee($comment->name); //コメントしたユーザー情報
        }
    }

    // 複数選択されたカテゴリが商品詳細ページに表示されている
    public function testRelatedCategoriesDisplayed(): void
    {
        $item = Item::find(1);
        $response = $this->get(route('item.detail', $item->id));
        $response->assertStatus(200)
            ->assertSee('ファッション')
            ->assertSee('メンズ')
            ->assertSee('アクセサリー')
            ->assertDontSee('家電')
            ->assertDontSee('インテリア')
            ->assertDontSee('レディース')
            ->assertDontSee('コスメ')
            ->assertDontSee('本')
            ->assertDontSee('ゲーム')
            ->assertDontSee('スポーツ')
            ->assertDontSee('キッチン')
            ->assertDontSee('ハンドメイド')
            ->assertDontSee('おもちゃ')
            ->assertDontSee('ベビー・キッズ');
    }
}
