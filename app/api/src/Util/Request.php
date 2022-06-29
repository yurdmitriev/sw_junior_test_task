<?php

namespace App\Util;

class Request {
    public array $get;
    public array $post;

    public function __construct(array $get, array $post) {
        $this->get = $get;
        $this->post = $post;
    }
}