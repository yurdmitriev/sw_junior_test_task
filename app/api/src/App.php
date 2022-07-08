<?php

namespace App;

use App\Util\Database;
use App\Util\Error;
use App\Util\Request;

/**
 * Application class
 */
class App {
    /**
     * @var Database Database instance
     */
    private static Database $db;

    /**
     * @var Router Router instance
     */
    public Router $router;

    /**
     * @var int Response code
     */
    public int $code = 200;

    /**
     * SQL builders generator
     * @return Query
     */
    public static function db(): Query {
        return self::$db->query();
    }

    /**
     * Get a GET and POST parameters
     * @return Request
     */
    public static function request(): Request {
        return new Request($_GET, $_POST);
    }

    /**
     * Init database instance
     * @return void
     */
    private static function connectDb(): void {
        self::$db = new Database(
            $_SERVER['DB_HOST'],
            $_SERVER['DB_PORT'],
            $_SERVER['DB_USER'],
            $_SERVER['DB_PASS'],
            $_SERVER['DB_NAME']
        );
    }

    /**
     * Execute application
     * @param string $path
     * @return array
     */
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

    /**
     * @param string $scope Prefix of URLs
     */
    public function __construct(string $scope) {
        $this->router = new Router($scope);
    }
}
