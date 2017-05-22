<?php

namespace App\Http\Controllers;

use App\Post;
use App\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscribe(Post $post)
    {
        /* Equivalentes
        Subscription::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
        ]);*/

        //auth()->user()->subscriptions()->attach($post);
        auth()->user()->subscribeTo($post);

        return redirect($post->url);
    }

    public function unsubscribe(Post $post)
    {
        auth()->user()->unsubscribeFrom($post);

        return redirect($post->url);
    }
}
