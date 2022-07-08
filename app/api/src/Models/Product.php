<?php

namespace App\Models;

use App\App;
use App\Util\Error;

/**
 * Basic class for all products
 */
abstract class Product extends Model {
    /**
     * @var string Table name
     */
    protected static string $table = "Products";

    /**
     * @var string Name of table that contains values of attributes of products
     */
    protected static string $valuesTable = "ProductAttributes";

    /**
     * @var string
     */
    public string $sku;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var float
     */
    public float $price;

    /**
     * @var Type Stores information about type: title, id in the database, attributes
     */
    private Type $type;

    /**
     * @param string $sku
     * @param string $name
     * @param float $price
     * @param array $params
     */
    public function __construct(string $sku, string $name, float $price, array $params) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;

        foreach ($params as $param => $value) {
            if (property_exists($this, $param)) $this->$param = $value;
        }

        $this->type = Type::search(['title' => basename(str_replace('\\', '/', get_called_class()))]);
    }

    /**
     * Represents product as array
     * @return array
     */
    public function getProperties(): array {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'price' => "{$this->price} $",
            'attribute' => $this->getAttribute()
        ];
    }

    /**
     * Represents attributes as single string
     * @return string
     */
    public abstract function getAttribute(): string;

    /**
     * Save logic for products
     * @return $this saved object
     * @throws Error
     */
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

            // if query is failed
            if ($itemResult === false) throw new Error();

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
        } else {
            // TODO: Implement update logic for products
        }

        return $this;
    }

    /**
     * Deleting logic of products
     * @param array $conditions array with columns as keys and values that need to be removed
     * @return array|bool|mixed|void|null
     * @throws Error
     */
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

    /**
     * Get list of products
     * @return array list of products
     * @throws Error
     */
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

    /**
     * Get all available types of products
     * @return array|bool|mixed|void|null
     */
    public static function types() {
        return Type::list();
    }
}