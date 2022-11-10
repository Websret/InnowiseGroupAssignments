<?php

namespace Application\Core;

use Application\Lib\Db;

abstract class Model
{
    public Db $db;

    private array $fields = [];

    private array $conditions = [];

    private string $connections = '';

    private string $sorted = '';

    private array $addFields = [];

    private array $insertableFields = [];

    public function __construct()
    {
        $this->db = new Db;
    }

    public abstract function table(): string;

    public function __toString(): string
    {
        $select = $this->fields == [] ? '' : 'SELECT ' . implode(', ', $this->fields) . ' FROM ' . $this->table();
        $insert = $this->addFields == [] ? '' : 'INSERT INTO ' . $this->table() . ' (' . implode(', ', $this->addFields) . ')';
        $join = $this->connections == '' ? '' : $this->connections;
        $values = $this->insertableFields == [] ? '' : ' VALUES (' . implode(', ', $this->insertableFields) . ')';
        $where = $this->conditions == [] ? '' : ' WHERE ' . implode(' AND ', $this->conditions);
        $orderBy = $this->sorted == '' ? '' : ' ORDER BY ' . $this->sorted;
        return $select . $insert . $join . $values . $where . $orderBy;
    }

    public function select(string ...$select): self
    {
        $this->fields = $select;
        return $this;
    }

    public function insert(string ...$insert): self
    {
        $this->addFields = $insert;
        return $this;
    }

    public function values(string ...$values): self
    {
        $this->insertableFields = $values;
        return $this;
    }

    public function where(string ...$where): self
    {
        foreach ($where as $arg) {
            $this->conditions[] = $arg;
        }
        return $this;
    }

    public function join(string $table, string $first, string $operator, string $second): self
    {
        $this->connections .= " JOIN $table on $first $operator $second";
        return $this;
    }

    public function orderBy(string $column, string $direction): self
    {
        $this->sorted = "$column $direction";
        return $this;
    }

    public function get(?array $params = []): array|bool
    {
        $stmt = $this->db->dbo
            ->prepare($this);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function add(array $params = []): void
    {
        $this->db->dbo
            ->prepare($this)
            ->execute($params);
    }
}
