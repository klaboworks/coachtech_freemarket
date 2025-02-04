<?php

namespace Tests\Feature;

use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public function assertRegisterPageIsDisplayed()
    {
        $response = $this->get(route('register'));
        $response->assertStatus(200)
            ->assertViewIs('auth.register')
            ->assertSee('会員登録');
    }

    // 名前が入力されていない場合、バリデーションメッセージが表示される
    public function testNameIsRequired(): void
    {
        $this->assertRegisterPageIsDisplayed();
        $response = $this->post(route('register'), [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name']);
        $response->assertInvalid(['name' => 'お名前を入力してください',]);
        $this->assertGuest();
    }

    // メールアドレスが入力されていない場合、バリデーションメッセージが表示される
    public function testEmailIsRequired(): void
    {
        $this->assertRegisterPageIsDisplayed();
        $response = $this->post(route('register'), [
            'name' => 'test_user',
            'email' => '',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
        $response->assertInvalid(['email' => 'メールアドレスを入力してください']);
        $this->assertGuest();
    }

    // パスワードが入力されていない場合、バリデーションメッセージが表示される
    public function testPasswordIsRequired(): void
    {
        $this->assertRegisterPageIsDisplayed();
        $response = $this->post(route('register'), [
            'name' => 'test_user',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('password');
        $response->assertInvalid(['password' => 'パスワードを入力してください']);
        $this->assertGuest();
    }

    // パスワードが7文字以下の場合、バリデーションメッセージが表示される
    public function testPasswordIsOver8Characters(): void
    {
        $this->assertRegisterPageIsDisplayed();
        $response = $this->post(route('register'), [
            'name' => 'test_user',
            'email' => 'test@example.com',
            'password' => 'pass',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('password');
        $response->assertInvalid(['password' => 'パスワードは8文字以上で入力してください']);
        $this->assertGuest();
    }

    // パスワードが確認用パスワードと一致しない場合、バリデーションメッセージが表示される
    public function testPasswordMatch(): void
    {
        $this->assertRegisterPageIsDisplayed();
        $response = $this->post(route('register'), [
            'name' => 'test_user',
            'email' => 'test@example.com',
            'password' => 'passwordA',
            'password_confirmation' => 'passwordB',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('password');
        $response->assertInvalid(['password' => 'パスワードと一致しません']);
        $this->assertGuest();
    }

    // 全ての項目が入力されている場合、会員情報が登録され、ログイン画面に遷移される
    public function testRegistrationSucceed(): void
    {
        $userName = 'test_user';
        $userEmail = 'test@example.com';

        $this->assertRegisterPageIsDisplayed();
        $response = $this->post(route('register'), [
            'name' => $userName,
            'email' => $userEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // usersテーブルデータ登録確認
        $this->assertDatabaseHas('users', [
            'name' => $userName,
            'email' => $userEmail,
        ]);

        $response->assertValid();
        $response->assertStatus(200)
            ->assertViewIs('users.edit');
    }
}
