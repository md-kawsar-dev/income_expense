<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="assets/vendor/daterangepicker/daterangepicker.css">

    <!-- Vector Map css -->
    <link rel="stylesheet" href="assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css">

    <!-- Theme Config Js -->
    <script src="assets/js/hyper-config.js"></script>

    <!-- App css -->
    <link href="assets/css/app-saas.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- Datatables css -->
    <link href="assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />

    <link rel="stylesheet" href="assets/css/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    <script src="assets/js/data/login.js"></script>
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">


        <!-- ========== Topbar Start ========== -->
        <div class="navbar-custom">
            <div class="topbar container-fluid">
                <div class="d-flex align-items-center gap-lg-2 gap-1">

                    <!-- Topbar Brand Logo -->
                    <div class="logo-topbar">
                        <!-- Logo light -->
                        <a href="index.html" class="logo-light">
                            <span class="logo-lg">
                                <img src="assets/images/logo.png" alt="logo">
                            </span>
                            <span class="logo-sm">
                                <img src="assets/images/logo-sm.png" alt="small logo">
                            </span>
                        </a>

                        <!-- Logo Dark -->
                        <a href="index.html" class="logo-dark">
                            <span class="logo-lg">
                                <img src="assets/images/logo-dark.png" alt="dark logo">
                            </span>
                            <span class="logo-sm">
                                <img src="assets/images/logo-dark-sm.png" alt="small logo">
                            </span>
                        </a>
                    </div>

                    <!-- Sidebar Menu Toggle Button -->
                    <button class="button-toggle-menu">
                        <i class="mdi mdi-menu"></i>
                    </button>

                    <!-- Horizontal Menu Toggle Button -->
                    <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>

                    <!-- Topbar Search Form -->
                    <div class="app-search dropdown d-none d-lg-block">
                        <form>
                            <div class="input-group">
                                <input type="search" class="form-control dropdown-toggle" placeholder="Search..."
                                    id="top-search">
                                <span class="mdi mdi-magnify search-icon"></span>
                                <button class="input-group-text btn btn-primary" type="submit">Search</button>
                            </div>
                        </form>

                        <div class="dropdown-menu dropdown-menu-animated dropdown-lg" id="search-dropdown">
                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h5 class="text-overflow mb-2">Found <span class="text-danger">17</span> results</h5>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="uil-notes font-16 me-1"></i>
                                <span>Analytics Report</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="uil-life-ring font-16 me-1"></i>
                                <span>How can I help you?</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="uil-cog font-16 me-1"></i>
                                <span>User profile settings</span>
                            </a>

                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow mb-2 text-uppercase">Users</h6>
                            </div>

                            <div class="notification-list">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <div class="d-flex">
                                        <img class="d-flex me-2 rounded-circle" src="assets/images/users/avatar-2.jpg"
                                            alt="Generic placeholder image" height="32">
                                        <div class="w-100">
                                            <h5 class="m-0 font-14">Erwin Brown</h5>
                                            <span class="font-12 mb-0">UI Designer</span>
                                        </div>
                                    </div>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <div class="d-flex">
                                        <img class="d-flex me-2 rounded-circle" src="assets/images/users/avatar-5.jpg"
                                            alt="Generic placeholder image" height="32">
                                        <div class="w-100">
                                            <h5 class="m-0 font-14">Jacob Deo</h5>
                                            <span class="font-12 mb-0">Developer</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="topbar-menu d-flex align-items-center gap-3">
                    <li class="dropdown d-lg-none">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ri-search-line font-22"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                            <form class="p-3">
                                <input type="search" class="form-control" placeholder="Search ..."
                                    aria-label="Recipient's username">
                            </form>
                        </div>
                    </li>

                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="assets/images/flags/us.jpg" alt="user-image" class="me-0 me-sm-1"
                                height="12">
                            <span class="align-middle d-none d-lg-inline-block">English</span> <i
                                class="mdi mdi-chevron-down d-none d-sm-inline-block align-middle"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated">

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <img src="assets/images/flags/germany.jpg" alt="user-image" class="me-1"
                                    height="12"> <span class="align-middle">German</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <img src="assets/images/flags/italy.jpg" alt="user-image" class="me-1"
                                    height="12"> <span class="align-middle">Italian</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <img src="assets/images/flags/spain.jpg" alt="user-image" class="me-1"
                                    height="12"> <span class="align-middle">Spanish</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <img src="assets/images/flags/russia.jpg" alt="user-image" class="me-1"
                                    height="12"> <span class="align-middle">Russian</span>
                            </a>

                        </div>
                    </li>

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ri-notification-3-line font-22"></i>
                            <span class="noti-icon-badge"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg py-0">
                            <div class="p-2 border-top-0 border-start-0 border-end-0 border-dashed border">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 font-16 fw-semibold"> Notification</h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="javascript: void(0);" class="text-dark text-decoration-underline">
                                            <small>Clear All</small>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="px-2" style="max-height: 300px;" data-simplebar>

                                <h5 class="text-muted font-13 fw-normal mt-2">Today</h5>
                                <!-- item-->

                                <a href="javascript:void(0);"
                                    class="dropdown-item p-0 notify-item card unread-noti shadow-none mb-2">
                                    <div class="card-body">
                                        <span class="float-end noti-close-btn text-muted"><i
                                                class="mdi mdi-close"></i></span>
                                        <div class="d-flex align-items-center">
                                            <div class="shrink-0">
                                                <div class="notify-icon bg-primary">
                                                    <i class="mdi mdi-comment-account-outline"></i>
                                                </div>
                                            </div>
                                            <div class="grow text-truncate ms-2">
                                                <h5 class="noti-item-title fw-semibold font-14">Datacorp <small
                                                        class="fw-normal text-muted ms-1">1 min ago</small></h5>
                                                <small class="noti-item-subtitle text-muted">Caleb Flakelar commented
                                                    on Admin</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);"
                                    class="dropdown-item p-0 notify-item card read-noti shadow-none mb-2">
                                    <div class="card-body">
                                        <span class="float-end noti-close-btn text-muted"><i
                                                class="mdi mdi-close"></i></span>
                                        <div class="d-flex align-items-center">
                                            <div class="shrink-0">
                                                <div class="notify-icon bg-info">
                                                    <i class="mdi mdi-account-plus"></i>
                                                </div>
                                            </div>
                                            <div class="grow text-truncate ms-2">
                                                <h5 class="noti-item-title fw-semibold font-14">Admin <small
                                                        class="fw-normal text-muted ms-1">1 hours ago</small></h5>
                                                <small class="noti-item-subtitle text-muted">New user
                                                    registered</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <h5 class="text-muted font-13 fw-normal mt-0">Yesterday</h5>

                                <!-- item-->
                                <a href="javascript:void(0);"
                                    class="dropdown-item p-0 notify-item card read-noti shadow-none mb-2">
                                    <div class="card-body">
                                        <span class="float-end noti-close-btn text-muted"><i
                                                class="mdi mdi-close"></i></span>
                                        <div class="d-flex align-items-center">
                                            <div class="shrink-0">
                                                <div class="notify-icon">
                                                    <img src="assets/images/users/avatar-2.jpg"
                                                        class="img-fluid rounded-circle" alt="" />
                                                </div>
                                            </div>
                                            <div class="grow text-truncate ms-2">
                                                <h5 class="noti-item-title fw-semibold font-14">Cristina Pride <small
                                                        class="fw-normal text-muted ms-1">1 day ago</small></h5>
                                                <small class="noti-item-subtitle text-muted">Hi, How are you? What
                                                    about our next meeting</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <h5 class="text-muted font-13 fw-normal mt-0">30 Dec 2021</h5>

                                <!-- item-->
                                <a href="javascript:void(0);"
                                    class="dropdown-item p-0 notify-item card read-noti shadow-none mb-2">
                                    <div class="card-body">
                                        <span class="float-end noti-close-btn text-muted"><i
                                                class="mdi mdi-close"></i></span>
                                        <div class="d-flex align-items-center">
                                            <div class="shrink-0">
                                                <div class="notify-icon bg-primary">
                                                    <i class="mdi mdi-comment-account-outline"></i>
                                                </div>
                                            </div>
                                            <div class="grow text-truncate ms-2">
                                                <h5 class="noti-item-title fw-semibold font-14">Datacorp</h5>
                                                <small class="noti-item-subtitle text-muted">Caleb Flakelar commented
                                                    on Admin</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);"
                                    class="dropdown-item p-0 notify-item card read-noti shadow-none mb-2">
                                    <div class="card-body">
                                        <span class="float-end noti-close-btn text-muted"><i
                                                class="mdi mdi-close"></i></span>
                                        <div class="d-flex align-items-center">
                                            <div class="shrink-0">
                                                <div class="notify-icon">
                                                    <img src="assets/images/users/avatar-4.jpg"
                                                        class="img-fluid rounded-circle" alt="" />
                                                </div>
                                            </div>
                                            <div class="grow text-truncate ms-2">
                                                <h5 class="noti-item-title fw-semibold font-14">Karen Robinson</h5>
                                                <small class="noti-item-subtitle text-muted">Wow ! this admin looks
                                                    good and awesome design</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <div class="text-center">
                                    <i class="mdi mdi-dots-circle mdi-spin text-muted h3 mt-0"></i>
                                </div>
                            </div>

                            <!-- All-->
                            <a href="javascript:void(0);"
                                class="dropdown-item text-center text-primary notify-item border-top py-2">
                                View All
                            </a>

                        </div>
                    </li>

                    <li class="dropdown d-none d-sm-inline-block">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ri-apps-2-line font-22"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg p-0">

                            <div class="p-2">
                                <div class="row g-0">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="assets/images/brands/slack.png" alt="slack">
                                            <span>Slack</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="assets/images/brands/github.png" alt="Github">
                                            <span>GitHub</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="assets/images/brands/dribbble.png" alt="dribbble">
                                            <span>Dribbble</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="row g-0">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="assets/images/brands/bitbucket.png" alt="bitbucket">
                                            <span>Bitbucket</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="assets/images/brands/dropbox.png" alt="dropbox">
                                            <span>Dropbox</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="assets/images/brands/g-suite.png" alt="G Suite">
                                            <span>G Suite</span>
                                        </a>
                                    </div>
                                </div> <!-- end row-->
                            </div>

                        </div>
                    </li>

                    <li class="d-none d-sm-inline-block">
                        <a class="nav-link" data-bs-toggle="offcanvas" href="#theme-settings-offcanvas">
                            <i class="ri-settings-3-line font-22"></i>
                        </a>
                    </li>

                    <li class="d-none d-sm-inline-block">
                        <div class="nav-link" id="light-dark-mode" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="Theme Mode">
                            <i class="ri-moon-line font-22"></i>
                        </div>
                    </li>


                    <li class="d-none d-md-inline-block">
                        <a class="nav-link" href="#" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line font-22"></i>
                        </a>
                    </li>

                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle arrow-none nav-user px-2" data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <span class="account-user-avatar">
                                <img src="assets/images/users/avatar-1.jpg" alt="user-image" width="32"
                                    class="rounded-circle">
                            </span>
                            <span class="d-lg-flex flex-column gap-1 d-none">
                                <h5 class="my-0 login_user_name">Dominic Keller</h5>
                                <h6 class="my-0 fw-normal login_user_role">Founder</h6>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                            <!-- item-->
                            <div class=" dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome !</h6>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="mdi mdi-account-circle me-1"></i>
                                <span>My Account</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="mdi mdi-account-edit me-1"></i>
                                <span>Settings</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="mdi mdi-lifebuoy me-1"></i>
                                <span>Support</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="mdi mdi-lock-outline me-1"></i>
                                <span>Lock Screen</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" onclick="logout()" class="dropdown-item">
                                <i class="mdi mdi-logout me-1"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- ========== Topbar End ========== -->

        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu">

            <!-- Brand Logo Light -->
            <a href="/" class="logo logo-light">
                <span class="logo-lg">
                    <img src="assets/images/logo.png" alt="logo">
                </span>
                <span class="logo-sm">
                    <img src="assets/images/logo-sm.png" alt="small logo">
                </span>
            </a>

            <!-- Brand Logo Dark -->
            <a href="/" class="logo logo-dark">
                <span class="logo-lg">
                    <img src="assets/images/logo-dark.png" alt="dark logo">
                </span>
                <span class="logo-sm">
                    <img src="assets/images/logo-dark-sm.png" alt="small logo">
                </span>
            </a>

            <!-- Sidebar Hover Menu Toggle Button -->
            <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right"
                title="Show Full Sidebar">
                <i class="ri-checkbox-blank-circle-line align-middle"></i>
            </div>

            <!-- Full Sidebar Menu Close Button -->
            <div class="button-close-fullsidebar">
                <i class="ri-close-fill align-middle"></i>
            </div>

            <!-- Sidebar -left -->
            <div class="h-100" id="leftside-menu-container" data-simplebar>
                <!-- Leftbar User -->
                <div class="leftbar-user">
                    <a href="pages-profile.html">
                        <img src="assets/images/users/avatar-1.jpg" alt="user-image" height="42"
                            class="rounded-circle shadow-sm">
                        <span class="leftbar-user-name mt-2 login_user_name">Dominic Keller</span>
                    </a>
                </div>

                <!--- Sidemenu -->
                <ul class="side-nav">

                    <li class="side-nav-title">Navigation</li>


                    <li class="side-nav-item">
                        <a href="/" class="side-nav-link">
                            <i class="uil-home-alt"></i>
                            <span> Dashboards </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="/budget-plan" class="side-nav-link">
                            <i class="uil-comments-alt"></i>
                            <span> Budget Plan </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="/income" class="side-nav-link">
                            <i class="uil-comments-alt"></i>
                            <span> Income </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="/expense" class="side-nav-link">
                            <i class="uil-comments-alt"></i>
                            <span> Expense </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="/category" class="side-nav-link">
                            <i class="uil-comments-alt"></i>
                            <span> Category </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="/income-by" class="side-nav-link">
                            <i class="uil-comments-alt"></i>
                            <span> Income By </span>
                        </a>
                    </li>
                </ul>
                <!--- End Sidemenu -->

                <div class="clearfix"></div>
            </div>
        </div>
        <!-- ========== Left Sidebar End ========== -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    @yield('content')

                </div>
                <!-- container -->

            </div>
            <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © Hyper - Coderthemes.com
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end footer-links d-none d-md-block">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->



     <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- Daterangepicker js -->
        <script src="assets/vendor/daterangepicker/moment.min.js"></script>
        <script src="assets/vendor/daterangepicker/daterangepicker.js"></script>
        
        <!-- Apex Charts js -->
        <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>

        <!-- Vector Map js -->
        <script src="assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="assets/vendor/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>

        <!-- Dashboard App js -->
        <script src="assets/js/pages/demo.dashboard.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>


    <!-- Datatables js -->
    <script src="assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>

    <!-- Datatable Init js -->
    <script src="assets/js/pages/demo.datatable-init.js"></script>
    <script src="assets/js/sweetalert2.min.js"></script>
    <script src="assets/js/data/utility.js"></script>
    @yield('script')
    <script>
        let loginUserName = document.querySelector('.login_user_name');
        let loginUserRole = document.querySelector('.login_user_role');
        document.addEventListener('DOMContentLoaded', function() {
            let userData = getUserData();
            if (userData) {
                loginUserName.textContent = userData.name;
                loginUserRole.textContent = userData.role.name;
            }
        });
    </script>
    
</body>

<!-- Mirrored from coderthemes.com/hyper/saas/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 27 Feb 2024 08:07:33 GMT -->

</html>
