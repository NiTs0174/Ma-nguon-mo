<?php include 'app/views/shares/header.php'; ?>
<!-- 3 GIỎ HÀNG -->

<h1>Giỏ hàng</h1>
<?php if (!empty($cart)): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total = 0; // Biến lưu tổng giá trị giỏ hàng
            foreach ($cart as $id => $item): 
                $itemTotal = $item['price'] * $item['quantity']; // Thành tiền của sản phẩm
                $total += $itemTotal; 
            ?>
                <tr>
                    <td>
                        <?php if ($item['image']): ?>
                            <img src="/webbanhang/<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Product Image" style="max-width: 100px;">
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
                    <td>
                        <form action="/webbanhang/Product/updateCartQuantity1/<?php echo $id; ?>" method="post" class="d-inline">
                            <input type="number" name="quantity" value="<?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?>" min="1" style="width: 60px;">
                            <button type="submit" class="btn btn-primary btn-sm">Cập nhật</button>
                        </form>
                    </td>
                    <td><?php echo number_format($itemTotal, 0, ',', '.'); ?> VND</td>
                    <td>
                        <a href="/webbanhang/Product/removeFromCart1/<?php echo $id; ?>" class="btn btn-danger btn-sm">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="mt-4">
        <h3>Tổng giá trị: <?php echo number_format($total, 0, ',', '.'); ?> VND</h3>
    </div>
    <div class="mt-4">
        <a href="/webbanhang/Product" class="btn btn-secondary">Tiếp tục mua sắm</a>
        <a href="/webbanhang/Product/checkout" class="btn btn-success">Thanh Toán</a>
    </div>

<?php else: ?>
    <p>Giỏ hàng của bạn đang trống.</p>
    <a href="/webbanhang/Product" class="btn btn-secondary">Tiếp tục mua sắm</a>
<?php endif; ?>

<?php include 'app/views/shares/footer.php'; ?>