<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');

class ProductController
{
    private $productModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);  
    }

    public function index()
    {
        // Kiểm tra quyền admin
        if (!SessionHelper::isLoggedIn() || !SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập vào trang này.";
            return;
        }

        $products = $this->productModel->getProducts();
        include 'app/views/product/list.php';
    }
    
    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function add()
    {
        // Kiểm tra quyền admin
        if (!SessionHelper::isLoggedIn() || !SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập vào trang này.";
            return;
        }

        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }

    public function save()
    {
        // Kiểm tra quyền admin
        if (!SessionHelper::isLoggedIn() || !SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập vào trang này.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = "";
            }   
            $result = $this->productModel->addProduct($name, $description, $price, 
            $category_id, $image);

            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {
                header('Location: /webbanhang/Product');
            }
        }
    }

    public function edit($id)
    {
        // Kiểm tra quyền admin
        if (!SessionHelper::isLoggedIn() || !SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập vào trang này.";
            return;
        }

        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();
        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function update()
    {
        // Kiểm tra quyền admin
        if (!SessionHelper::isLoggedIn() || !SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập vào trang này.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = $_POST['existing_image'];
            }

            $edit = $this->productModel->updateProduct($id, $name, $description, 
                                                $price, $category_id, $image);
            if ($edit) {
                header('Location: /webbanhang/Product');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }

    public function delete($id)
    {
        // Kiểm tra quyền admin
        if (!SessionHelper::isLoggedIn() || !SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập vào trang này.";
            return;
        }
        
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /webbanhang/Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

    //2 Thêm ảnh
    private function uploadImage($file)
    {
        $target_dir = "uploads/";

        // Kiểm tra và tạo thư mục nếu chưa tồn tại
        if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Kiểm tra xem file có phải là hình ảnh không
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }

        // Kiểm tra kích thước file (10 MB = 10 * 1024 * 1024 bytes)
        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Hình ảnh có kích thước quá lớn.");
        }

        // Chỉ cho phép một số định dạng hình ảnh nhất định
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
        }

        // Lưu file
        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }
        return $target_file;
    }

    //----------------------------- 2.1 FAVORITES -----------------------------------
    // thêm yêu thích
    public function addToFavorite($id)
    {
        // if (!isset($_SESSION['user_id'])) {
        //     echo "Vui lòng đăng nhập để thêm sản phẩm vào danh sách yêu thích.";
        //     return;
        // }

        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }

        // Nếu chưa có session cho yêu thích, tạo mới
        if (!isset($_SESSION['favorites'])) {
            $_SESSION['favorites'] = [];
        }

        // Kiểm tra xem sản phẩm đã có trong danh sách yêu thích chưa
        if (isset($_SESSION['favorites'][$id])) {
            echo "Sản phẩm này đã có trong danh sách yêu thích của bạn.";
            $previousPage = $_SERVER['HTTP_REFERER'] ?? '/webbanhang';
            header('Location: ' . $previousPage);
            exit();
        }

        // Lưu sản phẩm vào session với thời gian hết hạn (30 ngày từ bây giờ)
        $_SESSION['favorites'][$id] = [
            'product' => $product,
            'expires_at' => time() + (30 * 24 * 60 * 60)  // 30 ngày tính từ thời điểm hiện tại
        ];

        echo "Sản phẩm đã được thêm vào danh sách yêu thích.";
        // Trả về trang trước đó
        $previousPage = $_SERVER['HTTP_REFERER'] ?? '/webbanhang';
        header('Location: ' . $previousPage);
        exit(); // Dừng thực thi tiếp sau khi redirect
    }

    // XOÁ SẢN PHẨM KHỎI YÊU THÍCH KHI QUÁ HẠN
    public function checkFavoritesExpiration()
    {
        if (isset($_SESSION['favorites'])) {
            foreach ($_SESSION['favorites'] as $id => $favorite) {
                // Kiểm tra nếu sản phẩm yêu thích đã hết hạn
                if ($favorite['expires_at'] < time()) {
                    unset($_SESSION['favorites'][$id]);  // Xóa sản phẩm hết hạn
                }
            }
        }
    }

    //2.1 Gọi hàm kiểm tra khi cần, ví dụ khi người dùng vào trang giỏ hàng hoặc danh sách yêu thích
    public function favoriteList()
    {
        // Kiểm tra và xóa các sản phẩm hết hạn
        $this->checkFavoritesExpiration();

        // Hiển thị danh sách yêu thích
        $favorites = isset($_SESSION['favorites']) ? $_SESSION['favorites'] : [];
        include 'app/views/product/favorites.php';
    }

    // XOÁ KHỎI DANH SÁCH Ở TRANG CHỦ
    public function removeFromFavorite($id)
    {
        if (isset($_SESSION['favorites'][$id])) {
            unset($_SESSION['favorites'][$id]);
            echo "Sản phẩm đã được xóa khỏi danh sách yêu thích.";
        } else {
            echo "Không tìm thấy sản phẩm trong danh sách yêu thích.";
        }
        header('Location: /webbanhang');
    }

    // XOÁ KHỎI Ở DANH SÁCH
    public function removeFromFavoriteList($id)
    {
        if (isset($_SESSION['favorites'][$id])) {
            unset($_SESSION['favorites'][$id]);
            echo "Sản phẩm đã được xóa khỏi danh sách yêu thích.";
        } else {
            echo "Không tìm thấy sản phẩm trong danh sách yêu thích.";
        }
    
        // Trả về trang trước đó
        $previousPage = $_SERVER['HTTP_REFERER'] ?? '/webbanhang'; // Nếu không có HTTP_REFERER, quay về trang chủ
        header('Location: ' . $previousPage);
        exit(); // Dừng thực thi tiếp sau khi redirect
    }
    //----------------------------- 3. CART -----------------------------------
    //3 GIO HANG - LƯU COOKIE CART (THEO PHIÊN - MẤT KHI OUT BROWSER)-->
    public function addToCart($id)
    {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image
            ];
        }

        header('Location: /webbanhang/Product/cart');
    }   

    public function cart()
    {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        include 'app/views/product/cart.php';
    }

    // Cập nhật số lượng giỏ hàng
    public function updateCartQuantity1($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $quantity = (int)$_POST['quantity']; // Lấy số lượng từ form
            if ($quantity > 0) {
                // Cập nhật số lượng sản phẩm trong giỏ hàng
                $_SESSION['cart'][$id]['quantity'] = $quantity;
            } else {
                // Nếu số lượng <= 0, xóa sản phẩm khỏi giỏ hàng
                unset($_SESSION['cart'][$id]);
            }
        }

        // Chuyển hướng đến giỏ hàng
        header('Location: /webbanhang/Product/cart');
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart1($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            // Xóa sản phẩm khỏi giỏ hàng
            unset($_SESSION['cart'][$id]);
        }

        // Chuyển hướng đến giỏ hàng
        header('Location: /webbanhang/Product/cart');
    }

    public function checkout()
    {
        include 'app/views/product/checkout.php';
    }

    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            // Kiểm tra giỏ hàng
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo "Giỏ hàng trống.";
                return;
            }

            // Lấy user_id từ session
            $userId = SessionHelper::getUserId();
            if (!$userId) {
                $userId = Null;
            }

            // Bắt đầu giao dịch        
            $this->db->beginTransaction();

            try {
                // Lưu thông tin đơn hàng vào bảng orders
                $query = "INSERT INTO orders (name, phone, address, user_id) VALUES (:name, 
                :phone, :address, :user_id)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':address', $address);
                $stmt->bindParam(':user_id', $userId);
                $stmt->execute();
                $order_id = $this->db->lastInsertId();

                // Lưu chi tiết đơn hàng vào bảng order_details
                $cart = $_SESSION['cart'];
                foreach ($cart as $product_id => $item) {
                    $query = "INSERT INTO order_details (order_id, product_id, 
                    quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':order_id', $order_id);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':quantity', $item['quantity']);
                    $stmt->bindParam(':price', $item['price']);
                    $stmt->execute();
                }

                // Xóa giỏ hàng sau khi thanh toán thành công
                $device_token = $this->getDeviceToken(); // Lấy token thiết bị
                $query = "DELETE FROM carts WHERE device_token = :device_token";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':device_token', $device_token);
                $stmt->execute();

                // Xóa giỏ hàng sau khi đặt hàng thành công
                unset($_SESSION['cart']);

                // Commit giao dịch
                $this->db->commit();

                // Chuyển hướng đến trang xác nhận đơn hàng
                header('Location: /webbanhang/Product/orderConfirmation');
            } catch (Exception $e) {
                // Rollback giao dịch nếu có lỗi
                $this->db->rollBack();
                echo "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
            }
        }
    }

    public function orderConfirmation()
    {
        include 'app/views/product/orderConfirmation.php';
    }

    //----------- 3.1 LƯU COOKIE CART (THEO TRÌNH DUYỆT - KHÔNG MẤT KHI OUT BROWSER) -----------------
    public function getDeviceToken()
    {
        if (!isset($_COOKIE['device_token'])) {
            $device_token = bin2hex(random_bytes(16)); // Tạo token ngẫu nhiên
            setcookie('device_token', $device_token, time() + (365 * 24 * 60 * 60), '/'); // Lưu 1 năm
        } else {
            $device_token = $_COOKIE['device_token'];
        }
        return $device_token;
    }  

    public function addToCart2($id)
    {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }

        $device_token = $this->getDeviceToken(); // Lấy token thiết bị

        // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
        $query = "SELECT * FROM carts WHERE device_token = :device_token AND product_id = :product_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':device_token', $device_token);
        $stmt->bindParam(':product_id', $id);
        $stmt->execute();
        $cartItem = $stmt->fetch();

        if ($cartItem) {
            // Cập nhật số lượng
            $query = "UPDATE carts SET quantity = quantity + 1 WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $cartItem['id']);
            $stmt->execute();
        } else {
            // Thêm mới sản phẩm
            $query = "INSERT INTO carts (device_token, product_id, quantity) VALUES (:device_token, :product_id, 1)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':device_token', $device_token);
            $stmt->bindParam(':product_id', $id);
            $stmt->execute();
        }

        header('Location: /webbanhang/Product/cart2');
    }

    public function cart2()
    {
        $device_token = $this->getDeviceToken(); // Lấy token thiết bị
    
        $query = "SELECT c.product_id, c.quantity, p.name, p.price, p.image 
                  FROM carts c
                  JOIN product p ON c.product_id = p.id
                  WHERE c.device_token = :device_token";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':device_token', $device_token);
        $stmt->execute();
        $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        include 'app/views/product/cart2.php';
    }

    public function removeFromCart($id)
    {
        $device_token = $this->getDeviceToken(); // Lấy token thiết bị

        $query = "DELETE FROM carts WHERE device_token = :device_token AND product_id = :product_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':device_token', $device_token);
        $stmt->bindParam(':product_id', $id);
        $stmt->execute();

        header('Location: /webbanhang/Product/cart2');
    }

    public function updateCartQuantity($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $quantity = (int)$_POST['quantity'];
            $device_token = $this->getDeviceToken();

            if ($quantity <= 0) {
                // Nếu số lượng <= 0, xóa sản phẩm khỏi giỏ hàng
                $this->removeFromCart($id);
            } else {
                // Nếu số lượng > 0, cập nhật số lượng sản phẩm
                $query = "UPDATE carts SET quantity = :quantity WHERE device_token = :device_token AND product_id = :product_id";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':quantity', $quantity);
                $stmt->bindParam(':device_token', $device_token);
                $stmt->bindParam(':product_id', $id);
                $stmt->execute();
            }
        }
        header('Location: /webbanhang/Product/cart2');
    }

    public function syncCartWithDatabase($device_token, $username) {
        // Lấy giỏ hàng từ cookie
        $query = "SELECT * FROM carts WHERE device_token = :device_token";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':device_token', $device_token);
        $stmt->execute();
        $cartItems = $stmt->fetchAll();
    
        foreach ($cartItems as $item) {
            // Thêm sản phẩm vào giỏ hàng của người dùng
            $query = "INSERT INTO carts (user_id, product_id, quantity) 
                      VALUES ((SELECT id FROM account WHERE username = :username), :product_id, :quantity)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':product_id', $item['product_id']);
            $stmt->bindParam(':quantity', $item['quantity']);
            $stmt->execute();
        }
    
        // Xóa giỏ hàng cookie
        setcookie('device_token', '', time() - 3600, '/'); // Xóa cookie sau khi đồng bộ
    }

    //------------------------------------- QUẢN LÝ ĐƠN HÀNG ------------------------------------------
    public function manageOrders()
    {
        // Kiểm tra quyền admin
        if (!SessionHelper::isLoggedIn() || !SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập vào trang này.";
            return;
        }

        // Số đơn hàng hiển thị trên mỗi trang
        $limit = 10;

        // Lấy trang hiện tại từ query string (mặc định là trang 1)
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        // Truy vấn tất cả các đơn hàng
        $query = "SELECT o.id, o.name, o.phone, o.address, o.created_at, 
                        SUM(od.quantity * od.price) as total
                FROM orders o
                LEFT JOIN order_details od ON o.id = od.order_id
                GROUP BY o.id
                LIMIT :limit OFFSET :offset";   //
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);     //
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);   //
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Truy vấn tổng số đơn hàng để tính số trang
        $queryTotal = "SELECT COUNT(*) as total_orders FROM orders";
        $stmtTotal = $this->db->prepare($queryTotal);
        $stmtTotal->execute();
        $totalOrders = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total_orders'];

        // Tính số trang
        $totalPages = ceil($totalOrders / $limit);

        // Hiển thị trang quản lý đơn hàng
        include 'app/views/product/manageOrders.php';
    }

    public function deleteOrder($order_id)
    {
        // Kiểm tra quyền người dùng (nếu cần)
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền thực hiện hành động này.";
            return;
        }

        // Kiểm tra tính hợp lệ của order_id
        if (!is_numeric($order_id)) {
            echo "ID đơn hàng không hợp lệ.";
            return;
        }

        // Lấy URL của trang hiện tại
        $currentUrl = $_SERVER['HTTP_REFERER'];

        // Bắt đầu giao dịch
        $this->db->beginTransaction();

        try {
            // Xóa chi tiết đơn hàng trước
            $query = "DELETE FROM order_details WHERE order_id = :order_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->execute();

            // Xóa đơn hàng
            $query = "DELETE FROM orders WHERE id = :order_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->execute();

            // Commit giao dịch
            $this->db->commit();

            // Chuyển hướng lại trang hiện tại với thông báo thành công
            header("Location: $currentUrl?message=success");
            exit;
        } catch (Exception $e) {
            // Rollback giao dịch nếu có lỗi
            $this->db->rollBack();
            echo "Đã xảy ra lỗi khi xóa đơn hàng: " . $e->getMessage();
        }
    }

    public function viewOrderDetails($id)
    {
        // Kiểm tra quyền admin
        if (!SessionHelper::isLoggedIn() || !SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập vào trang này.";
            return;
        }
        
        // Lấy thông tin đơn hàng
        $query = "SELECT o.id, o.name, o.phone, o.address, o.created_at, o.user_id
                FROM orders o
                WHERE o.id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        // Lấy chi tiết đơn hàng
        $query = "SELECT p.name, od.quantity, od.price, (od.quantity * od.price) as subtotal
                FROM order_details od
                JOIN product p ON od.product_id = p.id
                WHERE od.order_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Hiển thị trang chi tiết đơn hàng
        include 'app/views/product/orderDetails.php';
    } 

    public function orderHistory()
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!isset($_SESSION['user_id'])) {
            echo "Vui lòng đăng nhập để xem lịch sử đơn hàng.";
            return;
        }

        $user_id = $_SESSION['user_id'];

        // Truy vấn tất cả các đơn hàng của người dùng
        $query = "SELECT o.id, o.name, o.phone, o.address, o.created_at, 
                        SUM(od.quantity * od.price) AS total
                FROM orders o
                LEFT JOIN order_details od ON o.id = od.order_id
                WHERE o.user_id = :user_id
                GROUP BY o.id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Hiển thị trang lịch sử đơn hàng
        include 'app/views/product/orderHistory.php';
    }

    public function orderDetails($id)
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!isset($_SESSION['user_id'])) {
            echo "Vui lòng đăng nhập để xem chi tiết đơn hàng.";
            return;
        }
    
        $user_id = $_SESSION['user_id'];
    
        // Truy vấn thông tin đơn hàng của người dùng
        $query = "SELECT o.id, o.name, o.phone, o.address, o.created_at, 
                         SUM(od.quantity * od.price) AS total
                  FROM orders o
                  LEFT JOIN order_details od ON o.id = od.order_id
                  WHERE o.id = :id AND o.user_id = :user_id
                  GROUP BY o.id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Kiểm tra nếu không có đơn hàng
        if (!$order) {
            echo "Không tìm thấy đơn hàng.";
            return;
        }
    
        // Truy vấn chi tiết đơn hàng
        $query = "SELECT p.name, od.quantity, od.price, (od.quantity * od.price) as subtotal
                  FROM order_details od
                  JOIN product p ON od.product_id = p.id
                  WHERE od.order_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Hiển thị chi tiết đơn hàng
        include 'app/views/product/orderDetails-home.php';
    }
}
?>