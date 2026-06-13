<?php
require_once __DIR__ . '/FakeDatabaseTable.php';
require_once __DIR__ . '/../JoJobs/Controllers/JobController.php';

use PHPUnit\Framework\TestCase;
use JoJobs\Controllers\JobController;

class JobControllerTest extends TestCase
{
    protected function setUp(): void
    {
        $_GET = [];
        $_POST = [];
    }

    private function controller(FakeDatabaseTable $jobs, ?FakeDatabaseTable $categories = null, ?FakeDatabaseTable $applicants = null): JobController
    {
        return new JobController(
            $jobs,
            $categories ?? new FakeDatabaseTable([['id' => 1, 'name' => 'IT']]),
            $applicants ?? new FakeDatabaseTable([['id' => 1, 'jobId' => 1]])
        );
    }

    public function testHomeReturnsAdminHomePage(): void
    {
        $page = $this->controller(new FakeDatabaseTable())->home();
        $this->assertSame('adminhome.html.php', $page['template']);
        $this->assertSame('Admin Home', $page['title']);
    }

    public function testListBuildsActiveJobsQueryWithCategoryAndApplicantCounts(): void
    {
        $_GET = ['categoryId' => 1, 'status' => 'active'];
        $jobs = new FakeDatabaseTable([['id' => 1, 'title' => 'Developer', 'categoryId' => 1]]);
        $controller = $this->controller($jobs);

        $page = $controller->list();

        $this->assertSame('jobs.html.php', $page['template']);
        $this->assertStringContainsString('job.categoryId = :categoryId', $jobs->queries[0]['sql']);
        $this->assertStringContainsString('job.archived = 0', $jobs->queries[0]['sql']);
        $this->assertSame(1, $page['variables']['jobs'][0]['applicant_count']);
    }

    public function testEditSavesJobFromPost(): void
    {
        $_POST = [
            'submit' => 'Save',
            'title' => 'Designer',
            'description' => 'Design work',
            'salary' => '20000',
            'location' => 'Northampton',
            'categoryId' => 1,
            'closingDate' => '2026-12-31'
        ];
        $jobs = new FakeDatabaseTable();
        $controller = $this->controller($jobs);

        $page = $controller->edit();

        $this->assertSame('Designer', $jobs->saved[0]['title']);
        $this->assertSame(0, $jobs->saved[0]['archived']);
        $this->assertSame('Job saved successfully.', $page['variables']['message']);
    }

    public function testApplicantsReturnsJobAndApplicants(): void
    {
        $_GET = ['id' => 1];
        $jobs = new FakeDatabaseTable([['id' => 1, 'title' => 'Developer']]);
        $applicants = new FakeDatabaseTable([['id' => 10, 'jobId' => 1, 'name' => 'Applicant']]);
        $controller = $this->controller($jobs, null, $applicants);

        $page = $controller->applicants();

        $this->assertSame('applicants.html.php', $page['template']);
        $this->assertSame('Developer', $page['variables']['job']['title']);
        $this->assertCount(1, $page['variables']['applicants']);
    }
}
