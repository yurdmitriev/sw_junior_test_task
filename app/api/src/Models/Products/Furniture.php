<?php

namespace App\Models\Products;

use App\Models\Product;

class Furniture extends Product {
    protected int $width = 0;
    protected int $height = 0;
    protected int $length = 0;

    public function getAttribute(): string {
        return "Dimension: {$this->width}x{$this->height}x{$this->length}";
    }
}