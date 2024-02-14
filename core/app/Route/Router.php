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

    public static function away($url) {
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

    public static function handleRoute() {
        // Get the current URI
        $uri = rtrim($_SERVER['REQUEST_URI'], '/'); // Remove trailing slash

        $base = explode('/', $_SERVER['PHP_SELF'])[1];
        $resultString = str_replace("/$base", "/", $uri);
        $uri = preg_replace('#/+#', '/', $resultString);

        // Get the route details
        $route = Router::route($uri);

        if ($route) {
            [$controller, $method] = explode('@', $route['controllerMethod']);

            // Include the necessary files and create controller instance
            include TGS_ROOT . "/core/app/Http/Controllers/$controller.php";
            $controllerInstance = new $controller();

            // Call the method and get the result
            $result = $controllerInstance->$method();

            $middleware = @$route['middleware'];
            if ($middleware) {
                // Handle middleware before creating the controller instance
                $middlewareClass = $middleware;
                $middlewareFile = TGS_ROOT . "/core/app/Http/Middleware/$middlewareClass.php";

                if (file_exists($middlewareFile)) {
                    include $middlewareFile;

                    if (class_exists($middlewareClass)) {
                        $middlewareClass::handle();
                    } else {
                        die("Middleware class not found: $middlewareClass");
                    }
                } else {
                    die("Middleware file not found: $middlewareFile");
                }
            }

            // Check if the result is an array
            if (is_array($result)) {
                // Output the data as JSON
                header('Content-Type: application/json');
                echo json_encode($result);
            } else {
                // Handle other types of responses as needed
                echo $result;
            }
            // Handle the result as needed
        } else {
            // Handle 404 - Page not found
            echo "404 - Page not found";
        }
    }
}

