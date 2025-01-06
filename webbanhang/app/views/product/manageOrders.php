<?php include 'app/views/shares/header-admin.php'; ?>

<div class="col-sm-12">
                     <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title">Quản Lý Đơn Hàng</h4>
                           </div>
                           <div class="iq-card-header-toolbar d-flex align-items-center">
                              <div class="dropdown">
                                 <span class="dropdown-toggle text-primary" id="dropdownMenuButton5" data-toggle="dropdown">
                                 <i class="ri-more-fill"></i>
                                 </span>
                                 <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton5">
                                    <a class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>Xem</a>
                                    <a class="dropdown-item" href="#"><i class="ri-delete-bin-6-fill mr-2"></i>Xoá</a>
                                    <a class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Sửa</a>
                                    <a class="dropdown-item" href="#"><i class="ri-printer-fill mr-2"></i>In</a>
                                    <a class="dropdown-item" href="#"><i class="ri-file-download-fill mr-2"></i>Tải xuống</a>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="iq-card-body">
                           <div class="table-responsive">
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
                                                <a href="/webbanhang/Product/viewOrderDetails/<?= $order['id'] ?>">Chi tiết</a>
                                                <a href="/webbanhang/Product/deleteOrder/<?= $order['id'] ?>" 
                                                   onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');" 
                                                   style="color: red;">Xóa</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>                                    
                                 </tbody>
                              </table>
                              <!-- Hiển thị phân trang -->
                              <div class="d-flex justify-content-center">
                                 <div class="pagination">
                                    <?php if ($page > 1): ?>
                                       <a href="?page=1">|<</a>
                                       <a href="?page=<?= $page - 1 ?>" class="ml-2 mr-2">trước</a>
                                    <?php endif; ?>

                                    <span><?= $page ?> / <?= $totalPages ?></span>

                                    <?php if ($page < $totalPages): ?>
                                       <a href="?page=<?= $page + 1 ?>" class="ml-2 mr-2">sau</a>
                                       <a href="?page=<?= $totalPages ?>">>|</a>
                                    <?php endif; ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

<?php include 'app/views/shares/footer.php'; ?>