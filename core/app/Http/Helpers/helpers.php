<?php

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

