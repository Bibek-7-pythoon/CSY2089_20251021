<?php
require_once __DIR__ . '/FakeDatabaseTable.php';
require_once __DIR__ . '/../JoJobs/Controllers/ClientController.php';

use PHPUnit\Framework\TestCase;
use JoJobs\Controllers\ClientController;

class ClientControllerTest extends TestCase
{
    protected function setUp(): void
    {
        $_GET = [];
        $_POST = [];
        $_SESSION = [];
    }

    private function controller(FakeDatabaseTable $clients, ?FakeDatabaseTable $jobs = null, ?FakeDatabaseTable $categories = null, ?FakeDatabaseTable $applicants = null): ClientController
    {
        return new ClientController(
            $clients,
            $jobs ?? new FakeDatabaseTable(),
            $categories ?? new FakeDatabaseTable([['id' => 1, 'name' => 'IT']]),
            $applicants ?? new FakeDatabaseTable()
        );
    }

    public function testListReturnsClientAccounts(): void
    {
        $controller = $this->controller(new FakeDatabaseTable([['id' => 1, 'companyName' => 'ABC Ltd', 'username' => 'abc']]));
        $page = $controller->list();

        $this->assertSame('clients.html.php', $page['template']);
        $this->assertSame('Manage Clients', $page['title']);
        $this->assertSame('ABC Ltd', $page['variables']['clients'][0]['companyName']);
    }

    public function testEditRequiresPasswordForNewClient(): void
    {
        $_POST = ['submit' => 'Save', 'companyName' => 'ABC Ltd', 'username' => 'abc', 'password' => ''];
        $clients = new FakeDatabaseTable();
        $controller = $this->controller($clients);

        $page = $controller->edit();

        $this->assertSame('Password is required for new clients.', $page['variables']['message']);
        $this->assertCount(0, $clients->saved);
    }

    public function testEditSavesNewClientWithHashedPassword(): void
    {
        $_POST = ['submit' => 'Save', 'companyName' => 'ABC Ltd', 'username' => 'abc', 'password' => 'clientpass'];
        $clients = new FakeDatabaseTable();
        $controller = $this->controller($clients);

        $page = $controller->edit();

        $this->assertSame('ABC Ltd', $clients->saved[0]['companyName']);
        $this->assertTrue(password_verify('clientpass', $clients->saved[0]['password']));
        $this->assertSame('Client account saved successfully.', $page['variables']['message']);
    }

    public function testClientLoginReturnsErrorForWrongPassword(): void
    {
        $_POST = ['submit' => 'Login', 'username' => 'client1', 'password' => 'wrong'];
        $clients = new FakeDatabaseTable([['id' => 7, 'companyName' => 'Client Co', 'username' => 'client1', 'password' => password_hash('letmein', PASSWORD_DEFAULT)]]);
        $controller = $this->controller($clients);

        $page = $controller->clientLogin();

        $this->assertSame('Invalid client username or password.', $page['variables']['error']);
        $this->assertArrayNotHasKey('clientLoggedIn', $_SESSION);
    }

    public function testClientJobsOnlyQueriesLoggedInClientJobs(): void
    {
        $_SESSION['clientId'] = 7;
        $jobs = new FakeDatabaseTable([['id' => 1, 'title' => 'Own Job', 'clientId' => 7], ['id' => 2, 'title' => 'Other Job', 'clientId' => 8]]);
        $controller = $this->controller(new FakeDatabaseTable(), $jobs);

        $page = $controller->clientJobs();

        $this->assertSame('clientjobs.html.php', $page['template']);
        $this->assertSame(['clientId' => 7], $jobs->queries[0]['criteria']);
        $this->assertCount(1, $page['variables']['jobs']);
    }

    public function testClientApplicantsOnlyShowsApplicantsForOwnJob(): void
    {
        $_SESSION['clientId'] = 7;
        $_GET['id'] = 1;
        $jobs = new FakeDatabaseTable([['id' => 1, 'title' => 'Own Job', 'clientId' => 7]]);
        $applicants = new FakeDatabaseTable([['id' => 10, 'jobId' => 1, 'name' => 'Applicant']]);
        $controller = $this->controller(new FakeDatabaseTable(), $jobs, null, $applicants);

        $page = $controller->clientApplicants();

        $this->assertSame('clientapplicants.html.php', $page['template']);
        $this->assertSame('Own Job', $page['variables']['job']['title']);
        $this->assertCount(1, $page['variables']['applicants']);
    }
}
