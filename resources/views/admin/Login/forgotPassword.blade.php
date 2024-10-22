<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Reset Password | Velzon - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
      <!-- App favicon -->
  
      <link rel="shortcut icon" href="{{ asset('theme/admin/assets') }}/images/favicon.ico">
      <!-- Sweet Alert css-->
      <link href="{{ asset('theme/admin/assets') }}/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet"
          type="text/css" />
      <!-- Layout config Js -->
      <script src="{{ asset('theme/admin/assets') }}/js/layout.js"></script>
      <!-- Bootstrap Css -->
      <link href="{{ asset('theme/admin/assets') }}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
      <!-- Icons Css -->
      <link href="{{ asset('theme/admin/assets') }}/css/icons.min.css" rel="stylesheet" type="text/css" />
      <!-- App Css-->
      <link href="{{ asset('theme/admin/assets') }}/css/app.min.css" rel="stylesheet" type="text/css" />
      <!-- custom Css-->
      <link href="{{ asset('theme/admin/assets') }}/css/custom.min.css" rel="stylesheet" type="text/css" />
      <script src="{{ asset('theme/admin/assets') }}/js/vendor/jquery-3.5.1.min.js"></script>

</head>

<body>

    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden">
                            <div class="row justify-content-center g-0">
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4 auth-one-bg h-100">
                                        <div class="bg-overlay"></div>
                                        <div class="position-relative h-100 d-flex flex-column">
                                            <div class="mb-4">
                                                <a href="index.html" class="d-block">
                                                    <img src="assets/images/logo-light.png" alt="" height="18">
                                                </a>
                                            </div>
                                            <div class="mt-auto">
                                                <div class="mb-3">
                                                    <i class="ri-double-quotes-l display-4 text-success"></i>
                                                </div>

                                                <div id="qoutescarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                                    <div class="carousel-indicators">
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                    </div>
                                                    <div class="carousel-inner text-center text-white-50 pb-5">
                                                        <div class="carousel-item active">
                                                            <p class="fs-15 fst-italic">" Great! Clean code, clean design, easy for customization. Thanks very much! "</p>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <p class="fs-15 fst-italic">" The theme is really great with an amazing customer support."</p>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <p class="fs-15 fst-italic">" Great! Clean code, clean design, easy for customization. Thanks very much! "</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end carousel -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <h5 class="text-primary">Quên mật khẩu ? </h5>
                                        <div class="mt-2 text-center">
                                            <lord-icon
                                                src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop" colors="primary:#0ab39c" class="avatar-xl">
                                            </lord-icon>
                                        </div>

                                        <div class="alert border-0 alert-warning text-center mb-2 mx-2" role="alert">
                                            Hãy nhập Email của bạn để lấy lại mật khẩu !
                                        </div>
                                        <div class="p-2">
                                            <form action="{{route('admin.CheckForgotPass')}}" method="POST">
                                                @csrf
                                                <div class="mb-4">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email" placeholder="Nhập Email..." name="email">
                                                    @if (
                                                        $errors->has('email') &&
                                                            $errors->first('email') !==
                                                                'Tài khoản của bạn chưa được xác minh email. Vui lòng kiểm tra email để xác minh tài khoản.')
                                                        <div style="color: red; font-size: 12px;">{{ $errors->first('email') }}
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="text-center mt-4">
                                                    <button class="btn btn-success w-100" type="submit">Gửi</button>
                                                </div>
                                            </form><!-- end form -->
                                        </div>

                                        <div class="mt-5 text-center">
                                            <p class="mb-0">Quay lại trang đăng nhập ! <a href="auth-signin-cover.html" class="fw-semibold text-primary text-decoration-underline">Tại đây</a> </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">
                        Tạo bởi <i class="mdi mdi-heart text-danger"></i> Pet Shop &copy; <script>document.write(new Date().getFullYear())</script>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->
    <!-- JAVASCRIPT -->
    <script src="{{ asset('theme/admin/assets') }}/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('theme/admin/assets') }}/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ asset('theme/admin/assets') }}/libs/node-waves/waves.min.js"></script>
    <script src="{{ asset('theme/admin/assets') }}/libs/feather-icons/feather.min.js"></script>
    <script src="{{ asset('theme/admin/assets') }}/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="{{ asset('theme/admin/assets') }}/js/plugins.js"></script>

    <!-- particles js -->
    <script src="{{ asset('theme/admin/assets') }}/libs/particles.js/particles.js"></script>
    <!-- particles app js -->
    <script src="{{ asset('theme/admin/assets') }}/js/pages/particles.app.js"></script>
    <!-- password-addon init -->
    <script src="{{ asset('theme/admin/assets') }}/js/pages/password-addon.init.js"></script>

    <script src="{{ asset('theme/admin/assets') }}/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- Sweet alert init js-->
    <script src="{{ asset('theme/admin/assets') }}/js/pages/sweetalerts.init.js"></script>

    <!-- App js -->
    <script src="{{ asset('theme/admin/assets') }}/js/app.js"></script>
    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK'
        });
    </script>
@endif
</body>

</html>