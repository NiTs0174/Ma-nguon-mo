<?php include 'app/views/shares/header-HOME.php'; ?>
<!-- 4 XÁC THỰC -->

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

                <div class="col-sm-12 align-self-center page-content rounded">
                    <div class="row m-0">
                        <div class="col-sm-12 sign-in-page-data">
                            <div class="sign-in-from bg-primary rounded">
                                <h3 class="mb-0 text-center text-white">Sign in</h3>
                                <p class="text-center text-white">Enter your email address and password to access admin panel.</p>

                                <form action="/webbanhang/account/checklogin" method="post">
                                <!--6 JWT -->
                                <!-- <form id="login-form"> -->
                                    <div class="form-group">
                                        <label for="typeEmailX">Email</label>
                                        <input type="text" name="username" class="form-control mb-0" id="exampleInputEmail1" placeholder="Enter email">
                                    </div>
                                    <div class="form-group">
                                        <label for="typePasswordX">Password</label>
                                        <input type="password" name="password" class="form-control mb-0" id="exampleInputPassword1" placeholder="******">
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="remember_me" class="form-check-input" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe">Remember me</label>
                                    </div>
                                    <div class="sign-info text-center">
                                        <button type="submit" class="btn btn-white d-block w-100 mb-2">Sign in</button>
                                        <span class="text-dark dark-color d-inline-block line-height-2">Don't have an account? 
                                            <a href="/webbanhang/account/register" class="text-white">Sign up</a>
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-center text-center mt-4 pt-1">
                                        <!--4.2 Thêm nút đăng nhập Google -->
                                        <!-- <a href="/google_login.php" class="text-white">
                                            <i class="fab fa-google fa-lg"></i> Đăng nhập với Google
                                        </a>             -->
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

<?php include 'app/views/shares/footer.php'; ?>

<!-- ------------------------------------------------------------------------------------------------------- -->
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