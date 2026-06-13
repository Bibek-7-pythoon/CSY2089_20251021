<?php
require_once __DIR__ . '/../CSY2089/DatabaseTable.php';

use PHPUnit\Framework\TestCase;
use CSY2089\DatabaseTable;

class DatabaseTableTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT)');
    }

    public function testInsertFindAndFindAll(): void
    {
        $table = new DatabaseTable($this->pdo, 'category', 'id');
        $table->insert(['name' => 'Engineering']);

        $result = $table->find('name', 'Engineering');

        $this->assertCount(1, $result);
        $this->assertSame('Engineering', $result[0]['name']);
        $this->assertCount(1, $table->findAll());
    }

    public function testUpdateAndDelete(): void
    {
        $table = new DatabaseTable($this->pdo, 'category', 'id');
        $table->insert(['name' => 'IT']);
        $id = (int)$this->pdo->lastInsertId();

        $table->update(['id' => $id, 'name' => 'Information Technology']);
        $this->assertSame('Information Technology', $table->find('id', $id)[0]['name']);

        $table->delete($id);
        $this->assertCount(0, $table->findAll());
    }
}
