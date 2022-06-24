<?php

const NAMESPACE_ROOT = 'App';

spl_autoload_register(function ($class) {
    $class = str_replace(['\\', NAMESPACE_ROOT], [DIRECTORY_SEPARATOR, 'src'], $class);
    $file = __DIR__ . DIRECTORY_SEPARATOR . $class . '.php';

    if (file_exists($file))
        include $file;
});

$url = parse_url($_SERVER['REQUEST_URI']);

header("Content: application/json");

$response = [
    'data' => 'Hello world',
    'message' => 'Success',
    'location' => $url['path']
];

echo json_encode($response);