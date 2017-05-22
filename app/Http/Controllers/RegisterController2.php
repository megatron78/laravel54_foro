<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController2 extends Controller{
    public function create() {
        return view('register2/creater');
    }

    public function store() {
    }
}
