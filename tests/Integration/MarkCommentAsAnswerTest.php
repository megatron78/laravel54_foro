<?php

namespace Tests\Feature\Integration;

use App\Comment;
use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MarkCommentAsAnswerTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    function test_a_post_can_be_answered()
    {
        $post = factory(Post::class) -> create();

        $comment = factory(Comment::class)->create([
            'post_id' => $post->id,
        ]);

        $comment->markAsAnswer();

        $this->assertTrue($comment->fresh()->answer);

        $this->assertFalse($post->fresh()->pending);
    }

    function test_a_post_can_only_have_one_answer()
    {
        $post = factory(Post::class) -> create();

        $comments = factory(Comment::class)->times(2)->create([
            'post_id' => $post->id,
        ]);

        $comments->first()->markAsAnswer();
        $comments->last()->markAsAnswer();

        $this->assertFalse($comments->first()->fresh()->answer);

        $this->assertTrue($comments->last()->fresh()->answer);
    }
}
