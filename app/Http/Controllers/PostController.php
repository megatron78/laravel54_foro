<?php

namespace App\Http\Controllers;
use App\Posts;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Posts $post) {
        return view('posts.show', compact('post'));
    }
}
