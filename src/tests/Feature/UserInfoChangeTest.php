<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;

class UserInfoChangeTest extends TestCase
{
    public function testChangeUserInformation(): void
    {
        $avatar = UploadedFile::fake()->image('item.jpg');
        $avatarPath = Storage::disk('public')->putFile('', $avatar);

        // ユーザー情報
        $userName = 'テストユーザー';
        $userPostalCode = '123-4567';
        $userAddress1 = '東京都';
        $userAddress2 = '千代田区';

        $user = User::factory()->create([
            'name' => $userName,
            'avatar' => $avatarPath,
            'postal_code' => $userPostalCode,
            'address1' => $userAddress1,
            'address2' => $userAddress2,
        ]);

        /** @var \App\Models\User $user */
        $response = $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        // プロフィール編集画面表示
        $response = $this->get(route('edit.profile'));
        $response->assertStatus(200)
            ->assertSee('プロフィール設定');

        // ユーザー情報初期設定表示確認
        $response->assertSee(asset('storage/' . $user->avatar))
            ->assertSee('テストユーザー')
            ->assertSee('123-4567')
            ->assertSee('東京都')
            ->assertSee('千代田区');

        Storage::disk('public')->delete($avatarPath);
    }
}
