<?php

namespace App;

class Session
{
    public function __construct()
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public function has($key)
    {
        $flashKey = $key . '.____flash';
        if (isset($_SESSION[$flashKey])) {
            return true;
        }
        if (isset($_SESSION[$key])) {
            return true;
        }
        return false;
    }

    public function put($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        $flashKey = $key . '.____flash';
        if (isset($_SESSION[$flashKey])) {
            $sessionValue = $_SESSION[$flashKey];
            unset($_SESSION[$flashKey]); // Remove flash data after reading
        } elseif (isset($_SESSION[$key])) {
            $sessionValue = $_SESSION[$key];
        }
        return $sessionValue ?? null;
    }

    public function flash($key, $value)
    {
        $this->put($key . '.____flash', $value);
    }

    public function forget($key)
    {
        unset($_SESSION[$key]);
    }
}

