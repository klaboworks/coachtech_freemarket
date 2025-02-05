<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Item;

class ItemDetailTest extends TestCase
{
    // すべての情報が商品詳細ページに表示されている
    public function testItemInfoDisplayed(): void
    {
        $itemImage = UploadedFile::fake()->image('item.jpg');
        $imagePath = Storage::disk('public')->putFile('item_images', $itemImage);

        $item = Item::factory()->create([
            'item_image' => $imagePath,
        ]);

        $files = Storage::disk('public')->files('item_images');
        $this->assertCount(1, array_filter($files, function ($file) use ($itemImage) {
            return str_contains($file, $itemImage->hashName());
        }));

        $response = $this->get(route('item.detail', $item->id));

        $response->assertStatus(200);
        $response
            ->assertSee(asset('storage/' . $item->item_image))
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

        Storage::disk('public')->delete($imagePath);
    }

    // 複数選択されたカテゴリが商品詳細ページに表示されている
    public function testRelatedCategoriesDisplayed(): void
    {
        $item = Item::factory()->create();
        // Itemfactory内のコードで紐づくカテゴリ2つ作成しています。

        $response = $this->get(route('item.detail', $item->id));
        $response->assertStatus(200);

        $response->assertSee('category1')
            ->assertSee('category2');
    }
}
