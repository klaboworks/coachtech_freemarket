<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    public function assertLoginPageIsDisplayed()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200)
            ->assertViewIs('auth.login')
            ->assertSee('ログイン');
    }

    //  メールアドレスが入力されていない場合、バリデーションメッセージが表示される
    public function testEmailInputRequired(): void
    {
        $this->assertLoginPageIsDisplayed();
        $response = $this->post(route('login'), [
            'email' => '',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email']);
        $response->assertInvalid(['email' => 'メールアドレスを入力してください']);
        $this->assertGuest();
    }

    // パスワードが入力されていない場合、バリデーションメッセージが表示される
    public function testPasswordInputRequired(): void
    {
        $this->assertLoginPageIsDisplayed();
        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['password']);
        $response->assertInvalid(['password' => 'パスワードを入力してください']);
        $this->assertGuest();
    }

    // 入力情報が間違っている場合、バリデーションメッセージが表示される
    public function testFailLogin(): void
    {
        $this->assertLoginPageIsDisplayed();
        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'wrong_password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email']);
        $response->assertInvalid(['email' => 'ログイン情報が登録されていません']);
        $this->assertGuest();
    }

    // 正しい情報が入力された場合、ログイン処理が実行される
    public function testSuccessLogin(): void
    {
        $user = User::factory()->create(['email' => 'user1@test.com', 'password' => bcrypt('password')]);
        $this->assertLoginPageIsDisplayed();
        $response = $this->post(route('login'), [
            'email' => 'user1@test.com',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $this->assertAuthenticatedAs($user);
    }
}
