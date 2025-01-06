<?php include 'app/views/shares/header-admin.php'; ?>


<div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title">Danh sách sách</h4>
                           </div>
                           <div class="iq-card-header-toolbar d-flex align-items-center">
                              <a href="/webbanhang/Product/add" class="btn btn-primary">Thêm sách</a>
                           </div>
                        </div>
                        <div class="iq-card-body">
                           <div class="table-responsive">
                              <table class="data-tables table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width: 12%;">Hình ảnh</th>
                                        <th style="width: 15%;">Tên sách</th>
                                        <th style="width: 15%;">Thể loại sách</th>
                                        <th style="width: 18%;">Mô tả sách</th>
                                        <th style="width: 7%;">Giá</th>
                                        <th style="width: 15%;">Hoạt động</th>
                                    </tr>
                                </thead>
                                <tbody id="product-list">

                                    <!-- Danh sách sản phẩm sẽ được tải từ API và hiển thị tại đây -->

                                </tbody>
                            </table>
                           </div>
                        </div>


<?php include 'app/views/shares/footer.php'; ?>

<!-- ------------------------------------------------------------------------------------------------------- -->
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