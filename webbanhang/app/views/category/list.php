<?php include 'app/views/shares/header-admin.php'; ?>


<div class="iq-card-header d-flex justify-content-between">
    <div class="iq-header-title">
        <h4 class="card-title">Danh sách danh mục</h4>
    </div>
    <div class="iq-card-header-toolbar d-flex align-items-center">
        <a href="/webbanhang/category/create" class="btn btn-primary">Thêm danh mục mới</a>
    </div>
</div>
<div class="iq-card-body">
    <div class="table-responsive">
        <table class="data-tables table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <!-- <th width="5%">STT</th> -->
                    <th width="20%">Tên danh mục</th>
                    <th width="65%">Mô tả danh mục</th>
                    <th width="10%">Hoạt động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <!-- <td>
                            < ?php echo htmlspecialchars($category->id, ENT_QUOTES, 'UTF-8'); ?>
                        </td> -->
                        <td>
                            <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                        <td>
                            <p class="mb-0">
                                <?php echo htmlspecialchars($category->description, ENT_QUOTES, 'UTF-8'); ?>
                            </p>
                        </td>
                        <td>
                            <div class="flex align-items-center list-user-action">
                                <a class="bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sửa" 
                                    href="/webbanhang/category/edit/<?php echo $category->id; ?>"><i class="ri-pencil-line"></i></a>
                                <a class="bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Xoá" 
                                    href="/webbanhang/category/delete/<?php echo $category->id; ?>"><i class="ri-delete-bin-line"></i></a>
                            </div>
                        </td>
                    </tr>                
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<?php include 'app/views/shares/footer.php'; ?>