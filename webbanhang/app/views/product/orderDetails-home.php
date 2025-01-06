<?php include 'app/views/shares/header-home.php'; ?>

<div class="col-sm-12">
                     <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title d-flex align-items-center">
                                <h4 class="card-title mb-0">Chi tiết đơn hàng #<?= htmlspecialchars($order['id']) ?></h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Tên khách hàng:</strong> <?= htmlspecialchars($order['name']) ?></p>
                                    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['phone']) ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['address']) ?></p>
                                    <p><strong>Ngày tạo:</strong> <?= htmlspecialchars($order['created_at']) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="table-responsive">
                            <h4 class="text-center mb-4">Sản phẩm</h4>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tên sản phẩm</th>
                                            <th>Số lượng</th>
                                            <th>Đơn giá</th>
                                            <th>Thành tiền</th>
                                        </tr>
                                    </thead>
                                 <tbody>
                                    <?php foreach ($orderDetails as $item): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($item['name']) ?></td>
                                            <td><?= htmlspecialchars($item['quantity']) ?></td>
                                            <td><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
                                            <td><?= number_format($item['subtotal'], 0, ',', '.') ?> VND</td>
                                        </tr>
                                    <?php endforeach; ?>
                                 </tbody>
                              </table>
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="text-center">                            
                                        <a href="/webbanhang/product/orderHistory" class="btn btn-secondary">Quay lại lịch sử đơn hàng</a>
                                    </div>
                                </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  
<?php include 'app/views/shares/footer.php'; ?>