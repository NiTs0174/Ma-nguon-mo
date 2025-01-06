<?php include 'app/views/shares/header.php'; ?>
<!--2.1 thêm yêu thích -->  

<h1>Sản phẩm yêu thích của bạn</h1>
<?php if (!empty($favorites)): ?>
    <ul class="list-group">
        <?php foreach ($favorites as $favorite): ?>
            <li class="list-group-item">
                <h2><?php echo htmlspecialchars($favorite['product']->name, ENT_QUOTES, 'UTF-8'); ?></h2>
                <img src="/webbanhang/<?php echo $favorite['product']->image; ?>" alt="Product Image" style="max-width: 100px;">
                <p><?php echo htmlspecialchars($favorite['product']->description, ENT_QUOTES, 'UTF-8'); ?></p>
                <p>Giá: <?php echo number_format($favorite['product']->price, 0, ',', '.'); ?> VND</p>
                <!-- Nút "Bỏ thích" -->
                <a href="/webbanhang/Product/removeFromFavoriteList/<?php echo $favorite['product']->id; ?>" class="btn btn-danger">
                    Bỏ thích
                </a>
            </li>
        <?php endforeach; ?>
    </ul>    
    
<?php else: ?>
    <p>Danh sách yêu thích của bạn hiện tại đang trống.</p>
<?php endif; ?>

<?php include 'app/views/shares/footer.php'; ?>