<?php include 'app/views/shares/header-home.php'; ?>
<!-- 3 GIỎ HÀNG -->

<?php if (!empty($cart)): ?>
    <div id="cart" class="card-block show p-0 col-12">
        <div class="row align-item-center">
            <div class="col-lg-8">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between iq-border-bottom mb-0">
                        <div class="iq-header-title">
                            <h4 class="card-title">Giỏ hàng</h4>
                        </div>
                        <a href="/webbanhang" class="btn btn-outline-primary d-flex align-items-center">
                            <i class="ri-arrow-left-line mr-2"></i> Tiếp tục mua sắm
                        </a>
                    </div>
                    <div class="iq-card-body">                                
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
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="iq-card">
                    <div class="iq-card-body">                                 
                        <p><b>Chi tiết</b></p>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Tổng</span>
                            <span><?php echo number_format($total, 0, ',', '.'); ?> VND</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Phí vận chuyển</span>
                            <span class="text-success">Miễn phí</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="text-dark"><strong>Tổng</strong></span>
                            <span class="text-dark"><strong>
                                <?php echo number_format($total, 0, ',', '.'); ?> VND
                            </strong></span>
                        </div>
                        <a href="/webbanhang/Product/checkout" class="btn btn-primary d-block mt-3 next">Đặt hàng</a>
                    </div>
                </div>
                <div class="iq-card ">
                    <div class="card-body iq-card-body p-0 iq-checkout-policy">
                        <ul class="p-0 m-0">
                            <li class="d-flex align-items-center">
                                <div class="iq-checkout-icon">
                                    <i class="ri-checkbox-line"></i>
                                </div>
                                <h6>Chính sách bảo mật (Thanh toán an toàn và bảo mật.)</h6>
                            </li>
                            <li class="d-flex align-items-center">
                                <div class="iq-checkout-icon">
                                    <i class="ri-truck-line"></i>
                                </div>
                                <h6>Chính sách giao hàng (Giao hàng tận nhà.)</h6>
                            </li>
                            <li class="d-flex align-items-center">
                                <div class="iq-checkout-icon">
                                    <i class="ri-arrow-go-back-line"></i>
                                </div>
                                <h6>Chính sách hoàn trả</h6>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>     
    </div>
<?php else: ?>
    <div class="d-flex justify-content-center align-items-center" style="width: 200vh;">
        <div class="text-center">
            <p>Giỏ hàng của bạn đang trống.</p>                                    
            <a href="/webbanhang" class="btn btn-secondary">Tiếp tục mua sắm</a>
        </div>
    </div>
<?php endif; ?>

<?php include 'app/views/shares/footer.php'; ?>