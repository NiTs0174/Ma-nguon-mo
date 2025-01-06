<?php include 'app/views/shares/header-home.php'; ?>


<div class="iq-card-body pb-0">
                           <div class="description-contens align-items-top row">
                              <div class="col-md-6">
                                 <div class="iq-card-transparent iq-card-block iq-card-stretch iq-card-height">
                                    <div class="iq-card-body p-0">
                                       <div class="row align-items-center">
                                          <div class="col-12">
                                            <img src="/webbanhang/public/images/book-dec/06.jpg" alt="Image" class="img-fluid">
                                            <!-- <img src="<?php echo $product->image; ?>" alt="<?php echo $product->name; ?>" class="img-fluid"> -->
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="iq-card-transparent iq-card-block iq-card-stretch iq-card-height">
                                    <div class="iq-card-body p-0">
                                       <h3 class="mb-3"><?php echo $product->name; ?></h3>
                                       <div class="price d-flex align-items-center font-weight-500 mb-2">
                                          <span class="font-size-24 text-dark"><?php echo number_format($product->price, 0, ',', '.'); ?> VND</span>
                                       </div>
                                       <span class="text-dark mb-4 pb-4 iq-border-bottom d-block"><?php echo $product->description; ?></span>
                                       <div class="text-primary mb-4">Danh mục: <span class="text-body"><?php echo $product->category_id; ?></span></div>
                                       <div class="mb-4 d-flex align-items-center">   
                                          <!--3.1 Cookie -->
                                          <a class="btn btn-primary view-more mr-2" href="/webbanhang/Product/addToCart2/<?php echo $product->id; ?>">
                                             <i class="ri-shopping-cart-2-fill text-white"></i> Mua ngay
                                          </a>
                                          <!--2.1 Nút yêu thích -->                    
                                          <?php if (isset($_SESSION['favorites'][$product->id])): ?>
                                             <a href="/webbanhang/Product/removeFromFavoriteList/<?php echo $product->id; ?>" class=" btn btn-primary view-moreml-2">
                                                <i class="ri-heart-fill text-warning"></i> Bỏ Thích
                                             </a>
                                          <?php else: ?>
                                             <a href="/webbanhang/Product/addToFavorite/<?php echo $product->id; ?>" class=" btn btn-primary view-moreml-2">
                                                <i class="ri-heart-fill text-danger"></i> Yêu thích
                                                </a>
                                          <?php endif; ?>
                                       </div>                              
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>


<?php include 'app/views/shares/footer.php'; ?>