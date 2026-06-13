<?php
require_once __DIR__ . '/FakeDatabaseTable.php';
require_once __DIR__ . '/../JoJobs/Controllers/CategoryController.php';

use PHPUnit\Framework\TestCase;
use JoJobs\Controllers\CategoryController;

class CategoryControllerTest extends TestCase
{
    protected function setUp(): void
    {
        $_GET = [];
        $_POST = [];
    }

    public function testListReturnsCategoriesTemplateAndData(): void
    {
        $table = new FakeDatabaseTable([['id' => 1, 'name' => 'IT']]);
        $controller = new CategoryController($table);

        $page = $controller->list();

        $this->assertSame('categories.html.php', $page['template']);
        $this->assertSame('Manage Categories', $page['title']);
        $this->assertCount(1, $page['variables']['categories']);
    }

    public function testEditSavesNewCategory(): void
    {
        $_POST = ['submit' => 'Save', 'name' => 'Engineering'];
        $table = new FakeDatabaseTable();
        $controller = new CategoryController($table);

        $page = $controller->edit();

        $this->assertSame(['name' => 'Engineering'], $table->saved[0]);
        $this->assertSame('Category saved successfully.', $page['variables']['message']);
    }

    public function testEditLoadsExistingCategory(): void
    {
        $_GET = ['id' => 2];
        $table = new FakeDatabaseTable([['id' => 2, 'name' => 'Sales']]);
        $controller = new CategoryController($table);

        $page = $controller->edit();

        $this->assertSame('Edit Category', $page['title']);
        $this->assertSame('Sales', $page['variables']['currentCategory']['name']);
    }
}
