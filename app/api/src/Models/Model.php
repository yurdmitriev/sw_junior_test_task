<?php

namespace App\Models;

use App\App;

abstract class Model {
    protected static string $table;

    public static function list() {
        return App::db()->select(static::$table)->run();
    }

    public function save() {
        return App::db()->insert(static::$table, (array)$this)->run();
    }
}