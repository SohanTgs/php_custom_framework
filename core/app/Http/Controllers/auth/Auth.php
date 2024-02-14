<?php

namespace App\Http\Controllers\Auth;

use App\Models\Admin;

class Auth {

    public static function login($username, $password) {
        $admin = Admin::where('username', $username)->where('password', $password)->first();
        if ($admin) {
            $_SESSION['user'] = $admin;
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
