<?php
//<!-- 4 ID - KIỂM TRA TRẠNG THÁI NGƯỜI DÙNG -->
class SessionHelper {
    // Kiểm tra xem người dùng đã đăng nhập chưa
    public static function isLoggedIn() {
        return isset($_SESSION['username']);
    }
    
    // Kiểm tra xem người dùng có quyền admin không (kiểm tra trong mảng vai trò)
    // public static function isAdmin() {
    //     return isset($_SESSION['username']) && $_SESSION['user_role'] === 'admin';
    // }
        public static function isAdmin() {
            return isset($_SESSION['roles']) && in_array('admin', $_SESSION['roles']);
        }
}
?>