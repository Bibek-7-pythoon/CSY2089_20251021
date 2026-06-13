<?php
require_once __DIR__ . '/FakeDatabaseTable.php';
require_once __DIR__ . '/../JoJobs/Controllers/PublicController.php';

use PHPUnit\Framework\TestCase;
use JoJobs\Controllers\PublicController;

class PublicControllerTest extends TestCase
{
    protected function setUp(): void
    {
        $_GET = [];
        $_POST = [];
        $_FILES = [];
    }

    private function controller(FakeDatabaseTable $jobs, ?FakeDatabaseTable $categories = null, ?FakeDatabaseTable $applicants = null, ?FakeDatabaseTable $enquiries = null): PublicController
    {
        return new PublicController(
            $jobs,
            $categories ?? new FakeDatabaseTable([['id' => 1, 'name' => 'IT']]),
            $applicants ?? new FakeDatabaseTable(),
            $enquiries ?? new FakeDatabaseTable()
        );
    }

    public function testHomeShowsFiveClosingSoonJobsQuery(): void
    {
        $jobs = new FakeDatabaseTable([['id' => 1, 'title' => 'Developer']]);
        $page = $this->controller($jobs)->home();

        $this->assertSame('home.html.php', $page['template']);
        $this->assertStringContainsString('ORDER BY closingDate ASC LIMIT 5', $jobs->queries[0]['sql']);
    }

    public function testJobsPageFiltersByCategoryTitleAndLocation(): void
    {
        $_GET = ['categoryId' => 1, 'title' => 'Support', 'location' => 'Northampton'];
        $jobs = new FakeDatabaseTable();
        $page = $this->controller($jobs)->jobs();

        $this->assertSame('jobs.html.php', $page['template']);
        $this->assertStringContainsString('job.categoryId = :categoryId', $jobs->queries[0]['sql']);
        $this->assertStringContainsString('job.title LIKE :title', $jobs->queries[0]['sql']);
        $this->assertStringContainsString('job.location LIKE :location', $jobs->queries[0]['sql']);
    }

    public function testContactStoresEnquiryAsPending(): void
    {
        $_POST = [
            'submit' => 'Send',
            'firstName' => 'Sita',
            'surname' => 'Rai',
            'email' => 'sita@example.com',
            'telephone' => '9800000000',
            'enquiry' => 'I want more information.'
        ];
        $enquiries = new FakeDatabaseTable();
        $page = $this->controller(new FakeDatabaseTable(), null, null, $enquiries)->contact();

        $this->assertSame('contact.html.php', $page['template']);
        $this->assertSame('Pending', $enquiries->inserted[0]['status']);
    }

    public function testApplyStoresApplicant(): void
    {
        $_POST = [
            'submit' => 'Apply',
            'name' => 'Applicant',
            'email' => 'applicant@example.com',
            'details' => 'Cover letter',
            'jobId' => 3
        ];
        $applicants = new FakeDatabaseTable();
        $page = $this->controller(new FakeDatabaseTable(), null, $applicants)->apply();

        $this->assertSame('apply.html.php', $page['template']);
        $this->assertSame('Applicant', $applicants->inserted[0]['name']);
        $this->assertSame('Your application is complete. We will contact you after the closing date.', $page['variables']['message']);
    }
}
