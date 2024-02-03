<?php

class Authenticate{

    public static function handle() {
        if (!isset($_SESSION['user'])) {
            Router::redirect('login');
        }
    }

}
