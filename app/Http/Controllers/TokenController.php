<?php

namespace App\Http\Controllers;

use App\{Token, User};
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function create() {
        return view('token.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'email' => 'required|email|exists:users',
        ]);

        $user = User::where('email', $request->get('email'))->first();

        Token::generateFor($user)->sendByEmail();

        alert('Se ha enviado un enlace a su correo para iniciar sesión.');

        return back();
    }

    public function confirm() {
        return view('token.confirm');
    }
}
