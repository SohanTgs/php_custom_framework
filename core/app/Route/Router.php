<?php

class Router {

    private static $routes = [];

    public static function get($uri, $controllerMethod, $params = []) {
        self::$routes[$uri] = [
            'controllerMethod' => $controllerMethod,
            'name' => @$params['name'],
            'middleware' => @$params['middleware'],
        ];
    }

    public static function route($uri) {
        return self::$routes[$uri] ?? null;
    }

    public static function url($name, $parameters = []) {
        foreach (self::$routes as $uri => $route) {
            if ($route['name'] === $name) {
                $url = $uri;
                foreach ($parameters as $key => $value) {
                    $url = explode('/', $_SERVER['PHP_SELF']).'/'.str_replace("{{$key}}", $value, $url);
                }
                return self::baseUrl().$url;
            }
        }
        return '/';
    }

    public static function redirect($name, $parameters = []) {
        $url = self::url($name, $parameters);
        header("Location: $url");
        exit();
    }

    public static function baseUrl(){
        // Base directory
        $base_dir = str_replace('\\', '/', TGS_ROOT);

        // Server protocol
        $protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';

        // Domain name
        $domain = $_SERVER['SERVER_NAME'];

        // Document root
        $doc_root = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);

        // Base URL
        $base_url = str_replace($doc_root, '', $base_dir);
        $base_url = '/' . ltrim($base_url, '/');

        // Server port
        $port = $_SERVER['SERVER_PORT'];
        $disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";

        // Complete base URL
        return "$protocol://$domain$disp_port$base_url";
    }
}

