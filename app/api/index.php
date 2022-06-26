<?php

const NAMESPACE_ROOT = 'App';

spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $pos = strpos($class, NAMESPACE_ROOT);
    if ($pos !== false) {
        $class = substr_replace($class, 'src', $pos, strlen(NAMESPACE_ROOT));
    }
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