<?php

const NAMESPACE_ROOT = 'App';

spl_autoload_register(function ($class) {
    $class = str_replace(['\\', NAMESPACE_ROOT], [DIRECTORY_SEPARATOR, 'src'], $class);
    $file = __DIR__ . DIRECTORY_SEPARATOR . $class . '.php';

    if (file_exists($file))
        include $file;
});

$url = parse_url($_SERVER['REQUEST_URI']);

$router = new \App\Router('api');
$router->get('/products', fn() => "Hello world with GET request");
$router->post('/products', fn() => "Hello world with POST request");

header("Content: application/json");
echo json_encode($router->run($url['path']));