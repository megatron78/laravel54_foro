<?php

namespace Tests\Feature;

use App\Token;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthenticationTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * @test
     */
    function a_user_can_login_with_a_token_url()
    {
        $this->browse(function (Browser $browser) {
            //Having
            $user = factory(User::class)->create();

            $token = Token::generateFor($user);

            //When
            $browser->visit("ingreso/{$token->token}")
                ->assertAuthenticated()
                ->assertAuthenticatedAs($user)
                //->assertPathIs('/')
                ->logout();


            $this->assertDatabaseMissing('tokens', [
                'id' => $token->id,
            ]);
        });
    }

    /**
     * @test
     */
    function a_user_cannot_login_with_an_invalid_token()
    {
        $this->browse(function (Browser $browser) {
            //Having
            $user = factory(User::class)->create();

            $token = Token::generateFor($user);

            $invalidToken = 'megatoken';//str_random(60);

            //When
            $browser->visit("ingreso/{$invalidToken}");
                //->assertRouteIs('token');

            $this->dontSeeIsAuthenticated();

            $this->assertDatabaseHas('tokens', [
                'id' => $token->id,
            ]);
        });
    }

    /**
     * @test
     */
    function a_user_cannot_use_the_same_token_twice()
    {
        $this->browse(function (Browser $browser) {
            //Having
            $user = factory(User::class)->create();

            $token = Token::generateFor($user);

            $token->ingreso();

            Auth::logout();

            //When
            $browser->visit("ingreso/{$token->token}");
                //->assertGuest();

            $this->dontSeeIsAuthenticated();
        });
    }

    /**
     * @test
     */
    function the_token_expires_after_30_minutes()
    {
        $this->browse(function (Browser $browser) {
            //Having
            $user = factory(User::class)->create();

            $token = Token::generateFor($user);

            Carbon::setTestNow(Carbon::parse('+31 minutes'));

            //When
            $browser->visitRoute('ingreso',['token' =>$token->token]);
            //->assertGuest();

            $this->dontSeeIsAuthenticated();
        });
    }

    /**
     * @test
     */
    function the_token_is_case_sensitive()
    {
        $this->browse(function (Browser $browser) {
            //Having
            $user = factory(User::class)->create();

            $token = Token::generateFor($user);

            //When
            $browser->visitRoute('ingreso',['token' =>strtolower($token->token)]);
            //->assertGuest();

            $this->dontSeeIsAuthenticated();
        });
    }
}
