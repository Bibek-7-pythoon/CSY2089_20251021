<?php

namespace CSY2089;

use PDO;
use Exception;

class DatabaseTable {
    private $pdo;
    private $table;
    private $primaryKey;
    private $className;

    public function __construct(PDO $pdo, string $table, string $primaryKey, ?string $className = null) {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
        $this->className = $className;
    }

    private function buildEntities(array $rows): array {
        if ($this->className === null) {
            return $rows;
        }

        return array_map(fn($row) => new $this->className($row), $rows);
    }

    public function find($field, $value) {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field . ' = :value');
        $criteria = ['value' => $value];
        $stmt->execute($criteria);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $this->buildEntities($stmt->fetchAll());
    }

    public function findAll() {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $this->buildEntities($stmt->fetchAll());
    }

    public function query($sql, $criteria = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($criteria);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    public function insert($record) {
        $keys = array_keys($record);
        $values = implode(', ', $keys);
        $valuesWithColon = implode(', :', $keys);

        $query = 'INSERT INTO ' . $this->table . ' (' . $values . ') VALUES (:' . $valuesWithColon . ')';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($record);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare('DELETE FROM ' . $this->table . ' WHERE ' . $this->primaryKey . ' = :id');
        $criteria = ['id' => $id];
        $stmt->execute($criteria);
    }

    public function save($record) {
        try {
            $this->insert($record);
        }
        catch (Exception $e) {
            $this->update($record);
        }
    }

    public function update($record) {
        $query = 'UPDATE ' . $this->table . ' SET ';
        $parameters = [];
        foreach ($record as $key => $value) {
            $parameters[] = $key . ' = :' . $key;
        }

        $query .= implode(', ', $parameters);
        $query .= ' WHERE ' . $this->primaryKey . ' = :primaryKey';
        $record['primaryKey'] = $record[$this->primaryKey];

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($record);
    }
}