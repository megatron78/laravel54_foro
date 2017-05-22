<?php

namespace Tests\Browser;

use App\Post;
use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreatePostsTest extends DuskTestCase
{

    use DatabaseMigrations;

    //Having
    protected $title='Esta es una pregunta.';
    protected $content='Este es el contenido.';

    /**
     * User create a post test.
     *
     * @return void
     */
    function test_a_user_create_a_post()
    {
        //When
        $this->browse(function (Browser $browser) {
            $user=factory(User::class)->create();
            $browser->loginAs($user);
            $browser->visitRoute('posts.create')
                ->type('title', $this->title)
                ->type('content', $this->content)
                ->press('Publicar')
                ->assertSee($this->title);
            //->assertPathIs('posts/1-Esta es una pregunta');

            //Then
            $this->assertDatabaseHas('posts', [
                'title' => $this->title,
                'content' => $this->content,
                'pending' => true,
                'user_id' => $user->id,
            ]);

            $post = Post::first();

            //Test the author is subscribed automatically to the post.
            $this->assertDatabaseHas('subscriptions', [
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);

            //Test user is redirected to details page
            //$this->assertSeeIn('h1', this->title);
        });
    }

    /**
     * Creating a post requires user authentication
     */
    function test_creating_a_post_requires_authentication()
    {
        //When
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('posts.create')
                ->assertRouteIs('login');
        });
    }

    function test_create_post_form_validation()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();
            $browser->loginAs($user);
            $browser->visitRoute('posts.create')
                ->press('Publicar')
                ->assertRouteIs('posts.create')
                ->assertSeeIn('#field_title .help-block', 'El campo título es obligatorio.')
                ->assertSeeIn('#field_content .help-block', 'El campo contenido es obligatorio.');
        });
    }
}
