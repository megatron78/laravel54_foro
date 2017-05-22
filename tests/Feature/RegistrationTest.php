<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Mail;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\TestCase;
use TheSeer\Tokenizer\Token;

class RegistrationTest extends DuskTestCase
{
    /**
     * @test
     *
     * @return void
     */
    function test_a_user_can_create_an_account()
    {
        Mail::fake();

        $this->browse(function (Browser $browser) {
            $browser->visitRoute('register2')
                ->type('email', 'megatronldu@gmail.com')
                ->type('username', 'megatron')
                ->type('first_name','Mauricio')
                ->type('last_name','Molina')
                ->press('Registrarse');


        });
    }
}
