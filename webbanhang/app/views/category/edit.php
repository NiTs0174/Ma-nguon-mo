<?php include 'app/views/shares/header-admin.php'; ?>


                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title">Sửa danh mục</h4>
                           </div>
                        </div>

                        <div class="iq-card-body">
                           <form method="POST">
                              <div class="form-group">
                                 <label for="name">Tên danh mục:</label>
                                 <input type="text" name="name" id="name" class="form-control" value="<?php echo $category->name; ?>" required>
                              </div>
                              <div class="form-group">
                                 <label for="description">Mô tả:</label>
                                 <textarea name="description" id="description" class="form-control" required><?php echo $category->description; ?></textarea>
                              </div>
                              <button type="submit" class="btn btn-primary">Lưu</button>
                              <a href="/webbanhang/category/list" class="btn btn-danger">Quay lại</a> 
                           </form>
                        </div>

    
<?php include 'app/views/shares/footer.php'; ?>