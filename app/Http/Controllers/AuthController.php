<?php

namespace App\Http\Controllers;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate() {}

    public function logout() {}
}
