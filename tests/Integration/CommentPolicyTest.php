<?php

namespace Tests\Feature\Integration;

use App\Comment;
use App\Policies\CommentPolicy;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentPolicyTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    function test_the_post_author_can_select_a_comment_as_an_answer()
    {
        $comment = factory(Comment::class)->create();
        $policy = new CommentPolicy;

        $this->assertTrue(
            $policy->accept($comment->post->user, $comment));
    }

    function test_non_authors_cannot_select_a_comment_as_an_answer()
    {
        $comment = factory(Comment::class)->create();
        $policy = new CommentPolicy;

        $this->assertFalse(
            $policy->accept(factory(User::class)->create(), $comment));
    }
}
