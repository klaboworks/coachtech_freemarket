<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use App\Models\CategoryItem;
use App\Models\Condition;
use App\Models\Comment;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemDetailTest extends TestCase
{
    // use RefreshDatabase;

    // protected function setUp(): void
    // {
    //     parent::setUp();
    //     Category::factory(10)->create();
    //     Condition::factory(3)->create();
    //     Item::factory(5)->create();
    //     CategoryItem::factory(10)->create();
    //     Comment::factory(3)->create();
    // }

    // // すべての情報が商品詳細ページに表示されている
    // public function testItemInfoDisplayed(): void
    // {
    //     $item = Item::find(1);
    //     $response = $this->get(route('item.detail', $item->id));
    //     $response->assertStatus(200)
    //         ->assertSee($item->getImagePath($item->item_image))
    //         ->assertSee($item->item_name)
    //         ->assertSee($item->brand_name)
    //         ->assertSee($item->price)
    //         ->assertSee($item->favorites->count())
    //         ->assertSee($item->comments->count())
    //         ->assertSee($item->item_description)
    //         ->assertSee($item->categories->count())
    //         ->assertSee($item->condition->condition);

    //     $this->assertEquals('item_1', $item->item_name);
    //     $this->assertEquals('brand_1', $item->brand_name);
    //     $this->assertEquals(1000, $item->price);
    //     $this->assertEquals(0, $item->favorites->count());
    //     $this->assertEquals(3, $item->comments->count());
    //     $response
    //         ->assertSee('comment1')
    //         ->assertSee('comment2')
    //         ->assertSee('comment3')
    //         ->assertSee('user1')
    //         ->assertSee('user2')
    //         ->assertSee('user3');
    //     $this->assertEquals('description_1', $item->item_description);
    //     $this->assertEquals(2, $item->categories->count());
    //     $this->assertEquals('condition_1', $item->condition->condition);
    // }

    // // 複数選択されたカテゴリが商品詳細ページに表示されている
    // public function testRelatedCategoriesDisplayed(): void
    // {
    //     $item = Item::find(1);
    //     $response = $this->get(route('item.detail', $item->id));
    //     $response->assertStatus(200);
    //     $this->assertEquals(2, $item->categories->count());
    //     $response
    //         ->assertSee('category_1')
    //         ->assertSee('category_6');
    // }
}
