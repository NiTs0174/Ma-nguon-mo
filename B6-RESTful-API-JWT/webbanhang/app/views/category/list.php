<?php include 'app/views/shares/header.php'; ?>


<h1>Danh sách thể loại</h1>
<a href="/webbanhang/category/create" class="btn btn-success mb-2">Thêm thể loại mới</a>

<ul class="list-group">
    <?php foreach ($categories as $category): ?>
        <li class="list-group-item">
            <h2>
                <!-- <a href="/webbanhang/category/show/< ?php echo $category->id; ?>"> -->
                    <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                </a>
            </h2>
            <p><?php echo htmlspecialchars($category->description, ENT_QUOTES, 'UTF-8'); ?></p>
            <a href="/webbanhang/category/edit/<?php echo $category->id; ?>" class="btn btn-warning">Sửa</a>
            <a href="/webbanhang/category/delete/<?php echo $category->id; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa thể loại này và tất cả sách thuộc thể loại này?');">Xóa</a>
        </li>
    <?php endforeach; ?>
</ul>


<?php include 'app/views/shares/footer.php'; ?>