<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;

class FavoriteTest extends TestCase
{
    public function Favorite(): void
    {
        $item = Item::factory()->create();
        /** @var \App\Models\User $user */
        $user = $this->createUser();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get(route('item.detail', $item->id));
        $response->assertStatus(200);

        // いいね数は 0、アイコンは未いいね状態
        $this->assertEquals(0, $item->favorites->count());
        $response->assertSee('like_inactive.png');

        // いいね実行
        $response = $this->post(route('like', $item->id), [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $response->assertStatus(302);

        // いいね登録処理確認（favoritesテーブル参照）
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $item->load('favorites');
        $response = $this->get(route('item.detail', $item->id));
        $response->assertStatus(200);

        // いいね合計値増加、アイコンはいいね済み状態に色変化
        $this->assertEquals(1, $item->favorites->count());
        $response->assertDontSee('like_inactive.png');
        $response->assertSee('like_active.png');

        // いいね解除実行
        $response = $this->post(route('like', $item->id), [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $response->assertStatus(302);

        // いいね登録解除処理確認（favoritesテーブル参照）
        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $item->load('favorites');
        $response = $this->get(route('item.detail', $item->id));
        $response->assertStatus(200);

        // いいね合計値減少、アイコンは未いいね状態に戻る
        $this->assertEquals(0, $item->favorites->count());
        $response->assertSee('like_inactive.png');
        $response->assertDontSee('like_active.png');
    }
}
