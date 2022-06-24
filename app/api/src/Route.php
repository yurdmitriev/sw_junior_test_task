<?php

namespace App;

class Route {
    private string $method;
    private string $uri;
    private $action;
    private ?array $params;

    public function getMethod(): string {
        return $this->method;
    }

    public function getUri(): string {
        return $this->uri;
    }

    public function run () {
        return call_user_func($this->action);
    }

    public function __construct(string $method, string $uri, $action, ?array $params = null) {
        $this->method = $method;
        $this->uri = $uri;
        $this->action = $action;
        $this->params = $params;
    }
}