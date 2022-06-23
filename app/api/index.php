<?php

$url = parse_url($_SERVER['REQUEST_URI']);

header("Content: application/json");

$response = [
    'data' => 'Hello world',
    'message' => 'Success',
    'location' => $url['path']
];

echo json_encode($response);