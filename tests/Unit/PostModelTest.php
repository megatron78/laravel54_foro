<?php
/**
 * Created by PhpStorm.
 * User: Mauricio Molina
 * Date: 2017-05-12
 * Time: 11:01
 */

namespace Tests\Unit;

use App\Post;
use Tests\TestCase;

class PostModelTest extends TestCase
{
    function test_adding_a_title_generates_a_slug()
    {
        $post = new Post([
            'title' => 'Cómo instalar laravel'
        ]);

        $this->assertSame('como-instalar-laravel', $post->slug);
    }

    function test_editing_title_changes_slug()
    {
        $post = new Post([
            'title' => 'Cómo instalar laravel'
        ]);

        $post->title = 'Cómo instalar laravel 5.4 LTS';

        $this->assertSame('como-instalar-laravel-54-lts', $post->slug);
    }
}