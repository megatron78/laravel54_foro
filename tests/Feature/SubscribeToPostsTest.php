<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SubscribeToPostsTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_a_user_can_subscribe_to_a_post()
    {
        $this->browse(function (Browser $browser) {
            //Having
            $post = factory(Post::class)->create();
            $user = factory(User::class)->create();
            $browser->loginAs($user);

            //When
            $browser->visit($post->url)
                ->press('Suscribirse al post')
                //->assertPathIs($post->url)
                ->assertDontSee('Suscribirse al post');

            //Then
            $this->assertDatabaseHas('subscriptions', [
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);

        });
    }

    function test_a_user_can_unsubscribe_from_a_post() {
        $this->browse(function (Browser $browser) {
            //Having
            $post = factory(Post::class)->create();
            $user = factory(User::class)->create();
            $user->subscribeTo($post);

            $browser->loginAs($user);

            //When
            $browser->visit($post->url)
                ->assertDontSee('Suscribirse al post')
                ->press('Desuscribirse al post')
                //->assertPathIs($post->url)
                ->assertDontSee('Desuscribirse al post');

            //Then
            $this->assertDatabaseMissing('subscriptions', [
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);

        });
    }
}
