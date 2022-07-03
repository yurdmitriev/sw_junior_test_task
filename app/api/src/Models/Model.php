<?php

namespace App\Models;

use App\App;

abstract class Model {
    protected static string $table;

    public static function list() {
        return App::db()->select([static::$table => []])->run();
    }

    public function save() {
        return App::db()->insert(static::$table, (array)$this)->run();
    }

    public static function search(array $filters) {
        $raw = App::db()->select([static::$table => []]);

        foreach ($filters as $column => $value) {
            if (is_array($value)) {
                $raw = $raw->where(
                    $column,
                    $value['value'],
                    $value['connects'] ?? 'AND',
                    $value['operator'] ?? '='
                );
            } else $raw = $raw->where(static::$table, $column, $value);
        }

        return $raw->run();
    }
}