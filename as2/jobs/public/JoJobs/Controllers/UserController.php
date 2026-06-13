<?php

namespace JoJobs\Controllers;

class UserController {
    private $usersTable;

    public function __construct($usersTable) {
        $this->usersTable = $usersTable;
    }

    public function login() {
        $error = '';

        if (isset($_POST['submit'])) {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            $users = $this->usersTable->find('username', $username);
            $user = $users[0] ?? null;

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['userId'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['userRole'] = $user['role'];
                header('Location: index.php?action=home');
                exit();
            }
            else {
                $error = 'Invalid username or password.';
            }
        }

        return [
            'template' => 'login.html.php',
            'title' => 'Admin Login',
            'variables' => ['error' => $error]
        ];
    }

    public function logout() {
        session_destroy();
        header('Location: index.php?action=login');
        exit();
    }

    public function list() {
        $users = $this->usersTable->findAll();

        return [
            'template' => 'users.html.php',
            'title' => 'Manage Staff Accounts',
            'variables' => ['users' => $users]
        ];
    }

    public function edit() {
        $message = '';
        $user = null;

        if (isset($_POST['submit'])) {
            $userData = [
                'username' => trim($_POST['username']),
                'role' => $_POST['role']
            ];

            if (!empty($_POST['password'])) {
                $userData['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            if (!empty($_POST['id'])) {
                $userData['id'] = $_POST['id'];
                $currentUser = $this->usersTable->find('id', $_POST['id']);
                if (empty($userData['password']) && isset($currentUser[0]['password'])) {
                    $userData['password'] = $currentUser[0]['password'];
                }
            }

            if ($userData['username'] === '') {
                $message = 'Username is required.';
            }
            elseif (empty($_POST['id']) && empty($_POST['password'])) {
                $message = 'Password is required for new accounts.';
            }
            else {
                $this->usersTable->save($userData);
                $message = 'Staff account saved successfully.';
            }
        }
        elseif (!empty($_GET['id'])) {
            $result = $this->usersTable->find('id', $_GET['id']);
            $user = $result[0] ?? null;
        }

        return [
            'template' => 'edituser.html.php',
            'title' => $user ? 'Edit Staff Account' : 'Add Staff Account',
            'variables' => ['user' => $user, 'message' => $message]
        ];
    }

    public function delete() {
        if (isset($_POST['id']) && (int)$_POST['id'] !== (int)($_SESSION['userId'] ?? 0)) {
            $this->usersTable->delete($_POST['id']);
        }

        header('Location: index.php?action=listUsers');
        exit();
    }
}
