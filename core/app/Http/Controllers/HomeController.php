<?php

class HomeController {

    public function index() {
        $pageTitle = 'Index';
        return view('home', compact('pageTitle'));
    }

    public function about() { 
        $pageTitle = 'About';
        return view('home', compact('pageTitle'));
    }
}


