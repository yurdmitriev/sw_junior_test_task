<?php

namespace App\Models;

use App\App;

/**
 * Basic class for every model
 */
abstract class Model {
    protected static string $table;

    /**
     * List of models
     * @return array|bool|mixed|void|null
     * @throws \App\Util\Error
     */
    public static function list() {
        return App::db()->select([static::$table => []])->run();
    }

    /**
     * Save logic for models
     * @return array|bool|mixed|void|null
     * @throws \App\Util\Error
     */
    public function save() {
        return App::db()->insert(static::$table, (array)$this)->run();
    }

    /**
     * Searching a model by filters
     * @param array $filters
     * @return array|bool|mixed|void|null
     * @throws \App\Util\Error
     */
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