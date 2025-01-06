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
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }

    public function save()
    {
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
            return;
        }

        // Lưu sản phẩm vào session với thời gian hết hạn (30 ngày từ bây giờ)
        $_SESSION['favorites'][$id] = [
            'product' => $product,
            'expires_at' => time() + (30 * 24 * 60 * 60)  // 30 ngày tính từ thời điểm hiện tại
        ];

        echo "Sản phẩm đã được thêm vào danh sách yêu thích.";
        header('Location: /webbanhang/Product');
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
        header('Location: /webbanhang/Product');
    }

    // XOÁ KHỎI Ở DANH SÁCH
    public function removeFromFavoriteList($id)
    {
        // Kiểm tra xem sản phẩm có tồn tại trong danh sách yêu thích không
        if (isset($_SESSION['favorites'][$id])) {
            unset($_SESSION['favorites'][$id]);  // Xóa sản phẩm khỏi danh sách yêu thích
            header('Location: /webbanhang/Product/favoriteList');  // Chuyển hướng về trang danh sách yêu thích
            exit;
        } else {
            echo "Không tìm thấy sản phẩm trong danh sách yêu thích.";
        }
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

            // Bắt đầu giao dịch        
            $this->db->beginTransaction();

            try {
                // Lưu thông tin đơn hàng vào bảng orders
                $query = "INSERT INTO orders (name, phone, address) VALUES (:name, 
                :phone, :address)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':address', $address);
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
}
?>
