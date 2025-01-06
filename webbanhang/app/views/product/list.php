<?php include 'app/views/shares/header-admin.php'; ?>


<div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title">Danh sách sách</h4>
                           </div>
                           <div class="iq-card-header-toolbar d-flex align-items-center">
                              <a href="/webbanhang/Product/add" class="btn btn-primary">Thêm sách</a>
                           </div>
                        </div>
                        <div class="iq-card-body">
                           <div class="table-responsive">
                              <table class="data-tables table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width: 12%;">Hình ảnh</th>
                                        <th style="width: 15%;">Tên sách</th>
                                        <th style="width: 15%;">Thể loại sách</th>
                                        <th style="width: 18%;">Mô tả sách</th>
                                        <th style="width: 7%;">Giá</th>
                                        <th style="width: 15%;">Hoạt động</th>
                                    </tr>
                                </thead>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td>
                                            <!--2 Hiển thị hình ảnh sản phẩm -->
                                            <?php if ($product->image): ?>
                                                <img src="/webbanhang/<?php echo $product->image; ?>" class="card-img-top" alt="Image" style="max-height: auto; object-fit: cover;">
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" class="text-decoration-none text-dark">
                                                <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?>
                                        </td>
                                        <td>
                                            <p class="mb-0">
                                                <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?>
                                            </p>
                                        </td>
                                        <td>
                                            <?php echo number_format($product->price, 0, ',', '.'); ?> VND
                                        </td>                                    
                                        <td>
                                            <div class="flex align-items-center list-user-action">
                                                <a class="bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" 
                                                    href="/webbanhang/Product/edit/<?php echo $product->id; ?>"><i class="ri-pencil-line"></i></a>
                                                <a class="bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Xoá" 
                                                    href="/webbanhang/Product/delete/<?php echo $product->id; ?>"><i class="ri-delete-bin-line"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                           </div>
                        </div>


<?php include 'app/views/shares/footer.php'; ?>