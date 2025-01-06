# Web Bán Hàng - E-commerce Website

Chào mừng bạn đến với dự án **Web Bán Hàng**. Đây là một hệ thống thương mại điện tử hoàn chỉnh được xây dựng bằng PHP, sử dụng MVC (Model-View-Controller) pattern. Dự án này cung cấp các chức năng cơ bản của một website bán hàng, bao gồm quản lý sản phẩm, danh mục, giỏ hàng, và xử lý đơn hàng.

## Nội Dung

- [Giới Thiệu](#giới-thiệu)
- [Cài Đặt](#cài-đặt)
- [Sử Dụng](#sử-dụng)
- [API](#api)
- [Cấu Trúc Dự Án](#cấu-trúc-dự-án)
- [Bảo Mật](#bảo-mật)
- [Giấy Phép](#giấy-phép)

## Giới Thiệu

Web Bán Hàng là một ứng dụng web e-commerce cho phép người dùng mua sắm sản phẩm, thêm vào giỏ hàng, và thanh toán. Hệ thống hỗ trợ quản lý sản phẩm, danh mục sản phẩm, giỏ hàng và đơn hàng. Các API RESTful cũng được cung cấp cho việc tích hợp bên ngoài.

## Cài Đặt

### Yêu Cầu

- PHP >= 7.4
- MySQL hoặc MariaDB (Laragon)
- Composer (để cài đặt các thư viện PHP)

### Hướng Dẫn Cài Đặt

1. **Clone dự án về máy tính của bạn**:

    ```bash
    git clone https://github.com/thangnguyen/webbanhang.git
    cd webbanhang
    ```

2. **Cài đặt các phụ thuộc**:

    Sử dụng Composer để cài đặt các thư viện PHP cần thiết:

    ```bash
    composer install
    ```

3. **Cấu hình môi trường**:

    Tạo một bản sao của tệp `.env.example` và đổi tên thành `.env`, sau đó chỉnh sửa các thông tin cấu hình kết nối cơ sở dữ liệu:

    ```bash
    cp .env.example .env
    ```

    Cập nhật thông tin kết nối trong file `.env`.

4. **Cài đặt cơ sở dữ liệu**:

    Tạo cơ sở dữ liệu và chạy các migration (nếu có) để tạo bảng dữ liệu:

    ```bash
    php artisan migrate
    ```

5. **Chạy ứng dụng**:

    Khởi chạy máy chủ PHP:

    ```bash
    php -S localhost:8000 -t public
    ```

6. Truy cập website qua địa chỉ: [http://localhost:3306](http://localhost:3306)

## Sử Dụng

### Người Dùng

- Đăng ký tài khoản
- Đăng nhập và xem sản phẩm
- Thêm sản phẩm vào giỏ hàng và thanh toán
- Quản lý thông tin cá nhân

### Quản Trị Viên

- Quản lý danh mục sản phẩm
- Thêm, sửa, xóa sản phẩm
- Xem và quản lý đơn hàng

## API

### Endpoint

- `GET /api/products`: Lấy danh sách sản phẩm
- `GET /api/products/{id}`: Lấy thông tin chi tiết sản phẩm theo ID
- `POST /api/products`: Thêm mới sản phẩm
- `PUT /api/products/{id}`: Cập nhật sản phẩm
- `DELETE /api/products/{id}`: Xóa sản phẩm

Các endpoint API này có thể được sử dụng để tích hợp với các hệ thống khác.

## Cấu Trúc Dự Án

Dưới đây là cấu trúc thư mục chính của dự án:

WEBBANHANG/
│
├── app/
│   ├── config/
│   │   └── database.php
│   ├── controllers/
│   │   ├── AccountController.php
│   │   ├── CategoryApiController.php
│   │   ├── CategoryController.php
│   │   ├── DefaultController.php
│   │   └── ProductController.php
│   ├── helpers/
│   │   └── SessionHelper.php
│   ├── models/
│   │   ├── AccountModel.php
│   │   ├── CategoryModel.php
│   │   └── ProductModel.php
│   └── views/
│       ├── account/
│       │   ├── login.php
│       │   ├── manageRoles.php
│       │   └── register.php
│       ├── api/
│       │   ├── add.php
│       │   ├── edit.php
│       │   └── list.php
│       ├── category/
│       │   ├── create.php
│       │   └── edit.php
│       ├── product/
│       │   ├── add.php
│       │   ├── cart.php
│       │   ├── cart2.php
│       │   ├── checkout.php
│       │   ├── edit.php
│       │   ├── favorites.php
│       │   ├── list.php
│       │   └── orderConfirmation.php
│       ├── shares/
│       │   ├── footer.php
│       │   └── header.php
│       └── show.php
├── public/
│   ├── css/
|   ├── images/
│   └── js/
├── uploads/
├── .gitignore
├── .htaccess
├── index.php
└── README.md

## Bảo Mật

- Đảm bảo rằng các tệp như `.env` chứa thông tin nhạy cảm không được đẩy lên Git. Các tệp này phải được thêm vào `.gitignore`.
- Cấu hình HTTPS trên máy chủ để bảo mật dữ liệu khi truyền tải qua mạng.
- Sử dụng cơ chế xác thực bảo mật cho API như JWT (JSON Web Tokens).
- Kiểm tra và xử lý các lỗ hổng bảo mật phổ biến như SQL Injection, XSS, CSRF.

## Giấy Phép

Dự án này được cấp phép dưới Giấy phép MIT. Xem tệp [LICENSE](LICENSE) để biết chi tiết.
