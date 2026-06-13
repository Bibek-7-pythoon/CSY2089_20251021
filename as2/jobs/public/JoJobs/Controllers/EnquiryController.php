<?php
namespace JoJobs\Controllers;

class EnquiryController {
    private $enquiriesTable;
    private $usersTable;

    public function __construct($enquiriesTable, $usersTable) {
        $this->enquiriesTable = $enquiriesTable;
        $this->usersTable = $usersTable;
    }

    public function submitPublic() {
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
            $message = 'Thank you. Your enquiry has been saved.';
        }
        return ['template' => 'contact.html.php', 'title' => 'Contact Jo\'s Jobs', 'variables' => ['message' => $message]];
    }

    public function list() {
        $status = $_GET['status'] ?? 'Pending';
        $sql = 'SELECT enquiries.*, users.username AS staffUsername FROM enquiries LEFT JOIN users ON enquiries.staffId = users.id';
        $criteria = [];
        if ($status !== 'All') {
            $sql .= ' WHERE enquiries.status = :status';
            $criteria['status'] = $status;
        }
        $sql .= ' ORDER BY enquiries.id DESC';
        return ['template' => 'enquiries.html.php', 'title' => 'Manage Enquiries', 'variables' => ['enquiries' => $this->enquiriesTable->query($sql, $criteria), 'selectedStatus' => $status]];
    }

    public function complete() {
        if (!empty($_POST['id'])) {
            $this->enquiriesTable->update(['id' => $_POST['id'], 'status' => 'Complete', 'staffId' => $_SESSION['userId'] ?? null]);
        }
        header('Location: index.php?action=listEnquiries&status=Pending');
        exit();
    }
}
