<?php

namespace App\Models;

use App\App;
use App\Query;
use App\Util\Error;

abstract class Product extends Model {
    protected static string $table = "Products";
    protected static string $valuesTable = "ProductAttributes";

    public string $sku;
    public string $name;
    public float $price;
    private Type $type;

    public function __construct(string $sku, string $name, float $price, array $params) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;

        foreach ($params as $param => $value) {
            if (property_exists($this, $param)) $this->$param = $value;
        }

        $this->type = Type::search(['title' => basename(str_replace('\\', '/', get_called_class()))]);
    }

    public function getProperties(): array {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'price' => "{$this->price} $",
            'attribute' => $this->getAttribute()
        ];
    }

    public abstract function getAttribute(): string;

    public function save(): Product {
        // checking if product exists
        $item = App::db()
            ->select([static::$table => []])
            ->where(static::$table, 'sku', $this->sku)
            ->one();

        if (empty($item)) {
            $itemResult = App::db()
                ->insert(static::$table, [
                    'sku' => $this->sku,
                    'name' => $this->name,
                    'price' => $this->price,
                    'type' => $this->type->id
                ])
                ->run();

            foreach ($this->type->attributes as $attribute) {
                $title = $attribute['title'];
                App::db()
                    ->insert(static::$valuesTable, [
                        'product' => $this->sku,
                        'attribute' => $attribute['id'],
                        'value' => $this->$title
                    ])
                    ->run();
            }

            if ($itemResult === false) throw new Error();
        } else {
            // update
        }

        return $this;
    }

    public static function delete(array $conditions) {
        $query = App::db()->delete(static::$table);

        foreach ($conditions as $column => $value) {
            if (is_array($value)) {
                foreach ($value as $val)
                    $query = $query->where(static::$table, $column, $val, 'OR');
            } else {
                $query = $query->where(static::$table, $column, $value, 'OR');
            }
        }

        return $query->run();
    }

    public static function list(): array {
        $list = App::db()->select([static::$table => []])->order('sku')->many();
        $result = [];

        foreach ($list as $item) {
            $fields = ['sku', 'name', 'price'];

            $type = Type::search(['id' => $item['type']]);
            unset($item['type']);

            foreach ($fields as $field) {
                $$field = $item[$field];
                unset($item[$field]);
            }

            $values = [];

            foreach ($type->attributes as $attr) {
                $val = App::db()
                    ->select([static::$valuesTable => []])
                    ->where(static::$valuesTable, 'product', $sku)
                    ->where(static::$valuesTable, 'attribute', $attr['id'])
                    ->one();

                if (isset($val['value'])) {
                    $values[$attr['title']] = $val['value'];
                }
            }

            $class = "\\App\\Models\\Products\\" . $type->title;
            $product = new $class($sku, $name, $price, $values);
            $result[] = $product->getProperties();
        }

        return $result;
    }

    public static function types() {
        return Type::list();
    }
}