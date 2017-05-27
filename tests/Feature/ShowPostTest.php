<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowPostTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test a user can see a post details.
     *
     * @return void
     */
    function test_a_user_can_see_a_post_details()
    {
        //Having
        $user = factory(User::class)->create([
            'first_name' => 'Megatron',
            'last_name' => 'Molina',
        ]);

        $post = factory(Post::class)->create([
            'title' => 'Este es el título del post.',
            'content' => 'Este es el contenido del post.',
            'user_id' => $user->id,
        ]);

        //When
        $this->get($post->url);
    }

    /*
    function test_post_url_with_wrong_slug_still_work()
    {
        //Having
        $user = factory(User::class)->create([
            'name' => 'Megatron',
        ]);

        $post = factory(Post::class)->make([
            'title' => 'Old title',
        ]);

        $user->posts()->save($post);

        $url = $post->url;

        $post->update(['title' => 'New title']);

        $this->get($url)
            ->assertStatus(404);
    }*/

    function test_old_urls_are_redirected()
    {
        //Having
        $post = factory(Post::class)->create([
            'title' => 'Old title',
        ]);

        $url = $post->url;

        $post->update(['title' => 'New title']);

        $this->get($url)
            ->assertStatus(301);
    }
}
