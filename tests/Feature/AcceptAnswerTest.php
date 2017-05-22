<?php

namespace Tests\Feature;

use App\Comment;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AcceptAnswerTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_the_posts_author_can_accept_a_comment_as_the_posts_answer() {
        $this->browse(function (Browser $browser) {
            $comment = factory(Comment::class)->create([
                'comment' => 'Esta va a ser la respuesta del post'
            ]);
            //dd($comment->post->url);
            $browser->loginAs($comment->post->user);
            $browser->visit($comment->post->url)
                ->press('Aceptar respuesta')
                ->assertSeeIn('.answer', 'Esta va a ser la respuesta del post');

            $this->assertDatabaseHas('posts', [
                'id' => $comment->post_id,
                'pending' => false,
                'answer_id' => $comment->id,
            ]);

        });
    }

    function test_non_posts_author_dont_see_accept_answer_button() {
        $this->browse(function (Browser $browser) {
            $comment = factory(Comment::class)->create([
                'comment' => 'Esta va a ser la respuesta del post'
            ]);
            $browser->loginAs(factory(User::class)->create());
            $browser->visit($comment->post->url)
                ->assertDontSee('Aceptar respuesta');
        });
    }

    function test_non_posts_author_cannot_accept_a_comment_as_the_posts_answer_button() {
        /*$this->browse(function (Browser $browser) {
            $comment = factory(Comment::class)->create([
                'comment' => 'Esta va a ser la respuesta del post'
            ]);
            $browser->loginAs(factory(User::class)->create());

            $this->post(route('comments.accept', $comment));

            $this->assertDatabaseHas('posts', [
                'id' => $comment->post_id,
                'pending' => true,
            ]);
        });*/
        $comment = factory(Comment::class)->create([
            'comment' => 'Esta va a ser la respuesta del post'
        ]);
        $this->actingAs(factory(User::class)->create())
            ->post(route('comments.accept', $comment));
        $this->assertDatabaseHas('posts', [
            'id' => $comment->post_id,
            'pending' => true,
        ]);
    }

    function test_the_accpet_button_is_hidden_when_the_comment_is_already_the_post_answer() {
        $this->browse(function (Browser $browser) {
            $comment = factory(Comment::class)->create([
                'comment' => 'Esta va a ser la respuesta del post'
            ]);
            $browser->loginAs($comment->post->user);

            $comment->markAsAnswer();

            $browser->visit($comment->post->url)
                ->assertDontSee('Aceptar respuesta');
        });
    }
}
