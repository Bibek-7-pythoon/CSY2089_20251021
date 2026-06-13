<?php
namespace JoJobs\Controllers;

class ClientController {
    private $clientsTable;
    private $jobsTable;
    private $categoriesTable;
    private $applicantsTable;

    public function __construct($clientsTable, $jobsTable, $categoriesTable, $applicantsTable) {
        $this->clientsTable = $clientsTable;
        $this->jobsTable = $jobsTable;
        $this->categoriesTable = $categoriesTable;
        $this->applicantsTable = $applicantsTable;
    }

    public function list() {
        return ['template' => 'clients.html.php', 'title' => 'Manage Clients', 'variables' => ['clients' => $this->clientsTable->findAll()]];
    }

    public function edit() {
        $message = '';
        $client = null;
        if (isset($_POST['submit'])) {
            $data = [
                'companyName' => trim($_POST['companyName'] ?? ''),
                'username' => trim($_POST['username'] ?? '')
            ];
            if (!empty($_POST['password'])) {
                $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }
            if (!empty($_POST['id'])) {
                $data['id'] = $_POST['id'];
                if (empty($data['password'])) {
                    $current = $this->clientsTable->find('id', $_POST['id']);
                    $data['password'] = $current[0]['password'] ?? '';
                }
            }
            if ($data['companyName'] === '' || $data['username'] === '') {
                $message = 'Company name and username are required.';
            } elseif (empty($_POST['id']) && empty($_POST['password'])) {
                $message = 'Password is required for new clients.';
            } else {
                $this->clientsTable->save($data);
                $message = 'Client account saved successfully.';
            }
        } elseif (!empty($_GET['id'])) {
            $result = $this->clientsTable->find('id', $_GET['id']);
            $client = $result[0] ?? null;
        }
        return ['template' => 'editclient.html.php', 'title' => $client ? 'Edit Client' : 'Add Client', 'variables' => ['client' => $client, 'message' => $message]];
    }

    public function delete() {
        if (!empty($_POST['id'])) $this->clientsTable->delete($_POST['id']);
        header('Location: index.php?action=listClients');
        exit();
    }

    public function clientLogin() {
        $error = '';
        if (isset($_POST['submit'])) {
            $clients = $this->clientsTable->find('username', trim($_POST['username'] ?? ''));
            $client = $clients[0] ?? null;
            if ($client && password_verify($_POST['password'] ?? '', $client['password'])) {
                $_SESSION['clientLoggedIn'] = true;
                $_SESSION['clientId'] = $client['id'];
                $_SESSION['clientCompanyName'] = $client['companyName'];
                header('Location: index.php?action=clientJobs');
                exit();
            }
            $error = 'Invalid client username or password.';
        }
        return ['template' => 'clientlogin.html.php', 'title' => 'Client Login', 'variables' => ['error' => $error]];
    }

    public function clientLogout() {
        unset($_SESSION['clientLoggedIn'], $_SESSION['clientId'], $_SESSION['clientCompanyName']);
        header('Location: index.php?action=clientLogin');
        exit();
    }

    public function clientJobs() {
        $clientId = $_SESSION['clientId'] ?? 0;
        $jobs = $this->jobsTable->query('SELECT job.*, category.name AS categoryName FROM job LEFT JOIN category ON job.categoryId = category.id WHERE job.clientId = :clientId ORDER BY job.dateAdded DESC', ['clientId' => $clientId]);
        return ['template' => 'clientjobs.html.php', 'title' => 'My Jobs', 'variables' => ['jobs' => $jobs]];
    }

    public function clientEditJob() {
        $message = '';
        $job = null;
        $clientId = $_SESSION['clientId'] ?? 0;
        if (isset($_POST['submit'])) {
            $data = [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'salary' => $_POST['salary'] ?? '',
                'location' => $_POST['location'] ?? '',
                'categoryId' => $_POST['categoryId'] ?? '',
                'closingDate' => $_POST['closingDate'] ?? '',
                'archived' => 0,
                'clientId' => $clientId
            ];
            if (!empty($_POST['id'])) {
                $existing = $this->jobsTable->query('SELECT id FROM job WHERE id = :id AND clientId = :clientId', ['id' => $_POST['id'], 'clientId' => $clientId]);
                if ($existing) $data['id'] = $_POST['id'];
            }
            $this->jobsTable->save($data);
            header('Location: index.php?action=clientJobs');
            exit();
        } elseif (!empty($_GET['id'])) {
            $result = $this->jobsTable->query('SELECT * FROM job WHERE id = :id AND clientId = :clientId', ['id' => $_GET['id'], 'clientId' => $clientId]);
            $job = $result[0] ?? null;
            if (!$job) $message = 'Job not found or you do not have permission to edit it.';
        }
        return ['template' => 'clienteditjob.html.php', 'title' => $job ? 'Edit My Job' : 'Add Job', 'variables' => ['job' => $job, 'categories' => $this->categoriesTable->findAll(), 'message' => $message]];
    }

    public function clientApplicants() {
        $clientId = $_SESSION['clientId'] ?? 0;
        $jobId = $_GET['id'] ?? 0;
        $job = $this->jobsTable->query('SELECT * FROM job WHERE id = :id AND clientId = :clientId', ['id' => $jobId, 'clientId' => $clientId]);
        $job = $job[0] ?? null;
        $applicants = $job ? $this->applicantsTable->find('jobId', $jobId) : [];
        return ['template' => 'clientapplicants.html.php', 'title' => 'My Job Applicants', 'variables' => ['job' => $job, 'applicants' => $applicants]];
    }
}
