<?php

namespace Tests\Feature;

use App\Mail\TokenMail;
use App\Token;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RequestTokenTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * @test
     */
    function a_user_can_request_a_token()
    {
        //Having
        Mail::fake();

        $user = factory(User::class)->create(['email' => 'megatronldu@gmail.com']);

        //When
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('token')
                ->type('email', 'megatronldu@gmail.com')
                ->press('Solicitar token');
        });

        //Then: A new token is generated in the database
        $token = Token::where('user_id', $user->id)->first();

        $this->assertNotNull($token);

        /*
        //And sent to the user
        Mail::assertSent(TokenMail::class, function ($mail) use ($token) {
            return $mail->token->id === $token->id;
        });*/

        $this->dontSeeIsAuthenticated();
    }

    /**
     * @test
     */
    function a_user_request_a_token_without_any_email()
    {
        //Having
        Mail::fake();

        //When
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('token')
                ->press('Solicitar token')
                ->assertSeeIn('#field_email .help-block', 'El campo correo electrónico es obligatorio')
                ->assertSee('El campo correo electrónico es obligatorio');
        });

        //Then: A new token is not generated in the database
        $token = Token::first();

        $this->assertNull($token);

        //And sent to the user
        Mail::assertNotSent(TokenMail::class, function ($mail) use ($token) {
            return $mail->token->id === $token->id;
        });

        $this->dontSeeIsAuthenticated();
    }

    /**
     * @test
     */
    function a_user_request_a_token_with_an_invalid_email()
    {
        //When
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('token')
                ->type('email', 'Megatron')
                ->press('Solicitar token');
                //->assertSee('El campo correo electrónico es obligatorio.');
        });
    }

    /**
     * @test
     */
    function a_user_can_request_a_token_with_a_non_existent_email()
    {
        //Having
        $user = factory(User::class)->create(['email' => 'megatronldu@gmail.com']);

        //When
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('token')
                ->type('email', 'galvatronldu@gmail.com')
                ->press('Solicitar token')
                ->assertSee('correo electrónico no existe.');
        });

        //Then: A new token is generated in the database
        $token = Token::where('user_id', $user->id)->first();

        $this->assertNull($token);

        /*
        //And sent to the user
        Mail::assertSent(TokenMail::class, function ($mail) use ($token) {
            return $mail->token->id === $token->id;
        });*/

        $this->dontSeeIsAuthenticated();
    }
}
