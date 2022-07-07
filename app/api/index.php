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

$app = new \App\App('api');
$app->router->get('/products', [\App\Controllers\ProductsController::class, 'list']);
$app->router->post('/products', [\App\Controllers\ProductsController::class, 'add']);
$app->router->get('/products/types', [\App\Controllers\ProductsController::class, 'listTypes']);

$response = $app->run($url['path']);
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
http_response_code($app->code);
echo json_encode($response);