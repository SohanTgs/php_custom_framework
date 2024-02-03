<?php

use App\Http\Controllers\Auth\Auth;

class AuthController {

    public function login() {
        $pageTitle = 'Login';
        return view('login', compact('pageTitle'));
    }

    public function dashboard(){
        return 200;
    }

    public function authenticate() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (Auth::login($username, $password)) {
            Router::redirect('dashboard');
        }

        Router::redirect('login');
    }

    public function logout() {
        Auth::logout();
        Router::redirect('login');
    }
}
