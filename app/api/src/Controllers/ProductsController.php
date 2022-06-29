<?php

namespace App\Controllers;

use App\Models\Product;
use App\Util\Request;

class ProductsController {
    public function list() {
        return Product::list();
    }

    public function add(Request $request) {
        $product = new Product(
            $request->post['sku'],
            $request->post['name'],
            $request->post['price']
        );

        return $product->save();
    }
}