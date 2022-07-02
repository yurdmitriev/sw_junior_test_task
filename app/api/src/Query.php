<?php

namespace App;

use App\Util\Error;

class Query {
    private \PDO $pdo;
    private string $sql = '';
    private string $command = '';
    private int $limit = 0;
    private int $offset = 0;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function select(string $table, array $columns = []): self {
        $fields = '*';

        if ($this->command) throw new Error();
        else $this->command = "SELECT";

        if (!empty($columns)) $fields = implode(', ', $columns);

        $this->sql .= "SELECT $fields FROM $table";
        return $this;
    }

    public function insert(string $table, array $fields): self {
        foreach ($fields as $key => $value) {
            if (!is_numeric($value)) $fields[$key] = "'$value'";
        }

        $columns = array_keys($fields);
        $values = array_values($fields);

        if ($this->command) throw new Error();
        else $this->command = "INSERT";

        $colString = implode(', ', $columns);
        $valString = implode(', ', $values);

        $this->sql .= "INSERT INTO $table ($colString) VALUES ($valString)";

        return $this;
    }

    public function limit(int $count = 0, int $offset = 0): self {
        if ($count || $offset) $this->sql .= " LIMIT $offset, $count";
        $this->limit = $count;
        $this->offset = $offset;

        return $this;
    }

    public function raw(): string {
        return $this->sql;
    }

    public function run(int $mode = \PDO::FETCH_ASSOC, string $class = null) {
        $query = $this->pdo->prepare($this->sql);

        if ($this->command == 'SELECT') {
            $query->execute();

            if ($mode == \PDO::FETCH_CLASS) {
                $result = $query->fetchAll($mode, $class);
            } else {
                $result = $query->fetchAll($mode);
            }

            return $this->limit == 1 ? array_pop($result) : $result;
        } else {
            $query->execute();
            return $this->pdo->lastInsertId();
        }

    }
}