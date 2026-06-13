<?php
require_once __DIR__ . '/../bootstrap.php';

use JoJobs\Controllers\JobController;
use JoJobs\Controllers\CategoryController;
use JoJobs\Controllers\UserController;
use JoJobs\Controllers\ClientController;
use JoJobs\Controllers\EnquiryController;

$jobController      = new JobController($jobsTable, $categoriesTable, $applicantsTable);
$categoryController = new CategoryController($categoriesTable);
$userController     = new UserController($usersTable);
$clientController   = new ClientController($clientsTable, $jobsTable, $categoriesTable, $applicantsTable);
$enquiryController  = new EnquiryController($enquiriesTable, $usersTable);

$action = $_GET['action'] ?? 'home';

$publicAdminActions = ['login', 'clientLogin'];

if (strpos($action, 'client') === 0 && $action !== 'clientLogin' && !isset($_SESSION['clientLoggedIn'])) {
    $action = 'clientLogin';
} elseif (!isset($_SESSION['loggedin']) && !in_array($action, $publicAdminActions, true) && strpos($action, 'client') !== 0) {
    $action = 'login';
}

switch ($action) {
    case 'login':
        $page = $userController->login();
        break;
    case 'logout':
        $page = $userController->logout();
        break;
    case 'listUsers':
        $page = $userController->list();
        break;
    case 'addUser':
    case 'editUser':
        $page = $userController->edit();
        break;
    case 'deleteUser':
        $page = $userController->delete();
        break;
    case 'home':
        $page = $jobController->home();
        break;
    case 'listJobs':
        $page = $jobController->list();
        break;
    case 'addJob':
    case 'editJob':
        $page = $jobController->edit();
        break;
    case 'deleteJob':
        $page = $jobController->delete();
        break;
    case 'archiveJob':
    case 'repostJob':
        $page = $jobController->archive();
        break;
    case 'viewApplicants':
        $page = $jobController->applicants();
        break;
    case 'listCategories':
        $page = $categoryController->list();
        break;
    case 'addCategory':
    case 'editCategory':
        $page = $categoryController->edit();
        break;
    case 'deleteCategory':
        $page = $categoryController->delete();
        break;
    case 'listClients':
        $page = $clientController->list();
        break;
    case 'addClient':
    case 'editClient':
        $page = $clientController->edit();
        break;
    case 'deleteClient':
        $page = $clientController->delete();
        break;
    case 'clientLogin':
        $page = $clientController->clientLogin();
        break;
    case 'clientLogout':
        $page = $clientController->clientLogout();
        break;
    case 'clientJobs':
        $page = $clientController->clientJobs();
        break;
    case 'clientEditJob':
        $page = $clientController->clientEditJob();
        break;
    case 'clientApplicants':
        $page = $clientController->clientApplicants();
        break;
    case 'listEnquiries':
        $page = $enquiryController->list();
        break;
    case 'completeEnquiry':
        $page = $enquiryController->complete();
        break;
    default:
        $page = $jobController->home();
}

$title = $page['title'] ?? "Jo's Jobs Admin";

if (!empty($page['variables']) && is_array($page['variables'])) {
    extract($page['variables']);
}

ob_start();
include __DIR__ . '/../admintemplates/' . $page['template'];
$output = ob_get_clean();

include __DIR__ . '/../admintemplates/index.html.php';
