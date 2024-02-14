<?php

namespace App;

use App\Database\Database;
use App\Session;

class System {

    public $middleware;
    public $bindValue = [];
    private static $instance = null;

    public function __construct() {
        session();
    }

    public static $facades = [
        'db'=>Database::class,
        'session'=>Session::class
    ];

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    public function bootRoute(){
        require_once TGS_ROOT  . '/core/app/route/Router.php';
        require_once TGS_ROOT . '/core/routes/web.php';
    }

}