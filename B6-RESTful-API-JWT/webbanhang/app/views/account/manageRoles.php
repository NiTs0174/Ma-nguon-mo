<?php include 'app/views/shares/header.php'; ?>
<!-- 4.1 XÁC THỰC - QUẢN LÝ ROLE -->

<h1>Quản lý Vai Trò cho Tài Khoản</h1>
<?php if (isset($error)): ?>
    <div class="alert alert-danger">
        <?= $error; ?>
    </div>
<?php endif; ?>

<!-- Bảng danh sách tài khoản và vai trò -->
<table class="table table-striped">
    <thead>
        <tr>
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
                                <!-- <div class="form-check">
                                    <input type="checkbox" name="roles[]" value="editor" class="form-check-input" < ?= in_array('editor', $currentRoles) ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Editor</label>
                                </div> -->
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

<?php include 'app/views/shares/footer.php'; ?>