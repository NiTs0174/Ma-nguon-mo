<?php include 'app/views/shares/header-admin.php'; ?>
<!-- 4.1 XÁC THỰC - QUẢN LÝ ROLE -->

<?php if (isset($error)): ?>
    <div class="alert alert-danger">
        <?= $error; ?>
    </div>
<?php endif; ?>

<div class="iq-card-header d-flex justify-content-between">
    <div class="iq-header-title">
        <h4 class="card-title">Quản lý Vai Trò cho Tài Khoản</h4>
    </div>
</div>

<div class="iq-card-body">
    <div class="table-responsive">
        <!-- Bảng danh sách tài khoản và vai trò -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên Tài Khoản</th>
                    <th scope="col">Vai Trò</th>
                    <th scope="col">Cập Nhật Vai Trò</th>
                    <th scope="col">Xóa Vai Trò</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($accounts as $account): ?>
                    <?php 
                    // Lấy vai trò của tài khoản
                    $currentRoles = $this->accountModel->getRolesByAccountId($account['id']);
                    ?>
                    <tr>
                        <td><?= $account['id']; ?></td>
                        <td><?= $account['username']; ?></td>
                        <td>
                            <!-- Hiển thị vai trò hiện tại của tài khoản -->
                            <ul>
                                <?php foreach ($currentRoles as $role): ?>
                                    <li><?= ucfirst($role); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                        <td>
                            <form action="/webbanhang/account/assignRole" method="post">
                                <input type="hidden" name="username" value="<?= $account['username']; ?>">
                                <div>
                                    <label for="roles">Chọn vai trò:</label>
                                    <div>
                                        <div class="form-check">
                                            <input type="checkbox" name="roles[]" value="admin" class="form-check-input" <?= in_array('admin', $currentRoles) ? 'checked' : ''; ?>>
                                            <label class="form-check-label">Admin</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="roles[]" value="user" class="form-check-input" <?= in_array('user', $currentRoles) ? 'checked' : ''; ?>>
                                            <label class="form-check-label">User</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-2">Cập nhật vai trò</button>
                            </form>
                        </td>
                        <td>
                            <!-- Xóa vai trò -->
                            <?php foreach ($currentRoles as $role): ?>
                                <a href="/webbanhang/account/removeRole?username=<?= $account['username']; ?>&role=<?= $role; ?>" class="btn btn-danger btn-sm">Xóa <?= ucfirst($role); ?></a>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>