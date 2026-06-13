<?php

namespace JoJobs\Controllers;

class JobController {
    private $jobsTable;
    private $categoriesTable;
    private $applicantsTable;

    public function __construct($jobsTable, $categoriesTable, $applicantsTable) {
        $this->jobsTable = $jobsTable;
        $this->categoriesTable = $categoriesTable;
        $this->applicantsTable = $applicantsTable;
    }

    // This explicitly defines the home method called by index.php
    public function home() {
        return [
            'template' => 'adminhome.html.php',
            'title' => 'Admin Home',
            'variables' => []
        ];
    }

    // Maps to action=listJobs
    public function list() {
        $categoryId = $_GET['categoryId'] ?? '';
        $status = $_GET['status'] ?? 'active';
        $today = date('Y-m-d');

        $query = 'SELECT job.*, category.name AS categoryName
                  FROM job
                  LEFT JOIN category ON job.categoryId = category.id
                  WHERE 1=1';
        $criteria = [];

        if ($categoryId !== '') {
            $query .= ' AND job.categoryId = :categoryId';
            $criteria['categoryId'] = $categoryId;
        }

        if ($status === 'active') {
            $query .= ' AND job.archived = 0 AND job.closingDate >= :today';
            $criteria['today'] = $today;
        }
        elseif ($status === 'archived') {
            $query .= ' AND job.archived = 1';
        }

        $query .= ' ORDER BY job.dateAdded DESC, job.id DESC';
        $jobs = $this->jobsTable->query($query, $criteria);
        $categories = $this->categoriesTable->findAll();
        
        foreach ($jobs as $key => $job) {
            $applicants = $this->applicantsTable->find('jobId', $job['id']);
            $jobs[$key]['applicant_count'] = count($applicants);
        }

        return [
            'template' => 'jobs.html.php',
            'title' => 'Manage Jobs',
            'variables' => [
                'jobs' => $jobs,
                'categories' => $categories,
                'selectedCategoryId' => $categoryId,
                'selectedStatus' => $status
            ]
        ];
    }

    // Maps to action=addJob or action=editJob
    public function edit() {
        $message = '';
        $job = null;

        // 1. If the form was submitted, process and save the job payload data
        if (isset($_POST['submit'])) {
            $jobData = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'salary' => $_POST['salary'],
                'location' => $_POST['location'],
                'categoryId' => $_POST['categoryId'],
                'closingDate' => $_POST['closingDate'],
                'archived' => isset($_POST['archived']) ? 1 : 0
            ];

            if (!empty($_POST['id'])) {
                $jobData['id'] = $_POST['id'];
            }

            $this->jobsTable->save($jobData);
            $message = 'Job saved successfully.';
            
            // Re-fetch the record if we just updated an existing item so form updates reflect instantly
            if (!empty($_POST['id'])) {
                $result = $this->jobsTable->find('id', $_POST['id']);
                $job = $result[0] ?? null;
            }
        } 
        // Only query the database if an ID is explicitly supplied in the URL query string.
        elseif (!empty($_GET['id'])) {
            $result = $this->jobsTable->find('id', $_GET['id']);
            $job = $result[0] ?? null;
            
            if (!$job) {
                $message = 'Job not found.';
            }
        }

        // Fetch all categories to populate the dropdown select list element dynamically
        $categories = $this->categoriesTable->findAll();

        return [
            'template' => 'editjob.html.php',
            'title' => $job ? 'Edit Job' : 'Add New Job',
            'variables' => [
                'job' => $job,
                'categories' => $categories,
                'message' => $message
            ]
        ];
    }

    // Maps to action=deleteJob
    public function delete() {
        if (isset($_POST['id'])) {
            $this->jobsTable->delete($_POST['id']);
        }
        header('Location: index.php?action=listJobs');
        exit();
    }

    // Maps to action=archiveJob or action=repostJob
    public function archive() {
        if (isset($_POST['id'])) {
            $archived = ($_GET['action'] ?? '') === 'archiveJob' ? 1 : 0;
            $this->jobsTable->update([
                'id' => $_POST['id'],
                'archived' => $archived
            ]);
        }
        header('Location: index.php?action=listJobs');
        exit();
    }

    // Maps to action=viewApplicants
    public function applicants() {
        $jobId = $_GET['id'] ?? 0;
        $jobResult = $this->jobsTable->find('id', $jobId);
        $job = $jobResult[0] ?? null;

        $applicants = $this->applicantsTable->find('jobId', $jobId);

        return [
            'template' => 'applicants.html.php',
            'title' => 'Job Applicants',
            'variables' => [
                'job' => $job,
                'applicants' => $applicants
            ]
        ];
    }
}