<?php

namespace Tests\Feature;

use App\Mail\TokenMail;
use App\{Token,User};
use Illuminate\Support\Facades\Mail;
use Tests\DuskTestCase;

class TokenMailTest extends DuskTestCase
{
    /**
     * @test
     */
    function it_sends_a_link_with_the_token()
    {
        $user = new User([
            'first_name' => 'Mauricio',
            'last_name' => 'Molina',
            'email' => 'megatronldu@gmail.com',
        ]);

        $token = new Token([
            'token' => 'this-is-a-token',
            'user' => $user,
        ]);

        $transport = Mail::getSwiftMailer()->getTransport();

        //$transport->flush();

        Mail::send(new TokenMail($token));


        $message = $transport->messages()->first();

        $this->assertTrue(true);

    }
}
