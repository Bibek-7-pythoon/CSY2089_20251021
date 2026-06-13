<?php
class FakeDatabaseTable
{
    public array $rows;
    public array $saved = [];
    public array $inserted = [];
    public array $updated = [];
    public array $deleted = [];
    public array $queries = [];

    public function __construct(array $rows = [])
    {
        $this->rows = $rows;
    }

    public function find($field, $value)
    {
        return array_values(array_filter($this->rows, fn($row) => isset($row[$field]) && (string)$row[$field] === (string)$value));
    }

    public function findAll()
    {
        return $this->rows;
    }

    public function query($sql, $criteria = [])
    {
        $this->queries[] = ['sql' => $sql, 'criteria' => $criteria];

        // For controller unit tests, return matching client jobs when clientId is supplied.
        if (isset($criteria['clientId'])) {
            return array_values(array_filter($this->rows, fn($row) => isset($row['clientId']) && (string)$row['clientId'] === (string)$criteria['clientId']));
        }

        // For job applicant permission tests, support lookup by id and clientId.
        if (isset($criteria['id'], $criteria['clientId'])) {
            return array_values(array_filter($this->rows, fn($row) => isset($row['id'], $row['clientId']) && (string)$row['id'] === (string)$criteria['id'] && (string)$row['clientId'] === (string)$criteria['clientId']));
        }

        return $this->rows;
    }

    public function insert($record)
    {
        $this->inserted[] = $record;
        $this->rows[] = $record;
    }

    public function save($record)
    {
        $this->saved[] = $record;
        $this->rows[] = $record;
    }

    public function update($record)
    {
        $this->updated[] = $record;
    }

    public function delete($id)
    {
        $this->deleted[] = $id;
    }
}
