<?php
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');
require_once('app/models/ProductModel.php');
require_once('app/models/AccountModel.php');

class DefaultController
{
    private $categoryModel;
    private $productModel;
    private $accountModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
        $this->productModel = new ProductModel($this->db);
        $this->accountModel = new AccountModel($this->db);
    }

   public function index()
    {
        $limit = 8; // Số sản phẩm mỗi trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Lấy trang hiện tại từ query string
        $offset = ($page - 1) * $limit;

        $keyword = isset($_GET['search']) ? $_GET['search'] : ''; // Lấy từ trường tìm kiếm
        $totalProducts = $this->productModel->getTotalSearchResults($keyword); // Tổng số sản phẩm tìm thấy
        $products = $this->productModel->searchProducts($keyword, $limit, $offset); // Lấy sản phẩm tìm được

        $totalPages = ceil($totalProducts / $limit); // Tổng số trang

        include 'app/views/default/home.php';
    }

    public function dashboard()
    {
        // Lấy tổng số danh mục từ model
        $totalCategories = $this->categoryModel->getTotalCategories();

        // Lấy số lượng sản phẩm từ model
        $totalProducts = $this->productModel->getTotalProducts();

        // Lấy tổng số đơn hàng từ model
        $totalOrders  = $this->productModel->getTotalOrders();

        // Lấy số lượng tài khoản từ model
        $totalAccounts = $this->accountModel->getTotalAccounts();

        include 'app/views/default/admin.php';
    }
}
?>