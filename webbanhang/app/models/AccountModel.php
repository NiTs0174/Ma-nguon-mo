<?php
class AccountModel
{
    private $conn;
    private $table_name = "account";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy tài khoản theo username
    public function getAccountByUsername($username)
    {
        $query = "SELECT * FROM account WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    
    // TẠO TÀI KHOẢN
    function save($username, $name, $password, $role="user"){
        
        $query = "INSERT INTO " . $this->table_name . "(username, password, role) VALUES (:username,:password, :role)";
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $name = htmlspecialchars(strip_tags($name));
        $username = htmlspecialchars(strip_tags($username));
        
        // Gán dữ liệu vào câu lệnh
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        
        // Thực thi câu lệnh
        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (PDOException $e) {
            error_log("Lỗi lưu tài khoản: " . $e->getMessage());
        }
        return false;        
    }

    //----------------------------- 4.1 ROLES -----------------------------------
    //4.1 Lấy tất cả tài khoản
    public function getAllAccounts() {
        $query = "SELECT id, username FROM " . $this->table_name . " ORDER BY username ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //4.1 Lấy danh sách vai trò của tài khoản
    public function getRolesByAccountId($accountId) {
        $query = "SELECT r.name FROM roles r
                  JOIN account_roles ar ON r.id = ar.role_id
                  WHERE ar.account_id = :account_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':account_id', $accountId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN); // Trả về danh sách vai trò
    }
    
    //4.1 Gán vai trò cho tài khoản
    public function assignRoles($accountId, $roles) {
         // Xóa các vai trò cũ
        foreach ($roles as $role) {
            $this->removeRole($accountId, $role);
        }

        // Thêm các vai trò mới
        foreach ($roles as $role) {
            // Lấy ID của vai trò từ bảng roles
            $query = "SELECT id FROM roles WHERE name = :role";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);
            $stmt->execute();
            $roleId = $stmt->fetchColumn();

            if ($roleId) {
                // Kiểm tra xem vai trò đã tồn tại trong bảng account_roles chưa
                $checkQuery = "SELECT COUNT(*) FROM account_roles WHERE account_id = :account_id AND role_id = :role_id";
                $checkStmt = $this->conn->prepare($checkQuery);
                $checkStmt->bindParam(':account_id', $accountId, PDO::PARAM_INT);
                $checkStmt->bindParam(':role_id', $roleId, PDO::PARAM_INT);
                $checkStmt->execute();
                $exists = $checkStmt->fetchColumn();

                if ($exists == 0) {
                    // Thêm vào bảng account_roles
                    $query = "INSERT INTO account_roles (account_id, role_id) VALUES (:account_id, :role_id)";
                    $stmt = $this->conn->prepare($query);
                    $stmt->bindParam(':account_id', $accountId, PDO::PARAM_INT);
                    $stmt->bindParam(':role_id', $roleId, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }
        }
        return true;
    }

    //4.1 Xóa vai trò của tài khoản
    public function removeRole($accountId, $roleName) {
        // Lấy ID của vai trò từ bảng roles
        $query = "SELECT id FROM roles WHERE name = :role";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':role', $roleName, PDO::PARAM_STR);
        $stmt->execute();
        $roleId = $stmt->fetchColumn();

        if ($roleId) {
            // Xóa vai trò từ bảng account_roles
            $query = "DELETE FROM account_roles WHERE account_id = :account_id AND role_id = :role_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':account_id', $accountId, PDO::PARAM_INT);
            $stmt->bindParam(':role_id', $roleId, PDO::PARAM_INT);
            $stmt->execute();
        }
        return true;
    }

    // LẤY TỔNG SỐ TÀI KHOẢN
    public function getTotalAccounts()
    {
        $query = "SELECT COUNT(*) FROM account"; // hoặc bảng chứa thông tin tài khoản
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn(); // Lấy kết quả (số lượng tài khoản)
    }
}
?>