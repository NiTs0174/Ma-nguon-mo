<?php include 'app/views/shares/header.php'; ?>


    <h1>Chi tiết Sản phẩm</h1>        
        <div class="card mb-4">
            <div class="card-header">
                <h5><?php echo $product->name; ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <!--2 Hiển thị ảnh sản phẩm -->
                        <img src="/uploads/<?php echo $product->image; ?>" alt="<?php echo $product->name; ?>" class="img-fluid">
                    </div>
                    <div class="col-md-6">
                        <p><strong>Mô tả:</strong> <?php echo $product->description; ?></p>
                        <p><strong>Giá:</strong> <?php echo number_format($product->price, 0, ',', '.'); ?> VND</p>
                        <p><strong>Danh mục:</strong> <?php echo $product->category_id; ?></p>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="/webbanhang/product" class="btn btn-secondary">Quay lại danh sách</a>
            </div>
        </div>


<?php include 'app/views/shares/footer.php'; ?>