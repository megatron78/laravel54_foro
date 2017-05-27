<?php

namespace App\Http\Controllers;

use App\Token;

class LoginController2 extends Controller
{
    public function ingreso($token)
    {
        $token = Token::findActive($token);

        if ($token == null) {
            alert('Este enlace ya expiró.', 'danger');
            return redirect()->route('token');
        }

        $token->ingreso();

        return redirect('/');
    }
}
