<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Payment;

class PurchaseTest extends TestCase
{
    public function testPurchase(): void
    {
        Http::fake([
            'https://api.stripe.com/*' => Http::response(['id' => 'mock_session_id', 'url' => 'mock_url'], 200),
        ]);

        $itemImage = UploadedFile::fake()->image('item.jpg');
        $imagePath = Storage::disk('public')->putFile('item_images', $itemImage);

        $item = Item::factory()->create([
            'item_image' => $imagePath,
            'is_sold' => false
        ]);

        /** @var \App\Models\User $user */
        $user = $this->createUser();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get(route('purchase.create', $item->id));
        $response->assertStatus(200);

        $payment = Payment::factory()->create();

        // 商品を購入
        $response = $this->post(route('purchase.store', $item->id), [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_id' => $payment->id,
            'seller_id' => $item->user_id,
            'deal_done' => false,
            'seller_rated' => false,
            'postal_code' => '123-4567',
            'address1' => '東京都',
            'address2' => '千代田区',
        ]);
        $response->assertStatus(302);

        // 購入証明
        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_id' => $payment->id,
            'seller_id' => $item->user_id,
            'deal_done' => false,
            'seller_rated' => false,
            'postal_code' => '123-4567',
            'address1' => '東京都',
            'address2' => '千代田区',
        ]);

        // 商品が売り切れになっているか
        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'is_sold' => true,
        ]);

        // 商品一覧ページへ移動、Soldラベル確認
        $response = $this->get(route('items.index'));
        $response->assertStatus(200);
        $response->assertSee(asset('storage/' . $item->item_image));
        $response->assertSee($item->item_name);
        $response->assertSee('Sold');

        // マイページの購入した商品一覧を確認
        $response = $this->get(route('mypage') . '?page=buy');
        $response->assertStatus(200);
        $response->assertSee(asset('storage/' . $item->item_image));
        $response->assertSee($item->item_name);

        Storage::disk('public')->delete($imagePath);
    }
}
