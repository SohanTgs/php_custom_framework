<?php

namespace App\Http\Controllers\Auth;

class Auth {

    public static function login($username, $password) {
        if ($username == 'admin' && $password == 'admin') {
            $_SESSION['user'] = $username;
            return true;
        }
        return false;
    }

    public static function logout() {
        session_destroy();
    }

    public static function user() {
        return $_SESSION['user'] ?? null;
    }

    public static function check() {
        return isset($_SESSION['user']);
    }
}
