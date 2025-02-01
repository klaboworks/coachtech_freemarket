<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class SellTest extends TestCase
{
    public function testSellItem(): void
    {
        Storage::fake('public');
        $image = UploadedFile::fake()->image('test.jpg');

        /** @var \App\Models\User $user */
        $user = $this->createUser();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
        $response = $this->get(route('sell.create'));
        $response->assertStatus(200);

        $response = $this->post(route('sell.store'), [
            'condition_id' => 1,
            'user_id' => $user->id,
            'item_image' => $image,
            'item_name' => 'testItem',
            'brand_name' => 'testBrand',
            'price' => 1000,
            'item_description' => 'This item is very good',
            'is_sold' => false,
        ]);
        $response->assertStatus(302);
    }
}
