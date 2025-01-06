<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');
require_once 'vendor/autoload.php';
require_once('app/utils/JWTHandler.php');   //

class AccountController {
    private $accountModel;
    private $db;
    private $jwtHandler;    //
    
    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
        $this->jwtHandler = new JWTHandler();   //
    }

    function register(){
        include_once 'app/views/account/register.php';
    }
    public function login() {
        include_once 'app/views/account/login.php';
    }

    // ĐĂNG KÝ
    function save(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            
            $errors =[];
            if(empty($username)){
                $errors['username'] = "Vui lòng nhập userName!";
            }
            if(empty($fullName)){
                $errors['fullname'] = "Vui lòng nhập fullName!";
            }
            if(empty($password)){
                $errors['password'] = "Vui lòng nhập password!";
            }
            if($password != $confirmPassword){
                $errors['confirmPass'] = "Mật khẩu và xác nhận không khớp!";
            }

            // kiểm tra username đã được đăng ký chưa?
            $account = $this->accountModel->getAccountByUsername($username);            
            if($account){
                $errors['account'] = "Tài khoản đã tồn tại!";
            }
            if(count($errors) > 0){
                include_once 'app/views/account/register.php';
            }else{
                $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
                $result = $this->accountModel->save($username, $fullName, $password);
                
                if($result){
                    $account = $this->accountModel->getAccountByUsername($username);
                    $this->accountModel->assignRoles($account->id, ['user']); 
                    header('Location: /webbanhang/account/login');
                } 
                else{
                    echo "Lỗi khi lưu tài khoản.";
                }
            }
        } 
    }

    // Đăng xuất
    function logout(){
        unset($_SESSION['username']);
        unset($_SESSION['role']);

        // Xóa cookie
        setcookie('username', '', time() - 3600, "/"); // Đặt thời gian hết hạn để xóa cookie
        setcookie('role', '', time() - 3600, "/");

        header('Location: /webbanhang/product');
    }

    //6 API với JWT
    public function checkLogin()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);

        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        $user = $this->accountModel->getAccountByUserName($username);
        if ($user && password_verify($password, $user->password)) {
            $token = $this->jwtHandler->encode(['id' => $user->id, 'username' => $user->username]);
            echo json_encode(['token' => $token]);
        } else {
            http_response_code(401);
            echo json_encode(['message' => 'Invalid credentials']);
        }
    }

    // Kiểm tra đăng nhập
    // public function checkLogin(){
    //     // Kiểm tra xem liệu form đã được submit
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         $username = $_POST['username'] ?? '';
    //         $password = $_POST['password'] ?? '';
            
    //         $account = $this->accountModel->getAccountByUserName($username);
    //         if ($account) {
    //             $pwd_hashed = $account->password;
    //             //check mat khau
    //             if (password_verify($password, $pwd_hashed)) {
                
    //                 //4 session_start();

    //                 // $_SESSION['user_id'] = $account->id;
    //                 // $_SESSION['user_role'] = $account->role;
    //                 $_SESSION['username'] = $account->username;
    //                 $_SESSION['roles'] = $this->accountModel->getRolesByAccountId($account->id);

    //                     //4.2 -------Đăng nhập dài hạn: tạo cookie lưu trữ thông tin đăng nhập-------
    //                     if (isset($_POST['remember_me'])) { // Kiểm tra nếu người dùng chọn "Ghi nhớ đăng nhập"
    //                         setcookie('username', $account->username, time() + (86400 * 30), "/"); // Cookie lưu 30 ngày
    //                         setcookie('role', json_encode($_SESSION['roles']), time() + (86400 * 30), "/");
    //                     }

    //                 header('Location: /webbanhang/product');
    //                 exit;
    //             }
    //             else {
    //                 echo "Mật khẩu không chính xác.";
    //             }
    //         } else {
    //             echo "Tài khoản không tồn tại.";
    //         }
    //     }
    // }

    //----------------------------- 4.1 ROLES -----------------------------------
    //4.1 Hiển thị trang quản lý vai trò
    public function manageRoles() {
        // Kiểm tra quyền admin
        if (!SessionHelper::isLoggedIn() || !SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập vào trang này.";
            return;
        }

        // Lấy danh sách tài khoản từ database
        $accounts = $this->accountModel->getAllAccounts();

        // Gửi thông tin đến view
        include_once 'app/views/account/manageRoles.php';
    }

    //4.1 Gán vai trò cho tài khoản
    public function assignRole() {
        // Kiểm tra nếu người dùng đã đăng nhập và có quyền admin
        if (!SessionHelper::isLoggedIn() || !in_array('admin', $_SESSION['roles'])) {
            echo "Bạn không có quyền truy cập vào trang này.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $roles = $_POST['roles'] ?? [];
    
            if (empty($username) || empty($roles)) {
                echo "Vui lòng chọn tài khoản và vai trò.";
                return;
            }
    
            // Lấy thông tin tài khoản từ username
            $account = $this->accountModel->getAccountByUsername($username);
            if (!$account) {
                echo "Tài khoản không tồn tại.";
                return;
            }
    
            // Gán vai trò cho tài khoản
            if (!$this->accountModel->assignRoles($account->id, $roles)) {
                echo "Lỗi khi gán vai trò.";
            } else {
                echo "Thêm vai trò thành công!";
                // Quay lại trang quản lý vai trò
                header('Location: /webbanhang/account/manageRoles');
            }
        }
    }
    
    //4.1 XOÁ QUYỀN
    public function removeRole() {
        // Kiểm tra quyền admin
        if (!SessionHelper::isLoggedIn() || !SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập vào trang này.";
            return;
        }

        // Lấy thông tin tài khoản và vai trò cần xóa
        $username = $_GET['username'] ?? '';
        $role = $_GET['role'] ?? '';

        if (empty($username) || empty($role)) {
            echo "Vui lòng cung cấp tài khoản và vai trò.";
            return;
        }

        // Lấy tài khoản
        $account = $this->accountModel->getAccountByUsername($username);
        if (!$account) {
            echo "Tài khoản không tồn tại.";
            return;
        }

        // Xóa vai trò
        if ($this->accountModel->removeRole($account->id, $role)) {
            header('Location: /webbanhang/account/manageRoles');
        } else {
            echo "Lỗi khi xóa vai trò.";
        }
    }    

    //--------------------------- 4.3 ĐĂNG NHẬP VỚI GOOGLE / FB -------------------------------------
    
}
?>