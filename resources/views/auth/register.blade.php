
<!DOCTYPE html>
<html lang="en">

    
<!-- Mirrored from coderthemes.com/hyper/saas/pages-register.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 27 Feb 2024 08:08:12 GMT -->
<head>
        <meta charset="utf-8" />
        <title>Register | Hyper - Responsive Bootstrap 5 Admin Dashboard</title>
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
    </head>

    <body class="authentication-bg">

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
                            <!-- Logo-->
                            <div class="card-header py-4 text-center bg-primary">
                                <h5 class="text-white">Income Expense</h5>
                            </div>

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <h4 class="text-dark-50 text-center pb-0 fw-bold">Sign Up</h4>
                                </div>

                                <form action="#">

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input class="form-control" type="text" id="name" placeholder="Enter your name" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email address</label>
                                        <input class="form-control" type="email" id="email" required placeholder="Enter your email">
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="password" class="form-control" placeholder="Enter your password">
                                            <div class="input-group-text" data-password="false">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="password_confirmation" class="form-control" placeholder="Confirm your password">
                                            <div class="input-group-text" data-password="false">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 text-center">
                                        <button class="btn btn-primary signup_btn" type="button"> Sign Up </button>
                                    </div>

                                </form>
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-muted">Already have account? <a href="{{ route('login') }}" class="text-muted ms-1"><b>Log In</b></a></p>
                            </div> <!-- end col-->
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
        
        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        <script>
            $(document).ready(function(){
                $(".signup_btn").on('click',function(){
                    let name = $("#name").val();
                    let email = $("#email").val();
                    let password = $("#password").val();
                    let password_confirmation = $("#password_confirmation").val();
                    if(name == ''){
                        alert("Name is required");
                        return false;
                    }
                    if(email == ''){
                        alert("Email is required");
                        return false;
                    }
                    if(password == ''){
                        alert("Password is required");
                        return false;
                    }
                    if(password_confirmation == ''){
                        alert("Password confirmation is required");
                        return false;
                    }
                    if(password != password_confirmation){
                        alert("Password and Confirm Password do not match");
                        return false;
                    }
                    $.ajax({
                        url: "/api/register",
                        type: "POST",
                        data: {
                            name: name,
                            email: email,
                            password: password,
                            password_confirmation: password_confirmation,
                        },
                        success: function(response){
                            alert("Registration successful!");
                            window.location.href = "{{ route('login') }}";
                        },
                        error: function(xhr){
                            let errors = xhr.responseJSON.errors;
                            let errorMessage = "";
                            for(let key in errors){
                                errorMessage += errors[key][0] + "\n";
                            }
                            alert(errorMessage);
                        }
                    });
                });
            })
        </script>

    </body>

</html>
