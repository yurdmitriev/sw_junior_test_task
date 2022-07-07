<?php

namespace App;

use App\Util\Error;

class Query {
    private \PDO $pdo;
    private string $sql = '';
    private string $command = '';
    private int $limit = 0;
    private int $offset = 0;
    private array $fields = [];
    private array $where = [];
    private \PDOStatement $statement;
    private array $params = [];
    private string $orderColumn;
    private string $orderDir = 'ASC';

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function select(array $fields = []): self {
        if ($this->command) throw new Error();
        else $this->command = "SELECT";

        if (!empty($fields)) {
            foreach ($fields as $table => $columns) {
                $temp = [];

                if (empty($columns)) $temp = '*';
                else foreach ($columns as $column => $alias) {
                    if (is_numeric($column)) $temp[] = $alias;
                    else $temp[] = "$column as $alias";
                }

                $this->fields[$table] = $temp;
            }
        } else throw new Error();

        return $this;
    }

    public function insert(string $table, array $fields): self {
        if ($this->command) throw new Error();
        else $this->command = "INSERT";

        $temp = [];

        foreach ($fields as $column => $value) {
            $temp[$column] = ":$table$column";
            $this->params[":$table$column"] = $value;
        }

        $this->fields[$table] = $temp;

        return $this;
    }

    public function where(string $table, string $column, $value, string $logical = "AND", string $operator = '='): self {
        $temp = [];

        if (is_array($value)) {
            $temp['value'] = "$table.$column = {$value['bind']}.{$value['on']}";
        } else {
            $num = count($this->where);
            $temp['value'] = "$table.$column $operator :$table$column$num";
            $this->params[":$table$column$num"] = $value;
        }

        if (!isset($this->fields[$table])) $this->fields[$table] = null;

        $temp['connects'] = empty($this->where) ? '' : $logical;
        $this->where[] = $temp;

        return $this;
    }

    public function order($alias, string $dir = 'ASC'): self {
        if (is_array($alias)) $this->orderColumn = implode(', ', $alias);
        else $this->orderColumn = $alias;

        return $this;
    }

    public function one(int $offset = 0) {
        $this->limit = 1;
        $this->offset = $offset;

        $this->prepare();

        return $this->run();
    }

    public function many(int $limit = 0, int $offset = 0) {
        $this->limit = $limit;
        $this->offset = $offset;

        $this->prepare();

        return $this->run();
    }

    public function raw(): string {
        $this->prepare();

        return $this->statement->queryString;
    }

    private function prepare(): void {
        switch ($this->command) {
            case "SELECT":
                $fields = [];
                $tables = [];

                foreach ($this->fields as $table => $columns) {
                    $tables[] = $table;

                    if (is_array($columns))
                        foreach ($columns as $column) {
                            $fields[] = "$table.$column";
                        }
                    elseif ($columns !== null) $fields[] = "$table.$columns";
                }

                $fields = implode(', ', $fields);
                $tables = implode(', ', $tables);
                $this->sql = "SELECT $fields FROM $tables";

                break;

            case "INSERT":
                $target = '';
                $columns = [];
                $values = [];

                foreach ($this->fields as $table => $col) {
                    $target = $table;

                    foreach ($col as $key => $value) {
                        $columns[] = $key;
                        $values[] = $value;
                    }

                    break;
                }

                $values = implode(', ', $values);
                $columns = implode(', ', $columns);

                $this->sql = "INSERT INTO $target ($columns) VALUES ($values)";

                break;

            case "UPDATE":
                // TODO: Implement an UPDATE method
                break;

            case "DELETE":
                // TODO: Implement a DELETE method
                break;
        }

        if (!empty($this->where)) {
            $this->sql .= " WHERE";

            foreach ($this->where as $condition) {
                $this->sql .= " {$condition['connects']} {$condition['value']}";
            }
        }

        if (!empty($this->orderColumn)) {
            $this->sql .= " ORDER BY {$this->orderColumn} {$this->orderDir}";
        }

        if ($this->limit > 0) {
            if ($this->offset > 0) $this->sql .= " LIMIT {$this->offset}, {$this->limit}";
            else $this->sql .= " LIMIT {$this->limit}";
        } else {
            if ($this->offset > 0) $this->sql .= " OFFSET {$this->offset}";
        }

        $this->statement = $this->pdo->prepare($this->sql);
    }

    public function run(bool $dump = false) {
        $this->prepare();

        $executed = $this->statement->execute($this->params);
        if ($dump) {
            echo "<pre>";
            $this->statement->debugDumpParams();
            echo "</pre>";
            exit();
        }

        if ($this->command == 'SELECT') {
            $result = $this->statement->fetchAll(\PDO::FETCH_ASSOC);
            return $this->limit == 1 ? array_pop($result) : $result;
        } else {
            return $executed;
        }
    }
}