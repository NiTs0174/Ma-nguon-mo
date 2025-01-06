<?php include 'app/views/shares/header-home.php'; ?>
<!-- 4 XÁC THỰC -->

<?php
    if (isset($errors)) {
        echo "<ul>";
        foreach ($errors as $err) {
            echo "<li class='text-danger'>$err</li>";
        }
        echo "</ul>";
    }
?>

                <div class="col-sm-12 align-self-center page-content rounded">
                    <div class="row m-0">
                        <div class="col-sm-12 sign-in-page-data">
                            <div class="sign-in-from bg-primary rounded">
                                <h3 class="mb-0 text-center text-white">Sign Up</h3>
                                <p class="text-center text-white">Enter your email address and password to access admin panel.</p>

                                <form class="user" action="/webbanhang/account/save" method="post">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Your Full Name</label>
                                        <input type="text" class="form-control mb-0" id="fullname" name="fullname" placeholder="Your Full Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail2">Email</label>
                                        <input type="text" class="form-control mb-0" id="username" name="username"  placeholder="Enter email">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
                                        <input type="password" class="form-control mb-0" id="password" name="password" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputConfirmPassword1">Confirm Password</label>
                                        <input type="password" class="form-control form-control-user"
                                            id="confirmpassword" name="confirmpassword" placeholder="confirmpassword">
                                    </div>
                                    <div class="d-inline-block w-100">
                                        <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">I accept <a href="#" class="text-light">Terms and Conditions</a></label>
                                        </div>
                                    </div>
                                    <div class="sign-info text-center">
                                        <button type="submit" class="btn btn-white d-block w-100 mb-2">Sign Up</button>
                                        <span class="text-dark d-inline-block line-height-2">Already Have Account ? <a href="/webbanhang/account/login" class="text-white">Log In</a></span>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

<?php include 'app/views/shares/footer.php'; ?>