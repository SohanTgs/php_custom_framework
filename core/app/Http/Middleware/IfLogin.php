<?php

class IfLogin{

    public static function handle() {
        if (isset($_SESSION['user'])) {
            Router::redirect('dashboard');
        }
    }

}
