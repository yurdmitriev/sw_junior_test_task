<?php

namespace App;

use App\Util\Error;

class Router {
    private string $prefix;
    private array $routes = [];

    private function register($method, $uri, $action): void {
        $this->routes[] = new Route($method, $uri, $action);
    }

    public function get(string $uri, $action): void {
        $this->register('GET', $uri, $action);
    }

    public function post(string $uri, $action): void {
        $this->register('POST', $uri, $action);
    }

    public function delete(string $uri, $action): void {
        $this->register('DELETE', $uri, $action);
    }

    public function run(string $url) {
        $uri = $this->prepareUri($url);

        foreach ($this->routes as $route) {
            if ($route->getUri() == $uri && $route->getMethod() == $_SERVER['REQUEST_METHOD']) {
                return $route->run();
            }
        }

        throw new Error("This method doesn't exist", 404);
    }

    private function prepareUri(string $url): string {
        if ($this->prefix) {
            $prefix = trim($this->prefix, '/');

            $url = str_replace("/$prefix", '', $url);
        }

        return $url;
    }

    public function __construct($prefix = '') {
        $this->prefix = trim($prefix);
    }
}
