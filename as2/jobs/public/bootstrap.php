<?php
use CSY2089\DatabaseTable;
use JoJobs\Entities\Job;
use JoJobs\Entities\Category;
use JoJobs\Entities\Applicant;
use JoJobs\Entities\User;
use JoJobs\Entities\Client;
use JoJobs\Entities\Enquiry;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/autoloader.php';
require_once __DIR__ . '/database.php';

$jobsTable       = new DatabaseTable($pdo, 'job', 'id', Job::class);
$categoriesTable = new DatabaseTable($pdo, 'category', 'id', Category::class);
$applicantsTable = new DatabaseTable($pdo, 'applicants', 'id', Applicant::class);
$usersTable      = new DatabaseTable($pdo, 'users', 'id', User::class);
$clientsTable    = new DatabaseTable($pdo, 'clients', 'id', Client::class);
$enquiriesTable  = new DatabaseTable($pdo, 'enquiries', 'id', Enquiry::class);

$categories = $categoriesTable->findAll();
