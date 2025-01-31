<?php

namespace Tests\Feature;

use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function testLogout(): void
    {
        /** @var \App\Models\User $user */
        $user = $this->createUser();
        $response = $this->actingAs($user)->get(route('mypage'));
        $response->assertStatus(200);
        $this->assertAuthenticatedAs($user);

        $response = $this->post(route('logout'));
        $response->assertStatus(302);
        $this->assertGuest();
    }
}
