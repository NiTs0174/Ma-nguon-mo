<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');

class CategoryController
{
    private $categoryModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }

    public function list()
    {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }

    // Create a new category
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            if ($this->categoryModel->createCategory($name, $description)) {
                header('Location: /webbanhang/category/list');
            }
        }
        include 'app/views/category/create.php';
    }

    // Edit a category
    public function edit($id)
    {
        $category = $this->categoryModel->getCategoryById($id);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            if ($this->categoryModel->updateCategory($id, $name, $description)) {
                header('Location: /webbanhang/category/list');
            }
        }
        include 'app/views/category/edit.php';
    }

    // Delete a category
    public function delete($id)
    {
        $this->categoryModel->deleteProductsByCategory($id);
        if ($this->categoryModel->deleteCategory($id)) {
            header('Location: /webbanhang/category/list');
        }
    }    
}
?>