<?php include 'app/views/shares/header-home.php'; ?>
<!--2.1 thêm yêu thích -->  

                    <div class="col-lg-12">
                        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                            <div class="iq-card-header d-flex justify-content-between align-items-center position-relative">
                                <div class="iq-header-title">
                                    <h4 class="card-title mb-0">Sách yêu thích</h4>
                                </div>
                                <div class="iq-card-header-toolbar d-flex align-items-center">                              
                                    <a href="/webbanhang" class="btn btn-sm btn-primary view-more">Xem Thêm</a>
                                </div>
                            </div> 
                            <div class="iq-card-body">  
                                <div class="row">   
                                    <?php if (!empty($favorites)): ?>
                                        <?php foreach ($favorites as $favorite): ?>
                                            <div class="col-sm-6 col-md-4 col-lg-3">
                                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height browse-bookcontent mb-0 mb-sm-0 mb-md-0 mb-lg-0">
                                                    <div class="iq-card-body p-0">
                                                    <div class="d-flex align-items-center">
                                                        <div class="col-6 p-0 position-relative image-overlap-shadow">
                                                            <a href="javascript:void();"><img class="img-fluid rounded w-100" src="/webbanhang/<?php echo $favorite['product']->image; ?>" alt="Image"></a>
                                                            <div class="view-book">
                                                                <a href="/webbanhang/Product/show/<?php echo $favorite['product']->id; ?>" class="btn btn-sm btn-white">Chi tiết</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mb-2">
                                                                <h6 class="mb-1"><?php echo htmlspecialchars($favorite['product']->name, ENT_QUOTES, 'UTF-8'); ?></h6>
                                                                <p class="font-size-13 line-height mb-1"><?php echo htmlspecialchars($favorite['product']->description, ENT_QUOTES, 'UTF-8'); ?></p>
                                                            </div>
                                                            <div class="price d-flex align-items-center">
                                                                <h6><b><?php echo number_format($favorite['product']->price, 0, ',', '.'); ?> VND</b></h6>
                                                            </div>
                                                            <div class="iq-product-action">
                                                                <a href="/webbanhang/Product/addToCart/<?php echo $favorite['product']->id; ?>">
                                                                    <i class="ri-shopping-cart-2-fill text-primary"></i>
                                                                </a>
                                                                <a href="/webbanhang/Product/removeFromFavoriteList/<?php echo $favorite['product']->id; ?>" class="btn btn-secondary">
                                                                    <i class="ri-heart-fill text-warning"></i>
                                                                    Bỏ thích
                                                                </a>
                                                            </div>                                      
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-center" style="width: 200vh;">
                                        <p>Danh sách yêu thích của bạn hiện tại đang trống.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>     

<?php include 'app/views/shares/footer.php'; ?>