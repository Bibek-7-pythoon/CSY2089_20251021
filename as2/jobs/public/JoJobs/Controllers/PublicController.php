<?php
namespace JoJobs\Controllers;

class PublicController {
    private $jobsTable;
    private $categoriesTable;
    private $applicantsTable;
    private $enquiriesTable;

    public function __construct($jobsTable, $categoriesTable, $applicantsTable, $enquiriesTable) {
        $this->jobsTable = $jobsTable;
        $this->categoriesTable = $categoriesTable;
        $this->applicantsTable = $applicantsTable;
        $this->enquiriesTable = $enquiriesTable;
    }

    public function home(): array {
        $today = date('Y-m-d');
        $jobs = $this->jobsTable->query(
            'SELECT * FROM job WHERE closingDate > :date AND archived = 0 ORDER BY closingDate ASC LIMIT 5',
            ['date' => $today]
        );

        return [
            'template' => 'home.html.php',
            'title' => "Jo's Jobs - Home",
            'variables' => ['jobs' => $jobs, 'categories' => $this->categoriesTable->findAll()]
        ];
    }

    public function jobs(): array {
        $today = date('Y-m-d');
        $categoryId = $_GET['categoryId'] ?? '';
        $titleSearch = trim($_GET['title'] ?? '');
        $locationSearch = trim($_GET['location'] ?? '');

        $query = 'SELECT job.*, category.name AS categoryName
                  FROM job
                  INNER JOIN category ON job.categoryId = category.id
                  WHERE job.closingDate > :date AND job.archived = 0';
        $criteria = ['date' => $today];

        if ($categoryId !== '') {
            $query .= ' AND job.categoryId = :categoryId';
            $criteria['categoryId'] = $categoryId;
        }

        if ($titleSearch !== '') {
            $query .= ' AND job.title LIKE :title';
            $criteria['title'] = '%' . $titleSearch . '%';
        }

        if ($locationSearch !== '') {
            $query .= ' AND job.location LIKE :location';
            $criteria['location'] = '%' . $locationSearch . '%';
        }

        $query .= ' ORDER BY job.closingDate ASC';
        $jobs = $this->jobsTable->query($query, $criteria);
        $categories = $this->categoriesTable->findAll();
        $currentCategory = null;

        foreach ($categories as $category) {
            if ((string)$category['id'] === (string)$categoryId) {
                $currentCategory = $category;
                break;
            }
        }

        return [
            'template' => 'jobs.html.php',
            'title' => $currentCategory ? "Jo's Jobs - " . $currentCategory['name'] . ' Jobs' : "Jo's Jobs - Jobs",
            'variables' => [
                'jobs' => $jobs,
                'categories' => $categories,
                'currentCategory' => $currentCategory,
                'categoryId' => $categoryId,
                'titleSearch' => $titleSearch,
                'locationSearch' => $locationSearch
            ]
        ];
    }

    public function apply(): array {
        $message = '';
        $error = '';
        $job = null;

        if (isset($_POST['submit'])) {
            $cvFileName = null;

            if (!empty($_FILES['cv']['name']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
                $extension = strtolower(pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['pdf', 'doc', 'docx'];

                if (in_array($extension, $allowedExtensions, true)) {
                    if (!is_dir(__DIR__ . '/../../cvs')) {
                        mkdir(__DIR__ . '/../../cvs', 0775, true);
                    }
                    $cvFileName = uniqid('cv_', true) . '.' . $extension;
                    move_uploaded_file($_FILES['cv']['tmp_name'], __DIR__ . '/../../cvs/' . $cvFileName);
                }
                else {
                    $error = 'CV must be a PDF, DOC or DOCX file.';
                }
            }

            if ($error === '') {
                $this->applicantsTable->insert([
                    'name' => trim($_POST['name'] ?? ''),
                    'email' => trim($_POST['email'] ?? ''),
                    'details' => trim($_POST['details'] ?? ''),
                    'jobId' => $_POST['jobId'] ?? null,
                    'cv' => $cvFileName
                ]);
                $message = 'Your application is complete. We will contact you after the closing date.';
            }
        }
        else {
            $result = $this->jobsTable->find('id', $_GET['id'] ?? 0);
            $job = $result[0] ?? null;
            if (!$job) {
                $error = 'Job not found.';
            }
        }

        return [
            'template' => 'apply.html.php',
            'title' => "Jo's Jobs - Apply",
            'variables' => ['message' => $message, 'error' => $error, 'job' => $job, 'categories' => $this->categoriesTable->findAll()]
        ];
    }

    public function contact(): array {
        $message = '';
        if (isset($_POST['submit'])) {
            $this->enquiriesTable->insert([
                'firstName' => trim($_POST['firstName'] ?? ''),
                'surname' => trim($_POST['surname'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'telephone' => trim($_POST['telephone'] ?? ''),
                'enquiry' => trim($_POST['enquiry'] ?? ''),
                'status' => 'Pending'
            ]);
            $message = 'Thank you. Your enquiry has been saved and a member of staff will deal with it.';
        }

        return ['template' => 'contact.html.php', 'title' => "Jo's Jobs - Contact", 'variables' => ['message' => $message]];
    }

    public function about(): array {
        return ['template' => 'about.html.php', 'title' => "Jo's Jobs - About Us", 'variables' => ['categories' => $this->categoriesTable->findAll()]];
    }

    public function careersAdvice(): array {
        return ['template' => 'careers-advice.html.php', 'title' => "Jo's Jobs - Careers Advice", 'variables' => []];
    }
}
