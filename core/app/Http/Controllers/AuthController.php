<?php

use App\Http\Controllers\Auth\Auth;
use App\Models\Admin;

class AuthController {

    public function login() {
        $pageTitle = 'Login';
        return view('login', compact('pageTitle'));
    }

    public function dashboard(){
        $admin = Admin::first();
        return $admin;
    }

    public function authenticate() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (Auth::login($username, $password)) {
            return Router::redirect('dashboard');
        }

        return Router::redirect('login');
    }

    public function logout() {
        Auth::logout();
        return Router::redirect('login');
    }
}
