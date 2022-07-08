<?php

namespace App;

use App\Util\Error;

/**
 * Class that handle routing of application
 */
class Router {
    /**
     * @var string
     */
    private string $prefix;
    /**
     * @var array
     */
    private array $routes = [];

    /**
     * Register a new route
     * @param string $method Request method
     * @param string $uri Regex of request uri
     * @param mixed $action array like [Controller::class, 'method'] or callback function
     * @return void
     */
    private function register(string $method, string $uri, $action): void {
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

    /**
     * Run route that matches requested url
     * @param string $url request url
     * @return mixed
     * @throws Error
     */
    public function run(string $url) {
        $uri = $this->prepareUri($url);

        foreach ($this->routes as $route) {
            if ($route->getUri() == $uri && $route->getMethod() == $_SERVER['REQUEST_METHOD']) {
                return $route->run();
            }
        }

        throw new Error("This method doesn't exist", 404);
    }

    /**
     * Remove prefix from requested url ot find correct route
     * @param string $url
     * @return string prepared url
     */
    private function prepareUri(string $url): string {
        if ($this->prefix) {
            $prefix = trim($this->prefix, '/');

            $url = str_replace("/$prefix", '', $url);
        }

        return $url;
    }

    /**
     * @param string $prefix prefix of url
     */
    public function __construct(string $prefix = '') {
        $this->prefix = trim($prefix);
    }
}
