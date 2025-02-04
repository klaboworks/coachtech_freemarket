<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class CommentTest extends TestCase
{
    public function testCanPostComment(): void
    {
        $item = Item::factory()->create();
        $user = User::inRandomOrder()->first();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        // 最初のコメント数は 1（Itemファクトリーの生成による）
        $response = $this->get(route('item.detail', $item->id));
        $response->assertStatus(200);
        $this->assertEquals(1, $item->comments->count());

        // コメント投稿実行
        $response = $this->post(route('comment.store', $item->id), [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'I want this item!'
        ]);
        $response->assertStatus(302);

        $item->refresh();
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'I want this item!',
        ]);

        // コメント数は 2 コメント内容表示確認
        $response = $this->get(route('item.detail', $item->id));
        $this->assertEquals(2, $item->comments->count());
        $response->assertSee('I want this item!');
    }

    // ログイン前のユーザーはコメントを送信できない
    public function testCannotPostComment(): void
    {
        $item = Item::factory()->create();

        $response = $this->get(route('item.detail', $item->id));
        $response->assertStatus(200);
        $this->assertGuest();

        $response = $this->post(route('comment.store', $item->id), [
            'user_id' => null,
            'item_id' => $item->id,
            'comment' => 'comment'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    // コメントが入力されていない場合、バリデーションメッセージが表示される
    public function testCommentInvalidNull(): void
    {
        $item = Item::factory()->create();
        $user = User::inRandomOrder()->first();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        // 最初のコメント数は 1（ファクトリー生成）
        $response = $this->get(route('item.detail', $item->id));
        $this->assertEquals(1, $item->comments->count());
        $response->assertStatus(200);

        // コメント投稿実行
        $response = $this->post(route('comment.store', $item->id), [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => null,
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('comment');
        $response->assertInvalid(['comment' => 'コメントを入力してください']);

        // コメント数は変わらず 1
        $item->refresh();
        $response = $this->get(route('item.detail', $item->id));
        $this->assertEquals(1, $item->comments->count());
    }

    // コメントが256字以上の場合、バリデーションメッセージが表示される
    public function testCommentInvalidOver256(): void
    {
        $item = Item::factory()->create();
        $user = User::inRandomOrder()->first();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        // 最初のコメント数は 1（ファクトリー生成）
        $response = $this->get(route('item.detail', $item->id));
        $response->assertStatus(200);
        $this->assertEquals(1, $item->comments->count());

        // コメント投稿実行
        $response = $this->post(route('comment.store', $item->id), [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => fake()->realText(256),
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('comment');
        $response->assertInvalid(['comment' => 'コメントは最大255文字です']);

        // コメント数は変わらず 1
        $item->refresh();
        $response = $this->get(route('item.detail', $item->id));
        $this->assertEquals(1, $item->comments->count());
    }
}
