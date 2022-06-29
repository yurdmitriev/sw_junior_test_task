<?php

namespace App\Models;

class Product extends Model {
    protected static string $table = "Products";

    public string $sku;
    public string $name;
    public float $price;

    public function __construct(
        string $sku,
        string $name,
        float $price
    ) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }
}