<?php

namespace Tests\Feature;

use App\{User, Token};
use App\Mail\TokenMail;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegistrationTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * @test
     *
     * @return void
     */
    function test_a_user_can_create_an_account()
    {
        Mail::fake();

        $this->browse(function (Browser $browser) {
            $browser->visitRoute('register2.create')
                ->type('email', 'megatronldu@gmail.com')
                ->type('username', 'megatron')
                ->type('first_name','Mauricio')
                ->type('last_name','Molina')
                ->press('Registrarse');
        });

        $this->assertDatabaseHas('users', [
            'email' => 'megatronldu@gmail.com',
            'username' => 'megatron',
            'first_name' => 'Mauricio',
            'last_name' => 'Molina'
        ]);

        $user = User::first();

        $this->assertDatabaseHas('tokens', [
            'user_id' => $user->id,
        ]);

        $token = Token::where('user_id', $user->id)->first();

        $this->assertNotNull($token);

        /*
        Mail::assertSent(TokenMail::class, function($mail) use ($token, $user) {
            return $mail->hasTo($user) && $mail->token->id === $token->id;
        });
        */
        /*
        $this->seeRouteIs('register_confirmation')
        ->see('Gracias por registrarse')
        ->see('Se ha enviado un enlace para iniciar sesión');
        */

    }
}
