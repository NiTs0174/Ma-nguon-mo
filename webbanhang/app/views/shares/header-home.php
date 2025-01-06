<?php
    //3.1 Đoạn mã này nên được thêm vào phần đầu của mọi trang cần xác thực người dùng
    if (isset($_COOKIE['username']) && isset($_COOKIE['role'])) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Bắt đầu session nếu chưa bắt đầu
        }
        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['roles'] = json_decode($_COOKIE['role'], true); // roles là một mảng
        // Sau khi người dùng đăng nhập thành công
         $_SESSION['user_id'] = $user_id;  // Lưu user_id vào session
    }
?>

<!doctype html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>NHASACHTV - Nhà sách trực tuyến</title>
      <!-- Favicon -->
      <link rel="shortcut icon" href="/webbanhang/public/images/favicon.ico" />
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="/webbanhang/public/css/bootstrap.min.css">
      <!-- Typography CSS -->
      <link rel="stylesheet" href="/webbanhang/public/css/typography.css">
      <!-- Style CSS -->
      <link rel="stylesheet" href="/webbanhang/public/css/style.css">
      <!-- Responsive CSS -->
      <link rel="stylesheet" href="/webbanhang/public/css/responsive.css">
   </head>
   <body>
      <!-- Wrapper Start -->
      <div class="wrapper">
         <!-- Sidebar  -->
         <div class="iq-sidebar">
            <div class="iq-sidebar-logo d-flex justify-content-between">
               <a href="/webbanhang" class="header-logo">
                  <img src="/webbanhang/public/images/logo.png" class="img-fluid rounded-normal" alt="">
                  <div class="logo-title">
                     <span class="text-primary text-uppercase">NHA SACH</span>
                  </div>
               </a>               
               <div class="iq-menu-bt-sidebar">
                  <div class="iq-menu-bt align-self-center">
                     <div class="wrapper-menu">
                        <div class="main-circle"><i class="las la-bars"></i></div>
                     </div>
                  </div>
               </div>
            </div>
            <div id="sidebar-scrollbar">
               <nav class="iq-sidebar-menu">
                  <ul id="iq-sidebar-toggle" class="iq-menu">
                     <li class="active active-menu">
                        <a href="#dashboard" class="iq-waves-effect" data-toggle="collapse" aria-expanded="true"><span class="ripple rippleEffect"></span><i class="las la-home iq-arrow-left"></i><span>Trang Chủ</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                        <ul id="dashboard" class="iq-submenu collapse show" data-parent="#iq-sidebar-toggle">
                        </ul>
                     </li>
                     <li>
                        <a href="#ui-elements" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="lab la-elementor iq-arrow-left"></i><span>Danh mục sản phẩm</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                        <ul id="ui-elements" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                           <li class="elements">
                              <a href="#sub-menu" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-play-circle-line"></i><span>Sách Trong Nước</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                           </li>
                           <li class="elements">
                              <a href="#sub-menu" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-play-circle-line"></i><span>Sách Kinh Tế</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                           </li>
                           <li class="elements">
                              <a href="#sub-menu" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-play-circle-line"></i><span>Sách Ngoại Ngữ</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                           </li>
                           <li class="elements">
                              <a href="#sub-menu" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-play-circle-line"></i><span>Sách Văn Học</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                           </li>                                                   
                        </ul>
                     </li>
                     <li><a href="/webbanhang/Product/favoriteList"><i class="ri-heart-line"></i>Yêu Thích</a></li>
                     <li><a href="/webbanhang/Product/cart2"><i class="ri-shopping-cart-2-line"></i>Giỏ hàng Cookie</a></li>
                     <?php
                     if (SessionHelper::isLoggedIn()) {
                        // Kiểm tra nếu người dùng là admin
                        if (in_array('admin', $_SESSION['roles'])) {
                              echo "<li><a href='/webbanhang/default/dashboard'>
                                       <i class='las la-house-damage'></i>Admin Dashboard
                                    </a></li>";
                        }
                     }
                     ?>
                  </ul>
               </nav>
            </div>
         </div>
         <!-- TOP Nav Bar -->
         <div class="iq-top-navbar">
            <div class="iq-navbar-custom">
               <nav class="navbar navbar-expand-lg navbar-light p-0">
                  <div class="iq-menu-bt d-flex align-items-center">
                     <div class="wrapper-menu">
                        <div class="main-circle"><i class="las la-bars"></i></div>
                     </div>
                     <div class="iq-navbar-logo d-flex justify-content-between">
                        <a href="/webbanhang" class="header-logo">
                           <img src="/webbanhang/public/images/logo.png" class="img-fluid rounded-normal" alt="">
                           <div class="logo-title">
                              <span class="text-primary text-uppercase">Trang Chủ</span>
                           </div>
                        </a>
                     </div>
                  </div>
                  <div class="navbar-breadcrumb">
                     <h5 class="mb-0">Trang Chủ</h5>
                  </div>
                  <!-- <div class="iq-search-bar">
                     <form action="#" class="searchbox">
                        <input type="text" class="text search-input" placeholder="Tìm kiếm sản phẩm...">
                        <a class="search-link" href="#">
                           <i class="ri-search-line"></i>
                        </a>
                     </form>
                  </div> -->
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"  aria-label="Toggle navigation">
                     <i class="ri-menu-3-line"></i>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <ul class="navbar-nav ml-auto navbar-list">
                        <li class="nav-item nav-icon search-content">
                           <a href="#" class="search-toggle iq-waves-effect text-gray rounded">
                              <i class="ri-search-line"></i>
                           </a>
                           <form action="#" class="search-box p-0">
                              <input type="text" class="text search-input" placeholder="Type here to search...">
                              <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                           </form>
                        </li>
                        <li class="nav-item nav-icon dropdown">
                           <a href="/webbanhang/Product/favoriteList" class="iq-waves-effect text-gray rounded">
                              <i class="ri-heart-line"></i>
                           </a>                           
                        </li>
                        <li class="nav-item nav-icon dropdown">
                           <a href="/webbanhang/Product/cart" class="iq-waves-effect text-gray rounded">
                              <i class="ri-shopping-cart-2-line"></i>
                              <!-- <span class="badge badge-danger count-cart rounded-circle">2</span> -->
                           </a>                           
                        </li>
                        <!-- <li class='nav-item nav-icon dropdown'>
                                       <a href='/webbanhang/Product/orderHistory' class='iq-waves-effect text-gray rounded'>
                                          <i class='las la-user iq-arrow-left'></i>                              
                                       </a>                           
                                    </li>
                                    <li class='nav-item  mt-4'>
                                       <a class='nav-link' href='/webbanhang/account/logout'>Logout</a>
                                    </li> -->
                        <li class="line-height pt-3">
                           <?php
                              if (SessionHelper::isLoggedIn()) {
                                 echo "
                                    <li class='line-height pt-3'>
                                       <a href='#' class='search-toggle iq-waves-effect d-flex align-items-center'><span class='ripple rippleEffect' style='width: 50px; height: 50px; top: 8px; left: 22px;'></span>
                                          <div class='caption'>
                                             <h6 class='mb-1 line-height mt-3'>Tài khoản</h6>
                                          </div>
                                       </a>
                                       <div class='iq-sub-dropdown iq-user-dropdown'>
                                          <div class='iq-card shadow-none m-0'>
                                             <div class='iq-card-body p-0 '>
                                                <div class='bg-primary p-3'>
                                                   <h5 class='mb-0 text-white line-height'>Xin chào</h5>
                                                </div>
                                                <a href='/webbanhang/Product/orderHistory' class='iq-sub-card iq-bg-primary-hover'>
                                                   <div class='media align-items-center'>
                                                      <div class='rounded iq-card-icon iq-bg-primary'>
                                                         <i class='ri-shopping-cart-2-line'></i>
                                                      </div>
                                                      <div class='media-body ml-3'>
                                                         <h6 class='mb-0 '>Lịch sử đơn hàng</h6>
                                                         <p class='mb-0 font-size-12'>Xem chi tiết đơn hàng của bạn.</p>
                                                      </div>
                                                   </div>
                                                </a>                           
                                                <div class='d-inline-block w-100 text-center p-3'>
                                                   <a class='bg-primary iq-sign-btn' href='/webbanhang/account/logout'>Đăng xuất<i class='ri-login-box-line ml-2'></i></a>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </li>";
                              } else {
                                 echo "<li class='nav-item  mt-4'>
                                          <a class='nav-link' href='/webbanhang/account/login'><strong>Đăng nhập</strong></a>
                                       </li>";
                              }
                              ?>                        
                        </li>    
                     </ul>
                  </div>
               </nav>
            </div>
         </div>
         <!-- TOP Nav Bar END -->
         <!-- Page Content  -->
         <div id="content-page" class="content-page">
            <div class="container-fluid">
               <div class="row">