<?php

namespace Tests\Feature;

use App\Post;
use Carbon\Carbon;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostListTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_a_user_see_post_list_and_go_to_details()
    {
        $this->browse(function (Browser $browser) {
            $post=factory(Post::class)->create([
                'title' => '¿Debo usar Laravel 5.3 o 5.1 LTS?',
            ]);
            $browser->visit('/')
                ->assertSeeIn('h1', 'Post')
                ->assertSee($post->title)
                ->clickLink($post->title);
        });
    }

    function test_posts_are_paginated()
    {
        $this->browse(function (Browser $browser) {
            //Having
            $firstPost=factory(Post::class) -> create([
                'title' => 'Post más antiguo',
                'created_at' => Carbon::now()->subDays(2),
            ]);

            factory(Post::class)->times(15)->create([
                'created_at' => Carbon::now()->subDay(),
            ]);

            $lastPost=factory(Post::class) -> create([
                'title' => 'Post más reciente',
                'created_at' => Carbon::now(),
            ]);
            $browser->visit('/')
                ->assertSee($lastPost->title)
                ->assertDontSee($firstPost->title)
                ->clickLink('2')
                ->assertSee($firstPost->title)
                ->assertDontSee($lastPost->title);
        });
    }
}
