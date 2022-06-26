<?php

namespace App\Util;

class Error extends \Exception {
    public function __construct($message = "Internal error", $code = 500) {
        parent::__construct($message, $code);
    }
}