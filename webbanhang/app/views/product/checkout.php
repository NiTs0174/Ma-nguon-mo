<?php include 'app/views/shares/header-home.php'; ?>
<!-- 3 GIỎ HÀNG -->

                <div class="card-block show p-0 col-12">
                    <div class="row justify-content-center">
                        <div class="col-lg-8"></div>
                            <div class="iq-card">
                                <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                        <h4 class="card-title">Thông tin nhận hàng</h4>
                                    </div>
                                </div>
                                <div class="iq-card-body">
                                    <form method="POST" action="/webbanhang/Product/processCheckout">
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Họ và tên: *</label> 
                                                    <input type="text" id="name" name="name" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    <label>Số điện thoại: *</label> 
                                                    <input type="text" id="phone" name="phone" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group"> 
                                                    <label>Địa chỉ: *</label> 
                                                    <textarea id="address" name="address" class="form-control" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12 d-flex justify-content-center">                                                                                
                                                <button type="submit" class="btn btn-primary mr-2">Xác nhận</button>
                                                <a href="/webbanhang/Product/cart" class="btn btn-secondary">Quay lại</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<?php include 'app/views/shares/footer.php'; ?>