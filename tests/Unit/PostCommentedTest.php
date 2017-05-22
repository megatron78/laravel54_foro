<?php

namespace Tests\Unit;

use App\Comment;
use App\Notifications\PostCommented;
use App\Post;
use App\User;
use Illuminate\Notifications\Messages\MailMessage;
use Tests\TestCase;

class PostCommentedTest extends TestCase
{
    /**
     * @test
     */
    function it_builds_a_mail_messages()
    {
        $post = new Post([
            'title' => 'Título del post',
        ]);

        $author = new User([
            'name' => 'Megatron',
        ]);

        $comment = new Comment();
        $comment->post = $post;
        $comment->user = $author;

        $subscriber = new User();

        $notification = new PostCommented($comment);

        $message = $notification->toMail($subscriber);

        $this->assertInstanceOf(MailMessage::class, $message);

        $this->assertSame(
            'Nuevo comentario en: Título del post',
            $message->subject
        );

        $this->assertSame(
            'Megatron escribió un comentario en: Título del post',
            $message->introLines[0]
        );

        $this->assertSame($comment->post->url, $message->actionUrl
        );

    }
}
