<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\User;

class UserInfoGetTest extends TestCase
{
    public function testGetUserInformation(): void
    {
        // ユーザー画像作成
        Storage::fake('public');
        $avatar = UploadedFile::fake()->image('avatar.jpg');
        $imagePath = Storage::disk('public')->putFile('', $avatar);

        // ユーザー情報
        $userName = 'テストユーザー';
        $userPostalCode = '123-4567';
        $userAddress1 = '東京都';
        $userAddress2 = '千代田区';

        $user = User::factory()->create([
            'name' => $userName,
            'avatar' => $imagePath,
            'postal_code' => $userPostalCode,
            'address1' => $userAddress1,
            'address2' => $userAddress2,
        ]);

        // 出品アイテムと購入アイテムを2つずつ作成
        $listedItems = Item::factory()->createMany([
            [
                'item_name' => 'I listed this Item!',
                'user_id' => $user->id,
            ],
            [
                'item_name' => 'Another listed Item!',
                'user_id' => $user->id,
            ],
        ]);
        $boughtItems = Item::factory()->createMany([
            ['item_name' => 'I bought this Item!'],
            ['item_name' => 'I bought this too!'],
        ]);
        $payment = Payment::factory()->create();
        foreach ($boughtItems as $boughtItem) {
            Purchase::factory()->create([
                'user_id' => $user->id,
                'item_id' => $boughtItem->id,
                'payment_id' => $payment->id,
                'postal_code' => $userPostalCode,
                'address1' => $userAddress1,
                'address2' => $userAddress2,
            ]);
        }

        /** @var \App\Models\User $user */
        $response = $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        // プロフィール画面表示
        $response = $this->get(route('mypage'));
        $response->assertStatus(200);

        // ユーザー情報表示確認
        $response->assertSee($user->getAvatarPath($user->avatar))
            ->assertSee($userName);

        // 初期ページで出品した商品が表示される
        $response->assertSee('I listed this Item!');
        $response->assertSee('Another listed Item!');
        $response->assertDontSee('I bought this Item!');
        $response->assertDontSee('I bought this too!');

        // 出品した商品ページの表示確認
        $response = $this->get(route('mypage') . '?page=sell');
        $response->assertStatus(200);
        $response->assertSee('I listed this Item!');
        $response->assertSee('Another listed Item!');
        $response->assertDontSee('I bought this Item!');
        $response->assertDontSee('I bought this too!');

        // 購入したアイテムの表示確認
        $response = $this->get(route('mypage') . '?page=buy');
        $response->assertStatus(200);
        $response->assertDontSee('I listed this Item!');
        $response->assertDontSee('Another listed Item!');
        $response->assertSee('I bought this Item!');
        $response->assertSee('I bought this too!');

        // プロフィール編集画面表示
        $response = $this->get(route('edit.profile'));
        $response->assertStatus(200)
            ->assertSee('プロフィール設定');

        // ユーザー情報初期設定表示確認
        $response->assertSee($user->getAvatarPath($user->avatar))
            ->assertSee('テストユーザー')
            ->assertSee('123-4567')
            ->assertSee('東京都')
            ->assertSee('千代田区');
    }
}
