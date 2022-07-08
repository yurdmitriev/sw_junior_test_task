<?php

namespace App\Controllers;

use App\Models\Product;
use App\Util\Error;
use App\Util\Request;

class ProductsController {
    public function list() {
        return Product::list();
    }

    public function add(Request $request) {
        $params = $request->post;
        $class = "\\App\\Models\\Products\\" . $params['type'];
        unset($params['type']);

        foreach (['sku', 'name', 'price'] as $field) {
            $$field = $params[$field];
            unset($params[$field]);
        }

        $existing = Product::search(['sku' => $sku]);

        if ($existing) throw new Error('Product already exists', 400);

        try {
            $product = new $class ($sku, $name, $price, $params);
            return $product->save()->getProperties();
        } catch (\Error $e) {
            throw new Error("Unknown product type", 404);
        } catch (\Throwable $e) {
            throw new Error();
        }
    }

    public function remove(Request $request) {
        $params = $request->get;
        if (empty($params['items'])) throw new Error("Empty request", 400);

        return Product::delete(['sku' => $params['items']]);
    }

    public function listTypes() {
        return Product::types();
    }
}
