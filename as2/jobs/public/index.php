<?php
require_once __DIR__ . '/bootstrap.php';

use JoJobs\Controllers\PublicController;

$publicController = new PublicController($jobsTable, $categoriesTable, $applicantsTable, $enquiriesTable);
$pageName = $_GET['page'] ?? 'home';

switch ($pageName) {
    case 'jobs':
        $page = $publicController->jobs();
        break;
    case 'apply':
        $page = $publicController->apply();
        break;
    case 'contact':
        $page = $publicController->contact();
        break;
    case 'about':
        $page = $publicController->about();
        break;
    case 'careers-advice':
        $page = $publicController->careersAdvice();
        break;
    case 'home':
    default:
        $page = $publicController->home();
        break;
}

$title = $page['title'] ?? "Jo's Jobs";
if (!empty($page['variables']) && is_array($page['variables'])) {
    extract($page['variables']);
}

ob_start();
include __DIR__ . '/templates/' . $page['template'];
$output = ob_get_clean();

require __DIR__ . '/templates/layout.html.php';
