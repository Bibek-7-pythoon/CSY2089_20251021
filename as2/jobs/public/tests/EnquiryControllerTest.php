<?php
require_once __DIR__ . '/FakeDatabaseTable.php';
require_once __DIR__ . '/../JoJobs/Controllers/EnquiryController.php';

use PHPUnit\Framework\TestCase;
use JoJobs\Controllers\EnquiryController;

class EnquiryControllerTest extends TestCase
{
    protected function setUp(): void
    {
        $_GET = [];
        $_POST = [];
        $_SESSION = [];
    }

    public function testSubmitPublicStoresEnquiryAsPending(): void
    {
        $_POST = [
            'submit' => 'Send',
            'firstName' => 'Ram',
            'surname' => 'Lama',
            'email' => 'ram@example.com',
            'telephone' => '9800000000',
            'enquiry' => 'I want to ask about a job.'
        ];
        $enquiries = new FakeDatabaseTable();
        $controller = new EnquiryController($enquiries, new FakeDatabaseTable());

        $page = $controller->submitPublic();

        $this->assertSame('Pending', $enquiries->inserted[0]['status']);
        $this->assertSame('Ram', $enquiries->inserted[0]['firstName']);
        $this->assertSame('Thank you. Your enquiry has been saved.', $page['variables']['message']);
    }

    public function testListDefaultsToPendingEnquiries(): void
    {
        $enquiries = new FakeDatabaseTable([['id' => 1, 'status' => 'Pending']]);
        $controller = new EnquiryController($enquiries, new FakeDatabaseTable());

        $page = $controller->list();

        $this->assertSame('enquiries.html.php', $page['template']);
        $this->assertSame('Pending', $page['variables']['selectedStatus']);
        $this->assertStringContainsString('WHERE enquiries.status = :status', $enquiries->queries[0]['sql']);
    }

    public function testListAllDoesNotAddStatusWhereClause(): void
    {
        $_GET = ['status' => 'All'];
        $enquiries = new FakeDatabaseTable();
        $controller = new EnquiryController($enquiries, new FakeDatabaseTable());

        $page = $controller->list();

        $this->assertSame('All', $page['variables']['selectedStatus']);
        $this->assertStringNotContainsString('WHERE enquiries.status', $enquiries->queries[0]['sql']);
    }
}
