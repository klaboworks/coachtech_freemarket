<?php

namespace Tests\Feature;

use Tests\TestCase;


class LogoutTest extends TestCase
{
    public function testLogout(): void
    {
        $user = $this->createUser();
        $response = $this->get(route('login'));
        $response->assertStatus(200)
            ->assertViewIs('auth.login')
            ->assertSee('ログイン');

        $response = $this->post(route('login'), [
            'email' => 'user1@test.com',
            'password' => 'password',
        ]);
        $this->assertAuthenticatedAs($user);
        $response->assertStatus(302)
            ->assertRedirectToRoute('items.index');

        $response = $this->post(route('logout'));
        $response->assertStatus(302);
        $this->assertGuest();
    }
}
