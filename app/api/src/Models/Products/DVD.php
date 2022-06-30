<?php

namespace App\Models\Products;

use App\Models\Product;

class DVD extends Product {
    protected int $size;

    public function getAttribute(): string {
        return "Size: {$this->size} MB";
    }
}