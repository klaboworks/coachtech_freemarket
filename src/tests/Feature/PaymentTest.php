<?php

namespace Tests\Feature;

use Symfony\Component\DomCrawler\Crawler;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Payment;

class PaymentTest extends TestCase
{
    // public function test_example(): void
    // {
    //     $item = Item::factory()->create();
    //     $payment = Payment::factory()->create(['payment' => 'カード払い']);
    //     /** @var \App\Models\User $user */
    //     $user = $this->createUser();
    //     $this->actingAs($user);
    //     $this->assertAuthenticatedAs($user);

    //     $response = $this->get(route('purchase.create', $item->id));
    //     $response->assertStatus(200);

    //     $crawler = new Crawler($response->getContent());
    //     $selectedPaymentTd = $crawler->filter('#selected-payment');
    //     $this->assertCount(1, $selectedPaymentTd);
    //     $this->assertEquals('選択してください', $selectedPaymentTd->text());


    //     // dd($response->getContent());
    //     // 現状 DomCrawler で対応中
    //     // Laravel Dusk を使うか否か


    //     $crawler = new Crawler($response->getContent());
    //     $this->assertEquals('選択してください', $selectedPaymentTd->text());
    // }
}
