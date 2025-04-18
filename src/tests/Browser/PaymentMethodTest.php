<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Item;
use App\Models\Payment;
use App\Models\User;

class PaymentMethodTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testPaymentMethodSelection(): void
    {
        $this->browse(function (Browser $browser) {
            $item = Item::factory()->create(['is_sold' => false]);
            Payment::factory()->createMany([
                ['payment' => 'コンビニ支払い'],
                ['payment' => 'カード支払い'],
            ]);
            $user = User::factory()->create();
            $browser->loginAs($user)
                ->visit('/purchase/' . $item->id)
                ->pause(1000)
                ->assertSeeIn('.selected-payment', '選択してください');

            $browser->select('#payment-selector', 1)
                ->pause(1000)
                ->assertSeeIn('.selected-payment', 'コンビニ支払い')
                ->dump();
        });
    }
}
