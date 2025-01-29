<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    // use RefreshDatabase;

    /**
     * A basic feature test example.
     */

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

        $response->assertSessionHasErrors(['email']);
        $this->assertEquals('メールアドレスを入力してください', session('errors')->first('email'));
    }

    // パスワードが入力されていない場合、バリデーションメッセージが表示される
    public function testPasswordInputRequired(): void
    {
        $this->assertLoginPageIsDisplayed();
        $response = $this->post(route('login'), [
            'email' => 'test_user',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertEquals('パスワードを入力してください', session('errors')->first('password'));
    }

    // 入力情報が間違っている場合、バリデーションメッセージが表示される
    public function testFailLogin(): void
    {
        $this->assertLoginPageIsDisplayed();
        $response = $this->post(route('login'), [
            'email' => 'test_user',
            'password' => 'wrong_password',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertEquals('ログイン情報が登録されていません', session('errors')->first('email'));
    }

    // 正しい情報が入力された場合、ログイン処理が実行される
    public function testSuccessLogin(): void
    {
        $this->assertLoginPageIsDisplayed();
        $user = User::where('email', 'test@example.com')->first();
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('items.index'));
    }
}
