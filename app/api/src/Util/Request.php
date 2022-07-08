<?php

namespace App\Util;

/**
 * Contains GET and POST parameters
 */
class Request {
    public array $get;
    public array $post;

    public function __construct(array $get, array $post) {
        $this->get = $get;
        $this->post = $post;
    }
}