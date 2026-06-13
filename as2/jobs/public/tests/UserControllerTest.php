<?php
require_once __DIR__ . '/FakeDatabaseTable.php';
require_once __DIR__ . '/../JoJobs/Controllers/UserController.php';

use PHPUnit\Framework\TestCase;
use JoJobs\Controllers\UserController;

class UserControllerTest extends TestCase
{
    protected function setUp(): void
    {
        $_GET = [];
        $_POST = [];
        $_SESSION = [];
    }

    public function testListReturnsUsers(): void
    {
        $table = new FakeDatabaseTable([['id' => 1, 'username' => 'admin', 'role' => 'Admin']]);
        $controller = new UserController($table);

        $page = $controller->list();

        $this->assertSame('users.html.php', $page['template']);
        $this->assertSame('Manage Staff Accounts', $page['title']);
        $this->assertSame('admin', $page['variables']['users'][0]['username']);
    }

    public function testLoginReturnsErrorForInvalidPassword(): void
    {
        $_POST = ['submit' => 'Login', 'username' => 'admin', 'password' => 'wrong'];
        $table = new FakeDatabaseTable([['id' => 1, 'username' => 'admin', 'password' => password_hash('letmein', PASSWORD_DEFAULT), 'role' => 'Admin']]);
        $controller = new UserController($table);

        $page = $controller->login();

        $this->assertSame('Invalid username or password.', $page['variables']['error']);
        $this->assertArrayNotHasKey('loggedin', $_SESSION);
    }

    public function testEditSavesNewStaffAccountWithHashedPassword(): void
    {
        $_POST = ['submit' => 'Save', 'username' => 'staff1', 'password' => 'secret123', 'role' => 'Staff'];
        $table = new FakeDatabaseTable();
        $controller = new UserController($table);

        $page = $controller->edit();

        $this->assertSame('staff1', $table->saved[0]['username']);
        $this->assertTrue(password_verify('secret123', $table->saved[0]['password']));
        $this->assertSame('Staff account saved successfully.', $page['variables']['message']);
    }
}
