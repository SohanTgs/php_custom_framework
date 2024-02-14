<?php

use App\System;
use App\Session;

function systemDetails(){
    $system['name'] = 'sohantgs';
    $system['version'] = '1.0';
    $system['build_version'] = '1.0';
    return $system;
}

function view($view, $data = []) {
    extract($data);
    include TGS_ROOT . '/core/resources/views/' . $view . '.php';
}

function dd(...$args) {
    foreach ($args as $arg) {
        echo "<pre style='background: #001140;color: #00ff4e;padding: 10px;'>";
            var_dump($arg);
        echo '</pre>';
    }
    die;
}

function dump(...$args) {
    foreach ($args as $arg) {
        echo "<pre style='background: #001140;color: #00ff4e;padding: 10px;'>";
            var_dump($arg);
        echo '</pre>';
    }
}

function toObject($args){
    if (is_array($args)) {
        return (object) array_map(__FUNCTION__, $args);
    } else {
        return $args;
    }
}

function env($envKey = null){
    $envFilePath = TGS_ROOT .'/core/.env';
    $envVariables = [];
    if (file_exists($envFilePath)) {
        $lines = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '=') !== false && substr($line, 0, 1) !== '#') {
                list($key, $value) = explode('=', $line, 2);
                $envVariables[$key] = $value;
            }
        }
    }

    if($envKey){
        return $envVariables[$envKey];
    }

    return $envVariables;
}

function systemInstance()   {
    return System::getInstance();
}

function keyToTitle($text){
    return ucfirst(preg_replace("/[^A-Za-z0-9 ]/", ' ', $text));
}

function redirectBack($notify = null){
    if (isset($_SERVER['HTTP_REFERER'])) {
        $url = $_SERVER['HTTP_REFERER'];
    } else {
    //     $url = home_url();
    }

    Router::away($url);
}

function session(){
    return new Session();
}

function assets($path = null){
    return 200;
}