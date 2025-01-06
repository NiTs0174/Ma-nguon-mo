<?php include 'app/views/shares/header.php'; ?>


<h1>Danh sách sản phẩm</h1>
<a href="/webbanhang/Product/add" class="btn btn-success mb-2">Thêm sản phẩm mới</a>
<ul class="list-group">
    <?php foreach ($products as $product): ?>
        <li class="list-group-item">
            <h2>
                <a href="/webbanhang/Product/show/<?php echo $product->id; ?>">
                    <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                </a>
            </h2>
            
            <!--2 hiển thị ảnh -->
            <?php if ($product->image): ?>
                <img src="/webbanhang/<?php echo $product->image; ?>" alt="Product Image" style="max-width: 100px;">
            <?php endif; ?>
            <p><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></p>
            <p>Giá: <?php echo number_format($product->price, 0, ',', '.'); ?> VND</p>
            <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning">Sửa</a>
            <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
            <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>"
            class="btn btn-primary">Thêm vào giỏ hàng</a>
            
            <!--2.5 thêm yêu thích -->            
            <!-- Kiểm tra sản phẩm đã có trong danh sách yêu thích chưa -->
            <?php if (isset($_SESSION['favorites'][$product->id])): ?>
                <!-- Nếu đã thích, hiển thị nút "Bỏ thích" -->
                <a href="/webbanhang/Product/removeFromFavorite/<?php echo $product->id; ?>" class="btn btn-secondary">
                    Bỏ thích
                </a>
            <?php else: ?>
                <!-- Nếu chưa thích, hiển thị nút "Thích" -->
                <a href="/webbanhang/Product/addToFavorite/<?php echo $product->id; ?>" class="btn btn-secondary">
                    Thích
                </a>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>


<?php include 'app/views/shares/footer.php'; ?>