<?php

namespace App;

use App\Util\Error;

/**
 * Class that represents every route
 */
class Route {
    /**
     * @var string A route method
     */
    private string $method;

    /**
     * @var string URI of route
     */
    private string $uri;

    /**
     * @var mixed Action of route
     */
    private $action;

    /**
     * @var array Arguments passed to the action
     */
    private array $params;

    /**
     * @return string Getter for a method
     */
    public function getMethod(): string {
        return $this->method;
    }

    /**
     * @return string Getter for an URI
     */
    public function getUri(): string {
        return $this->uri;
    }

    /**
     * Execute route's action
     * @return mixed Result of action
     * @throws Error
     */
    public function run() {
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

    /**
     * @param string $method
     * @param string $uri
     * @param $action
     * @param array $params
     */
    public function __construct(string $method, string $uri, $action, array $params = []) {
        $this->method = $method;
        $this->uri = $uri;
        $this->action = $action;
        $this->params = ['request' => \App\App::request()];
    }
}