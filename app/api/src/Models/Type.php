<?php

namespace App\Models;

use App\App;

/**
 * Information about the type of product
 */
class Type extends Model {
    protected static string $table = "Types";
    private static string $attributesTable = "Attributes";

    public int $id;
    public string $title;

    /**
     * @var array List of attributes used by current type
     */
    public array $attributes;

    /**
     * Get type from database by filters
     * @param array $filters
     * @return static
     * @throws \App\Util\Error
     */
    public static function search(array $filters = []): self {
        $raw = App::db()->select([self::$table => []]);

        foreach ($filters as $column => $value) {
            if (is_array($value)) {
                $raw = $raw->where(
                    $column,
                    $value['value'],
                    $value['connects'] ?? 'AND',
                    $value['operator'] ?? '='
                );
            } else $raw = $raw->where(self::$table, $column, $value);
        }

        $raw = $raw->one();
        return new self($raw['id'], $raw['title']);
    }

    /**
     * List types
     * @return array|bool|mixed|void|null
     * @throws \App\Util\Error
     */
    public static function list() {
        return App::db()->select([self::$table => ['id', 'title']])->many();
    }

    /**
     * List attributes
     * @param int $id id of type
     * @return array
     * @throws \App\Util\Error
     */
    private static function attributes(int $id): array {
        return App::db()
            ->select([self::$attributesTable => []])
            ->where(self::$attributesTable, 'id', ['bind' => 'TypeAttributes', 'on' => 'attribute'])
            ->where('TypeAttributes', 'type', $id)
            ->many();
    }

    /**
     * @param int $id
     * @param string $title
     * @throws \App\Util\Error
     */
    public function __construct(int $id, string $title) {
        $this->id = $id;
        $this->title = $title;
        $this->attributes = self::attributes($id);
    }
}