<!DOCTYPE html>
<html lang="en">

    
<!-- Mirrored from coderthemes.com/hyper/saas/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 27 Feb 2024 08:08:12 GMT -->
<head>
        <meta charset="utf-8" />
        <title>Log In | Hyper - Responsive Bootstrap 5 Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        
        <!-- Theme Config Js -->
        <script src="assets/js/hyper-config.js"></script>

        <!-- App css -->
        <link href="assets/css/app-saas.min.css" rel="stylesheet" type="text/css" id="app-style" />

        <!-- Icons css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="assets/css/sweetalert2.min.css">
    </head>
    
    <body class="authentication-bg position-relative">
        <div class="position-absolute start-0 end-0  bottom-0 w-100 h-100">
            <svg xmlns='http://www.w3.org/2000/svg' width='100%' height='100%' viewBox='0 0 800 800'>
                <g fill-opacity='0.22'>
                    <circle style="fill: rgba(var(--ct-primary-rgb), 0.1);" cx='400' cy='400' r='600'/>
                    <circle style="fill: rgba(var(--ct-primary-rgb), 0.2);" cx='400' cy='400' r='500'/>
                    <circle style="fill: rgba(var(--ct-primary-rgb), 0.3);" cx='400' cy='400' r='300'/>
                    <circle style="fill: rgba(var(--ct-primary-rgb), 0.4);" cx='400' cy='400' r='200'/>
                    <circle style="fill: rgba(var(--ct-primary-rgb), 0.5);" cx='400' cy='400' r='100'/>
                </g>
            </svg>
        </div>
        <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-4 col-lg-5">
                        <div class="card">

                            <!-- Logo -->
                            <div class="card-header py-4 text-center bg-primary">
                                <a href="index.html">
                                    <span><img src="assets/images/logo.png" alt="logo" height="22"></span>
                                </a>
                            </div>

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <h4 class="text-dark-50 text-center pb-0 fw-bold">Sign In</h4>
                                </div>

                                <form action="#">

                                    <div class="mb-3">
                                        <label for="login" class="form-label">Email or Username</label>
                                        <input class="form-control" type="email" id="login" required="" placeholder="Enter your email or username">
                                    </div>

                                    <div class="mb-3">
                                        {{-- <a href="pages-recoverpw.html" class="text-muted float-end"><small>Forgot your password?</small></a> --}}
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="password" class="form-control" placeholder="Enter your password">
                                            <div class="input-group-text" data-password="false">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                    </div>

                                   

                                    <div class="mb-3 text-center">
                                        <button class="btn btn-primary login_btn" type="button"> Log In </button>
                                    </div>

                                </form>
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-muted">Don't have an account? <a href="{{ route('register') }}" class="text-muted ms-1"><b>Sign Up</b></a></p>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <footer class="footer footer-alt">
            2018 - <script>document.write(new Date().getFullYear())</script> © Hyper - Coderthemes.com
        </footer>
        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>
         <script src="assets/js/sweetalert2.min.js"></script>
        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        <script src="assets/js/data/login.js"></script>
        <script src="assets/js/data/utility.js"></script>
        <script>
            $(document).ready(function(){
                $(".login_btn").on('click',function(){
                    let login=$("#login").val();
                    let password=$("#password").val();
                    if(login=='' || password==''){
                        Tost("All fields are required",'warning');
                        return false;
                    }
                    $.ajax({
                        url: "/api/login",
                        type: "POST",
                        data: {
                            login: login,
                            password: password
                        },
                        success: function(response) {
                           
                            setUserData(response.data);
                            window.location.href = "/dashboard";
                            Tost("Login successful");
                            // You can redirect the user or perform other actions here
                        },
                        error: function(xhr, status, error) {
                            Tost("Login failed: " + xhr.responseJSON.message, "error");
                        }
                    });
                })
            });
        </script>

    </body>

<!-- Mirrored from coderthemes.com/hyper/saas/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 27 Feb 2024 08:08:12 GMT -->
</html>
