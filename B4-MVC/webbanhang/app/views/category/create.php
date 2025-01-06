<?php include 'app/views/shares/header.php'; ?>


    <h1>Thêm thể loại mới</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Tên Thể loại</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Thêm thể loại</button>
        </form>

    <a href="/webbanhang/category/list" class="btn btn-secondary mt-2">Quay lại danh sách</a> 


<?php include 'app/views/shares/footer.php'; ?>