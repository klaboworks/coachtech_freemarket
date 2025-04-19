<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\Item;

class ShippingAddressTest extends TestCase
{
    public function testChangeShippingAddress(): void
    {
        Http::fake([
            'https://api.stripe.com/*' => Http::response(['id' => 'mock_session_id', 'url' => 'mock_url'], 200),
        ]);

        $item = Item::factory()->create(['is_sold' => false]);
        $payment = \App\Models\Payment::factory()->create();
        /** @var \App\Models\User $user */
        $user = $this->createUser();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        // 配送先住所変更画面
        $response = $this->get(route('purchase.edit.address', $item->id));
        $response->assertStatus(200);

        // 入力する配送先住所
        $postal_code = '123-4567';
        $address1 = '東京都';
        $address2 = '千代田区';

        // 配送先住所変更登録
        $response = $this->post(route('purchase.update.address', $item->id), [
            'postal_code' => $postal_code,
            'address1' => $address1,
            'address2' => $address2,
        ]);
        $response->assertStatus(302);

        // 登録処理で取得した住所をセッションから読み取り格納
        $oldPostalCode = session('_old_input.postal_code');
        $oldAddress1 = session('_old_input.address1');
        $oldAddress2 = session('_old_input.address2');

        // 変更後住所反映確認
        // 登録処理から渡された住所が購入画面で表示されているか
        $response = $this->get(route('purchase.create', $item->id));
        $response->assertStatus(200);
        $response->assertSee($oldPostalCode)
            ->assertSee($oldAddress1)
            ->assertSee($oldAddress2);
        // また表示されている住所は入力した住所とイコールか
        $this->assertEquals($postal_code, $oldPostalCode);
        $this->assertEquals($address1, $oldAddress1);
        $this->assertEquals($address2, $oldAddress2);

        // 商品を購入※登録処理から渡された住所を挿入
        $response = $this->post(route('purchase.store', $item->id), [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_id' => $payment->id,
            'seller_id' => $item->user_id,
            'deal_done' => false,
            'seller_rated' => false,
            'postal_code' => $oldPostalCode,
            'address1' => $oldAddress1,
            'address2' => $oldAddress2,
        ]);
        $response->assertStatus(302);

        // 購入証明
        // 登録処理から渡された住所->入力した住所で購入登録されているか
        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_id' => $payment->id,
            'seller_id' => $item->user_id,
            'deal_done' => false,
            'seller_rated' => false,
            'postal_code' => $oldPostalCode,
            'address1' => $oldAddress1,
            'address2' => $oldAddress2,
        ]);
    }
}
