<?php

namespace App;

use App\Util\Database;
use App\Util\Error;
use App\Util\Request;

class App {
    private static Database $db;
    public Router $router;
    public int $code = 200;

    public static function db(): Query {
        return self::$db->query();
    }

    public static function request(): Request {
        return new Request($_GET, $_POST);
    }

    private static function connectDb(): void {
        self::$db = new Database(
            $_SERVER['DB_HOST'],
            $_SERVER['DB_PORT'],
            $_SERVER['DB_USER'],
            $_SERVER['DB_PASS'],
            $_SERVER['DB_NAME']
        );
    }

    public function run(string $path): array {
        $response = [
            'message' => 'Success',
            'data' => []
        ];

        try {
            self::connectDb();
            $response['data'] = $this->router->run($path);
        } catch (\PDOException $e) {
            $this->code = 500;
            $response['message'] = "DB error";
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
