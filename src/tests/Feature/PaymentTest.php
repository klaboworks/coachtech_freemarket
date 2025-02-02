<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;

class PaymentTest extends TestCase
{
    public function test_example(): void
    {
        $item = Item::factory()->create();
        /** @var \App\Models\User $user */
        $user = $this->createUser();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get(route('item.detail', $item->id));
        $response->assertStatus(200);
    }
}
