<?php include 'app/views/shares/header.php'; ?>


<h1 class="text-center mb-4">Danh sách sản phẩm</h1>
<!-- Nút Thêm sản phẩm -->
<div class="text-right mb-3">
    <a href="/webbanhang/Product/add" class="btn btn-success">Thêm sản phẩm mới</a>
</div>

<!-- 6 API - JWT -->
<!-- <ul class="list-group" id="product-list"> -->
    <!-- Danh sách sản phẩm sẽ được tải từ API và hiển thị tại đây -->
<!-- </ul> -->

<!-- Danh sách sản phẩm -->
<div class="row">
    <?php foreach ($products as $product): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <!--2 Hiển thị hình ảnh sản phẩm -->
                <?php if ($product->image): ?>
                    <img src="/webbanhang/<?php echo $product->image; ?>" class="card-img-top" alt="Product Image" style="max-height: 200px; object-fit: cover;">
                <?php endif; ?>
                
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" class="text-decoration-none text-dark">
                            <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </h5>
                    <p class="card-text"><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></p>
                    <p class="font-weight-bold">
                        Giá: <?php echo number_format($product->price, 0, ',', '.'); ?> VND
                    </p>

                    <!-- Nút hành động -->
                    <div class="d-flex justify-content-between">                        
                        <div class="mt-2 text-center">                        
                            <!-- Nút sửa -->
                            <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning btn-sm">Sửa</a>
                            
                            <!-- Nút xóa -->
                            <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                        
                            <!--2.1 Nút yêu thích -->                    
                            <?php if (isset($_SESSION['favorites'][$product->id])): ?>
                                <a href="/webbanhang/Product/removeFromFavorite/<?php echo $product->id; ?>" class="btn btn-secondary btn-sm">
                                    Bỏ thích
                                </a>
                            <?php else: ?>
                                <a href="/webbanhang/Product/addToFavorite/<?php echo $product->id; ?>" class="btn btn-secondary btn-sm">
                                    Thích
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!--3 Nút thêm vào giỏ hàng -->
                    <div class="mt-2">
                        <!--3 SEESION -->
                        <!-- <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-primary btn-block">Thêm vào giỏ hàng (SEESION)</a> -->
                            <!--3.1 COOKIE -->
                            <a href="/webbanhang/Product/addToCart2/<?php echo $product->id; ?>" class="btn btn-primary btn-block mt-2">
                                <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng (Cookie)
                            </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<?php include 'app/views/shares/footer.php'; ?>

<!-- 6---------------------------------------- -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const token = localStorage.getItem('jwtToken');
    if (!token) {
        alert('Vui lòng đăng nhập');
        location.href = '/webbanhang/account/login'; // Điều hướng đến trang đăng nhập
        return;
    }
    fetch('/webbanhang/api/product', {
        method: 'GET',
        headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + token
        }
    })
        .then(response => response.json())
        .then(data => {
            const productList = document.getElementById('product-list');
            productList.innerHTML = ''; // Xóa dữ liệu cũ (nếu có)
            data.forEach((product, index) => {
                const row = `
                    <tr>
                        <td><img class="img-fluid rounded" src="/webbanhang/${product.image}" alt="${product.name}"></td>
                        <td><a href="/webbanhang/Product/show/${product.id}">${product.name}</a></td>
                        <td>${product.category_name}</td>
                        <td>
                            <p class="mb-0">${product.description}</p>
                        </td>
                        <td>${product.price}</td>                                    
                        <td>
                            <div class="flex align-items-center list-user-action">
                                <a class="bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" 
                                    href="/webbanhang/Product/edit/${product.id}"><i class="ri-pencil-line"></i></a>
                                <button class="bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Xoá" 
                                    onclick="deleteProduct(${product.id})"><i class="ri-delete-bin-line"></i></button>
                            </div>
                        </td>
                    </tr>
                `;
                productList.insertAdjacentHTML('beforeend', row);
            });
        });
});

function deleteProduct(id) {
    if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
        fetch(`/webbanhang/api/product/${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Product deleted successfully') {
                location.reload();
            } else {
                alert('Xóa sản phẩm thất bại');
            }
        });
    }
}
</script>