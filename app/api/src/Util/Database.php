<?php

namespace App\Util;

use App\Query;

class Database {
    private \PDO $pdo;

    public function query(): Query {
        return new Query($this->pdo);
    }

    public function __construct(string $host, string $port, string $user, string $pass, string $db, string $driver = 'mysql') {
        $this->pdo = new \PDO("$driver:host=$host:$port;dbname=$db", $user, $pass);
    }
}
