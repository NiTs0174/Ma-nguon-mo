<?php include 'app/views/shares/header-home.php'; ?>

<style>
   .searchbox {
    display: flex;
    align-items: center;
    width: 100%;
}

.searchbox .search-input {
    flex: 1;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

.searchbox .search-data {
    padding: 10px 15px;
    margin-left: 10px;
    border-radius: 5px;
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
}

.searchbox .search-data:hover {
    background-color: #0056b3;
}
</style>

<div class="col-lg-12">
                     <div class="iq-card-transparent mb-0">
                        <div class="d-block text-center">
                           <div class="w-100 iq-search-filter">
                              <ul class="list-inline p-0 m-0 row justify-content-center search-menu-options">
                                 <!-- TÌM KIẾM -->
                                 <li class="search-menu-opt">
                                    <div class="iq-search-bar search-book d-flex align-items-center">
                                    <form action="" method="GET" class="searchbox">
                                       <input type="text" class="text search-input" name="search" placeholder="Tìm tên sách..." value="<?php echo htmlspecialchars($keyword); ?>">
                                       <button type="submit" class="btn btn-primary search-data ml-2"><i class="ri-search-line"></i></button>
                                    </form>
                                    </div>
                                 </li>
                              </ul>
                           </div> 
                        </div>
                     </div>
                     <div class="iq-card">
                        <div class="iq-card-body">
                        <div class="row">
                           <?php if (!empty($products)): ?>
                              <?php foreach ($products as $product): ?>
                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                       <div class="iq-card iq-card-block iq-card-stretch iq-card-height search-bookcontent m-0 mb-sm-0 mb-md-0 mb-lg-0">
                                          <div class="iq-card-body p-0">
                                                <div class="d-flex align-items-center">
                                                   <div class="col-6 p-0 position-relative image-overlap-shadow">
                                                      <a href="javascript:void();"><img class="img-fluid rounded w-100" src="<?php echo htmlspecialchars($product->image); ?>" alt="Image"></a>
                                                      <div class="view-book">
                                                         <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" class="btn btn-sm btn-white">Chi tiết</a>
                                                      </div>
                                                   </div>
                                                   <div class="col-6">
                                                      <h6 class="mb-1"><?php echo htmlspecialchars($product->name); ?></h6>
                                                      <p class="font-size-13"><?php echo htmlspecialchars($product->description); ?></p>
                                                      <h6><b><?php echo number_format($product->price, 0, ',', '.'); ?> VND</b></h6>                                                   
                                                      <div class="iq-product-action">
                                                         <!--3 Nút thêm vào giỏ hàng -->
                                                         <!--3 SEESION -->
                                                         <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>">
                                                            <i class="ri-shopping-cart-2-fill text-primary"></i>
                                                         </a>
                                                         <!--3.1 COOKIE -->
                                                         <!-- <a href="/webbanhang/Product/addToCart2/< ?php echo $product->id; ?>">
                                                            <i class="ri-shopping-cart-2-fill text-primary"></i>
                                                         </a> -->
                                                         <!--2.1 Nút yêu thích -->                    
                                                         <?php if (isset($_SESSION['favorites'][$product->id])): ?>
                                                            <a href="/webbanhang/Product/removeFromFavoriteList/<?php echo $product->id; ?>" class="ml-2 btn btn-secondary">
                                                               <i class="ri-heart-fill text-warning"></i>
                                                               Đã thích
                                                            </a>
                                                         <?php else: ?>
                                                            <a href="/webbanhang/Product/addToFavorite/<?php echo $product->id; ?>" class="ml-2 btn btn-secondary">
                                                               <i class="ri-heart-fill text-danger"></i>
                                                               Yêu thích
                                                            </a>
                                                         <?php endif; ?>
                                                      </div>
                                                   </div>
                                                </div>
                                          </div>
                                       </div>
                                    </div>
                              <?php endforeach; ?>
                           <?php else: ?>
                              <div class="d-flex justify-content-center align-items-center" style="width: 200vh;">
                                 <div class="text-center">            
                                    <p>Không tìm thấy sản phẩm.</p>
                                 </div>
                              </div>                             
                           <?php endif; ?>
                        </div>
                        <hr />
                        <!-- PHÂN TRANG -->
                        <nav aria-label="Page navigation">
                           <ul class="pagination justify-content-center">
                              <?php if ($page > 1): ?>
                                    <li class="page-item"><a class="page-link" href="?search=<?php echo urlencode($keyword); ?>&page=<?php echo $page - 1; ?>">Trước</a></li>
                              <?php endif; ?>

                              <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                       <a class="page-link" href="?search=<?php echo urlencode($keyword); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                              <?php endfor; ?>

                              <?php if ($page < $totalPages): ?>
                                    <li class="page-item"><a class="page-link" href="?search=<?php echo urlencode($keyword); ?>&page=<?php echo $page + 1; ?>">Sau</a></li>
                              <?php endif; ?>
                           </ul>
                        </nav>
                     </div>
                  </div>

<?php include 'app/views/shares/footer.php'; ?>