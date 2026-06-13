<?php

namespace JoJobs\Controllers;

class CategoryController {
    private $categoriesTable;

    public function __construct($categoriesTable) {
        $this->categoriesTable = $categoriesTable;
    }

    public function list() {
        $categories = $this->categoriesTable->findAll();

        return [
            'template' => 'categories.html.php',
            'title' => 'Manage Categories',
            'variables' => [
                'categories' => $categories
            ]
        ];
    }

    // This method handles BOTH adding and editing categories dynamically
    public function edit() {
        $message = '';
        $currentCategory = null;

        // 1. If the form was submitted, save the data
        if (isset($_POST['submit'])) {
            $categoryData = [
                'name' => $_POST['name']
            ];

            // If an ID is passed in the form, append it to update the existing record
            if (!empty($_POST['id'])) {
                $categoryData['id'] = $_POST['id'];
            }

            // DatabaseTable handles the insertion/update logic automatically
            $this->categoriesTable->save($categoryData);
            $message = 'Category saved successfully.';
            
            // Re-fetch the record if we just updated an existing item
            if (!empty($_POST['id'])) {
                $result = $this->categoriesTable->find('id', $_POST['id']);
                $currentCategory = $result[0] ?? null;
            }
        } 
        // 2. ONLY search the database if an ID is explicitly provided in the URL query string
        // Changing 'isset($_GET['id'])' to '!empty($_GET['id'])' prevents errors when adding new items
        elseif (!empty($_GET['id'])) {
            $result = $this->categoriesTable->find('id', $_GET['id']);
            $currentCategory = $result[0] ?? null;
            
            if (!$currentCategory) {
                $message = 'Category not found.';
            }
        }

        // If no ID is present in the URL, $currentCategory remains null, which triggers a blank form to "Add"
        return [
            'template' => 'editcategory.html.php',
            'title' => $currentCategory ? 'Edit Category' : 'Add New Category',
            'variables' => [
                'currentCategory' => $currentCategory,
                'message' => $message
            ]
        ];
    }

    public function delete() {
        if (isset($_POST['id'])) {
            $this->categoriesTable->delete($_POST['id']);
        }
        header('Location: index.php?action=listCategories');
        exit();
    }
}