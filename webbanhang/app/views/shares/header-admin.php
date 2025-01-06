<!doctype html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Admin Dashboard - NHASACH</title>
      <!-- Favicon -->
      <link rel="shortcut icon" href="/webbanhang/public/images/favicon.ico" />
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="/webbanhang/public/css/bootstrap.min.css">
      <link rel="stylesheet" href="/webbanhang/public/css/dataTables.bootstrap4.min.css">
      <!-- Typography CSS -->
      <link rel="stylesheet" href="/webbanhang/public/css/typography.css">
      <!-- Style CSS -->
      <link rel="stylesheet" href="/webbanhang/public/css/style.css">
      <!-- Responsive CSS -->
      <link rel="stylesheet" href="/webbanhang/public/css/responsive.css">      
   </head>
   <body>
      <!-- loader Start -->
      <div id="loading">
         <div id="loading-center">
         </div>
      </div>
      <!-- loader END -->
      <!-- Wrapper Start -->
      <div class="wrapper">
         <!-- Sidebar  -->
         <div class="iq-sidebar">
            <div class="iq-sidebar-logo d-flex justify-content-between">
               <a href="/webbanhang/default/dashboard" class="header-logo">
                  <img src="/webbanhang/public/images/logo.png" class="img-fluid rounded-normal" alt="">
                  <div class="logo-title mt-2">
                     <span class="text-primary text-uppercase">DASHBOARD</span>
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
                     <li><a href="/webbanhang/default/dashboard"><i class="las la-house-damage"></i>Bảng Điều Khiển</a></li>
                     <li><a href="/webbanhang/Category/list"><i class="ri-function-line"></i>Danh Mục Sách</a></li>
                     <li><a href="/webbanhang/Product/"><i class="ri-book-line"></i>Sách</a></li>
                     <li><a href="/webbanhang/Product/manageOrders"><i class="ri-shopping-cart-2-line"></i>Đơn hàng</a></li>
                     <li><a href="/webbanhang/account/manageRoles"><i class="las la-user iq-arrow-left"></i>Tài khoản</a></li>
                  </ul>
               </nav>
               <div id="sidebar-bottom" class="p-3 position-relative">
                  <div class="iq-card">
                     <div class="iq-card-body">
                        <div class="sidebarbottom-content">
                           <div class="image"><img src="/webbanhang/public/images/page-img/side-bkg.png" alt=""></div>                           
                           <button onclick="window.location.href='/webbanhang'" type="submit" class="btn w-100 btn-primary mt-4 view-more">
                              <i class="las la-home iq-arrow-left"></i>
                              NHA SACH
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
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
                        <a href="/webbanhang/default/dashboard" class="header-logo">
                           <img src="/webbanhang/public/images/logo.png" class="img-fluid rounded-normal" alt="">
                           <div class="logo-title">
                              <span class="text-primary text-uppercase">Trang Quản trị</span>
                           </div>
                        </a>
                     </div>
                  </div>
                  <div class="navbar-breadcrumb">
                     <h5 class="mb-0">Trang Quản Trị</h5>
                  </div>
                  <div class="iq-search-bar">
                     <form action="#" class="searchbox">
                        <input type="text" class="text search-input" placeholder="Tìm kiếm sản phẩm...">
                        <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                     </form>
                  </div>
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

                        <!-- USER -->
                        <li class="line-height pt-3">
                           <a href="#" class="search-toggle iq-waves-effect d-flex align-items-center">
                              <div class="caption">
                                 <p class="mb-0 text-primary" id="nav-logout">
                                    <a class='nav-link' href='/webbanhang/account/logout'><strong>Đăng xuất</strong></a>
                                 </p>
                              </div>
                           </a>                           
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
                    <div class="col-sm-12">
                        <div class="iq-card">
                            <!-- Nội dung trang -->