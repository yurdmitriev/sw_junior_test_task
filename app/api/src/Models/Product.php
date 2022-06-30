<?php

namespace App\Models;

use App\App;

abstract class Product extends Model {
    protected static string $table = "Products";

    public string $sku;
    public string $name;
    public float $price;

    public function __construct(string $sku, string $name, float $price, array $params) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;

        foreach ($params as $param => $value) {
            if (property_exists($this, $param)) $this->$param = $value;
        }
    }

    public function __serialize(): array {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'price' => "{$this->price} $",
            'attribute' => $this->getAttribute()
        ];
    }

    public abstract function getAttribute(): string;

    public function save() {
        return parent::save(); // TODO: Change the autogenerated stub
    }

    public static function list() {
        return parent::list(); // TODO: Change the autogenerated stub
    }

    public static function types() {
        return App::db()->select('Types', ['id', 'title'])->run();
    }
}