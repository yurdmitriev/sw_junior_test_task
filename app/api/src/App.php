<?php

namespace App;

use App\Util\Error;

class App {
    public Router $router;
    public int $code = 200;

    public static function db() {
    }

    public function run(string $path): array {
        $response = [
            'message' => 'Success',
            'data' => []
        ];

        try {
            $response['data'] = $this->router->run($path);
        } catch (Error $e) {
            $this->code = $e->getCode();
            $response['message'] = $e->getMessage();
        }

        return $response;
    }

    public function __construct(string $scope) {
        $this->router = new Router($scope);
    }
}
