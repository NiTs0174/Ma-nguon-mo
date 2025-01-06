<?php
    //3.1 Đoạn mã này nên được thêm vào phần đầu của mọi trang cần xác thực người dùng
    if (isset($_COOKIE['username']) && isset($_COOKIE['role'])) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Bắt đầu session nếu chưa bắt đầu
        }
        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['roles'] = json_decode($_COOKIE['role'], true); // roles là một mảng
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Quản lý sản phẩm</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang/Product/">Danh sách sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang/Product/add">Thêm sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang/Category/list">Category</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang/Product/favoriteList">Favorites</a>
                </li>
                <!-- < ?php
                if (SessionHelper::isLoggedIn()) {
                    // Kiểm tra nếu người dùng là admin
                    if (in_array('admin', $_SESSION['roles'])) {
                        echo "<li class='nav-item'>
                                <a class='nav-link' href='/webbanhang/account/manageRoles'>Thêm vai trò</a>
                            </li>";
                    }
                    echo "<li class='nav-item'>
                            <a class='nav-link' href='/webbanhang/account/logout'>Logout</a>
                        </li>";
                } else {
                    echo "<li class='nav-item'>
                            <a class='nav-link' href='/webbanhang/account/login'>Login</a>
                        </li>";
                }
                ?> -->
                <!--6 JWT -->
                <li class="nav-item" id="nav-login">
                    <a class="nav-link" href="/webbanhang/account/login">Login</a>
                </li>
                <li class="nav-item" id="nav-logout" style="display: none;">
                    <a class="nav-link" href="#" onclick="logout()">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
     
<script>
    function logout() {
        localStorage.removeItem('jwtToken');
        location.href = '/webbanhang/account/login';
    }

    document.addEventListener("DOMContentLoaded", function() {
        const token = localStorage.getItem('jwtToken');
        if (token) {
            document.getElementById('nav-login').style.display = 'none';
            document.getElementById('nav-logout').style.display = 'block';
        } else {
            document.getElementById('nav-login').style.display = 'block';
            document.getElementById('nav-logout').style.display = 'none';
        }
    });
</script>  

    <div class="container mt-4"></div>
        <!-- Nội dung trang -->      