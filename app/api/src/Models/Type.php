<?php

namespace App\Models;

use App\App;

class Type extends Model {
    protected static string $table = "Types";

    public int $id;
    public string $title;

    public static function search(array $filters): self {
        $raw = App::db()->select(self::$table)->where($filters)->limit(1)->run();
        return new self($raw['id'], $raw['title']);
    }

    public static function list() {
        return App::db()->select(self::$table, ['id', 'title'])->run();
    }

    public function __construct(int $id, string $title) {
        $this->id = $id;
        $this->title = $title;
    }
}