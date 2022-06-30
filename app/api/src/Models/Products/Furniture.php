<?php

namespace App\Models\Products;

use App\Models\Product;

class Furniture extends Product {
    protected int $width;
    protected int $height;
    protected int $length;

    public function getAttribute(): string {
        return "Dimension: {$this->width}x{$this->height}x{$this->length}";
    }
}