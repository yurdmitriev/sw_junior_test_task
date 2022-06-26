<?php

namespace App\Controllers;

use App\Util\Error;

class ProductsController {
    public function list(): array {
        return ['Hello world from ' . __CLASS__];
    }

    public function add() {
        return "There must be a new product";
    }
}