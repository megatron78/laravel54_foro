<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Illuminate\Support\Facades\Notification;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WriteCommentTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_a_user_can_write_a_comment()
    {
        Notification::fake();

        $this->browse(function (Browser $browser) {
            $user=factory(User::class)->create();
            $browser->loginAs($user);
            //Having
            $post=factory(Post::class) -> create();

            $browser->visit($post->url)
                ->type('comment', 'Un comentario.')
                ->press('Publicar comentario');
                //->assertPathIs($post->url);

            $this->assertDatabaseHas('comments', [
                'comment' => 'Un comentario.',
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);

        });
    }
}
