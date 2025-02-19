<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class PaymentMethodTest extends DuskTestCase
{
    // use DatabaseMigrations;

    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/purchase/7')
                ->assertSeeIn('.selected-payment', '選択してください');

            $browser->select('#payment-selector', 1)
                ->assertSeeIn('.selected-payment', 'コンビニ支払い');
        });
    }
}
