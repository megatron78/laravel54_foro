<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SupportMarkdownTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_the_post_content_support_markdown()
    {
        $this->browse(function (Browser $browser) {
            $importantText = 'Un texto muy importante';
            $user = factory(User::class)->create();
            $post = factory(Post::class)->create([
                'content' => "La primera parte del texto. **$importantText**. La última parte del texto.",
            ]);
            $browser->loginAs($user)
                ->visit($post->url)
                ->assertSeeIn('strong', $importantText);
        });
    }

    function test_the_post_is_the_code_is_escaped() {
        $this->browse(function (Browser $browser) {
            $xssAttack = "<script>alert('Sharing code!')</script>";
            $user = factory(User::class)->create();
            $post = factory(Post::class)->create([
                'content' => "`$xssAttack`. Normal Text.",
            ]);
            $browser->loginAs($user)
                ->visit($post->url)
                ->assertSee($xssAttack)
                ->assertSee('Normal Text.');
        });
    }

    function test_xss_attack() {
        $this->browse(function (Browser $browser) {
            $xssAttack = "<script>alert('Malicious JS!')</script>";
            $user = factory(User::class)->create();
            $post = factory(Post::class)->create([
                'content' => "$xssAttack. Normal Text.",
            ]);
            $browser->loginAs($user)
                ->visit($post->url)
                ->assertDontSee($xssAttack);
                //->assertSee('Normal Text.');
            //->seeText('Texto normal'); //todo: fix this
        });
    }

    function test_xss_attack_with_html() {
        $this->browse(function (Browser $browser) {
            $xssAttack = "<img src='img.jpg'>";
            $user = factory(User::class)->create();
            $post = factory(Post::class)->create([
                'content' => "$xssAttack. Normal Text.",
            ]);
            $browser->loginAs($user)
                ->visit($post->url)
                ->assertDontSee($xssAttack); //seeText, dontSeeText
        });
    }
}
