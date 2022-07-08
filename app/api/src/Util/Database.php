<?php

namespace App\Util;

use App\Query;

/**
 * Database connection helper
 */
class Database {
    /**
     * @var \PDO PDO instance
     */
    private \PDO $pdo;

    /**
     * Returns a new instance of Query
     * @return Query
     */
    public function query(): Query {
        return new Query($this->pdo);
    }

    /**
     * Connecting to database
     * @param string $host
     * @param string $port
     * @param string $user
     * @param string $pass
     * @param string $db
     * @param string $driver
     */
    public function __construct(string $host, string $port, string $user, string $pass, string $db, string $driver = 'mysql') {
        $this->pdo = new \PDO("$driver:host=$host:$port;dbname=$db", $user, $pass);
    }
}
