<?php

namespace Tests\Feature\features;

use App\Posts;
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
    public function test_a_user_can_see_a_post_details()
    {
        //Having
        $user = factory(User::class)->create([
            'name' => 'Megatron',
        ]);

        $post = factory(Posts::class)->make([
            'title' => 'Este es el título del post.',
            'content' => 'Este es el contenido del post.'
        ]);

        $user->posts()->save($post);

        //When
        $this->get(route('posts.show', $post));
    }
}
