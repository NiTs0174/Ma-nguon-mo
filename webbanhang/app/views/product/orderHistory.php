<?php include 'app/views/shares/header-home.php'; ?>

<div class="col-sm-12">
                     <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title">Lịch Sử Đơn Hàng</h4>
                           </div>
                        </div>
                        <div class="iq-card-body">
                           <div class="table-responsive">
                            <?php if (!empty($orders)): ?>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Mã đơn hàng</th>
                                            <th>Tên khách hàng</th>
                                            <th>Số điện thoại</th>
                                            <th>Địa chỉ</th>
                                            <th>Ngày tạo</th>
                                            <th>Tổng tiền</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orders as $order): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($order['id']) ?></td>
                                                <td><?= htmlspecialchars($order['name']) ?></td>
                                                <td><?= htmlspecialchars($order['phone']) ?></td>
                                                <td><?= htmlspecialchars($order['address']) ?></td>
                                                <td><?= htmlspecialchars($order['created_at']) ?></td>
                                                <td><?= number_format($order['total'], 0, ',', '.') ?> VND</td>
                                                <td>
                                                    <a href="/webbanhang/Product/orderDetails/<?= $order['id'] ?>">Chi tiết</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="text-center">
                                        <p>Bạn chưa có đơn hàng nào.</p>                               
                                        <a href="/webbanhang" class="btn btn-secondary">Tiếp tục mua sắm</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                           </div>
                        </div>
                     </div>
                  </div>

<?php include 'app/views/shares/footer.php'; ?>