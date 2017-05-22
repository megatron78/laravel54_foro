<?php

namespace Tests\Integration;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostIntegrationTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    public function test_a_slug_is_generated_and_saved_on_database()
    {
        $post=factory(Post::class)->create([
            'title' => 'Cómo instalar laravel',
        ]);

        $this->assertDatabaseHas('posts', [
            'slug' => 'como-instalar-laravel'
        ]);

        //$this->assertSame('como-instalar-laravel', $post->slug);

        //$this->assertSame('como-instalar-laravel', $post->fresh()->slug);
    }
}
