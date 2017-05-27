<?php

namespace App\Http\Controllers;

use App\{Token, User};
use Illuminate\Http\Request;

class RegisterController2 extends Controller{
    public function create() {
        return view('register2.create');
    }

    public function store(Request $request) {
        $user = User::create($request->all());
        Token::generateFor($user)->sendByEmail();
        return back();
    }
}
