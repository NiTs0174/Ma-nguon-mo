<?php include 'app/views/shares/header.php'; ?>
<!-- 4 XÁC THỰC -->

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        
                    <!-- <form action="/webbanhang/account/checklogin" method="post"> -->
                    <!--6 JWT -->
                    <form id="login-form">                          
                        <div class="mb-md-5 mt-md-4 pb-5">
                                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                <p class="text-white-50 mb-5">Please enter your login and password!</p>
                                <div class="form-outline form-white mb-4">
                                    <input type="text" name="username" class="form-control form-control-lg" />
                                    <label class="form-label" for="typeEmailX">UserName</label>
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <input type="password" name="password" class="form-control form-control-lg" />
                                    <label class="form-label" for="typePasswordX">Password</label>
                                </div>

                                <div class="form-check">
                                    <input type="checkbox" name="remember_me" class="form-check-input" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Ghi nhớ đăng nhập</label>
                                </div>

                                <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#!">Forgot password?</a></p>
                                <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                                <div class="d-flex justify-content-center text-center mt-4 pt-1">
                                    <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                                    <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
                                    <!--4.2 Thêm nút đăng nhập Google -->
                                    <a href="/google_login.php" class="text-white">
                                        <i class="fab fa-google fa-lg"></i> Đăng nhập với Google
                                    </a>            
                                </div>
                            </div>
                            <div>
                                <p class="mb-0">Don't have an account? <a href="
                                    /webbanhang/account/register " class="text-white-50 fw-bold">Sign Up</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php include 'app/views/shares/footer.php'; ?>

<!-- 6------------------------------- -->
<script>
document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    const jsonData = {};
    formData.forEach((value, key) => {
        jsonData[key] = value;
    });

    fetch('/webbanhang/account/checkLogin', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(jsonData)
    })
    .then(response => response.json())
    .then(data => {
        
        if (data.token) {
            localStorage.setItem('jwtToken', data.token);
            location.href = '/webbanhang/Product';
        } else {
            alert('Đăng nhập thất bại');
        }
    });
});
</script>