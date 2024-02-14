<?php

Router::get('/', 'HomeController@index', ['name'=>'index']);
Router::get('/about', 'HomeController@about');

Router::get('/login', 'AuthController@login', ['name'=>'login', 'middleware'=>'IfLogin']);
Router::get('/authenticate', 'AuthController@authenticate', ['name'=>'authenticate']);
Router::get('/logout', 'AuthController@logout', ['name'=>'logout', 'middleware'=>'Authenticate']);
Router::get('/dashboard', 'AuthController@dashboard', ['name'=>'dashboard', 'middleware'=>'Authenticate']);

Router::handleRoute();