<?php

Router::get('/', 'HomeController@index', ['name'=>'index']);
Router::get('/about', 'HomeController@about');

Router::get('/login', 'AuthController@login', ['name'=>'login', 'middleware'=>'IfLogin']);
Router::get('/authenticate', 'AuthController@authenticate', ['name'=>'authenticate']);
Router::get('/logout', 'AuthController@logout', ['name'=>'logout', 'middleware'=>'Authenticate']);
Router::get('/dashboard', 'AuthController@dashboard', ['name'=>'dashboard', 'middleware'=>'Authenticate']);

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