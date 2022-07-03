<?php

namespace App\Models;

use App\App;

class Type extends Model {
    protected static string $table = "Types";

    public int $id;
    public string $title;

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

    public static function list() {
        return App::db()->select([self::$table => ['id', 'title']])->many();
    }

    public function __construct(int $id, string $title) {
        $this->id = $id;
        $this->title = $title;
    }
}