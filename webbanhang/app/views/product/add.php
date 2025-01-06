<?php include 'app/views/shares/header-admin.php'; ?>


<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title">Thêm sách</h4>
                           </div>
                        </div>
                        <div class="iq-card-body">
                           <form method="POST" action="/webbanhang/Product/save" enctype="multipart/form-data" onsubmit="return validateForm();">
                                <div class="form-group">                                 
                                    <label for="name">Tên sách:</label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                </div>
                                <div class="form-group">                                 
                                    <label for="category_id">Danh mục:</label>
                                    <select id="category_id" name="category_id" class="form-control" required>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo $category->id; ?>"><?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <!--2 thêm ảnh -->
                                <div class="form-group">
                                    <label for="image">Hình ảnh:</label>
                                    <input type="file" id="image" name="image" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="price">Giá:</label>
                                    <input type="number" id="price" name="price" class="form-control" step="0.01" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Mô tả:</label>
                                    <textarea id="description" name="description" class="form-control" rows="4" accesskey=""actionrequired></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Thêm</button>
                                <a href="/webbanhang/Product" type="reset" class="btn btn-danger">Quay lại</a>
                            </form>
                        </div>


<?php include 'app/views/shares/footer.php'; ?>