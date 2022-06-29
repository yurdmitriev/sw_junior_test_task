<?php

namespace App;

use App\Util\Error;

class Route {
    private string $method;
    private string $uri;
    private $action;
    private array $params;

    public function getMethod(): string {
        return $this->method;
    }

    public function getUri(): string {
        return $this->uri;
    }

    public function run() {
        $response = [];

        if (is_array($this->action)) {
            try {
                $object = null;
                $method = new \ReflectionMethod($this->action[0], $this->action[1]);

                if (!$method->isStatic()) $object = new $this->action[0];
                $response = $method->invokeArgs($object, $this->params);
            } catch (\ReflectionException $e) {
                throw new Error();
            }

        } else $response = call_user_func($this->action, $this->params);

        return $response;
    }

    public function __construct(string $method, string $uri, $action, array $params = []) {
        $this->method = $method;
        $this->uri = $uri;
        $this->action = $action;
        $this->params = ['request' => \App\App::request()];
    }
}