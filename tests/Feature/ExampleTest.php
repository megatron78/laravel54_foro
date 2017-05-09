<?php

namespace Tests\Feature;

use App\User;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends DuskTestCase
{

    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testBasicVisit()
    {

        $user = factory(User::class)->create( [
            'name' => 'Megatron',
            'email' => 'megatron@manateesoft.com',
        ]);

        $this->actingAs($user,'api')
            ->get('api/user')
            ->assertSee('Megatron')
            ->assertSee('megatron@manateesoft.com');

    }
}
