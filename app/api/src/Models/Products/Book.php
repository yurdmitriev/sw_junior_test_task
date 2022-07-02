<?php

namespace App\Models\Products;

use App\Models\Product;

class Book extends Product {
    protected float $weight = 0;

    public function getAttribute(): string {
        return "Weight: {$this->weight} KG";
    }
}