<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Sign In Admin & Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
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

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="index.html" class="d-inline-block auth-logo">
                                    <img src="{{ asset('theme/admin/assets') }}/images/logo-light.png" alt=""
                                        height="20">
                                </a>
                            </div>
<<<<<<< HEAD
                            <p class="mt-3 fs-15 fw-medium">Premium Admin & Dashboard</p>
=======
                            <p class="mt-3 fs-15 fw-medium">Admin & Dashboard</p>
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
<<<<<<< HEAD
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p class="text-muted">Sign in to continue</p>
=======
                                    <h5 class="text-primary">Đăng Nhập</h5>
                                  
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc
                                </div>
                                <div class="p-2 mt-4">
                                    <form action="{{ route('admin.Check_login') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Email</label>
                                            <input type="text" class="form-control" id="username" name="email"
                                                placeholder="Enter username">
<<<<<<< HEAD
                                        </div>
                                        @if (
                                            $errors->has('email') &&
                                                $errors->first('email') !==
                                                    'Tài khoản của bạn chưa được xác minh email. Vui lòng kiểm tra email để xác minh tài khoản.')
                                            <div style="color: red; font-size: 12px;">{{ $errors->first('email') }}
                                            </div>
                                        @endif
=======
                                                @if (
                                                    $errors->has('email') &&
                                                        $errors->first('email') !==
                                                            'Tài khoản của bạn chưa được xác minh email. Vui lòng kiểm tra email để xác minh tài khoản.')
                                                    <div style="color: red; font-size: 12px;">{{ $errors->first('email') }}
                                                    </div>
                                                @endif
                                        </div>
                                       
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc
                                        <div class="mb-3">

                                            <label class="form-label" for="password-input">Mật khẩu</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5 password-input"
                                                    placeholder="Enter password" id="password-input" name="password">
                                                <button
                                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                    type="button" id="password-addon"><i
                                                        class="ri-eye-fill align-middle"></i></button>
<<<<<<< HEAD
                                            </div>
                                        </div>
                                        @if ($errors->has('password'))
                                            <div style="color: red; font-size: 12px;">{{ $errors->first('password') }}
                                            </div>
                                        @endif
                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Đăng nhập</button>
                                        </div>
                                        <div class="float-end pt-2">
                                            <a href="auth-pass-reset-basic.html" class="text-muted">Quên mật khẩu?</a>
                                        </div>
                                    </form>
=======
                                                        @if ($errors->has('password'))
                                                        <div style="color: red; font-size: 12px;">{{ $errors->first('password') }}
                                                        </div>
                                                    @endif
                                            </div>
                                        </div>
                                      
                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Đăng nhập</button>
                                        </div>
                                       
                                    </form>
                                    <div class="float-end pt-2">
                                        <a href="{{route('admin.forgotPass')}}" class="text-muted">Quên mật khẩu?</a>
                                    </div>
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->
<<<<<<< HEAD

=======
 
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc
        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
<<<<<<< HEAD
                            <p class="mb-0 text-muted">&copy;
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> Velzon. Crafted with <i class="mdi mdi-heart text-danger"></i>
                                by Themesbrand
=======
                            <p class="mb-0 text-muted">
                        Tạo bởi <i class="mdi mdi-heart text-danger"></i> Pet Shop &copy; <script>document.write(new Date().getFullYear())</script>
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->
<<<<<<< HEAD

=======
    <script>
        document.addEventListener('DOMContentLoaded', function () {
      // Lấy thông báo từ session và kiểm tra xem có giá trị không
      const successMessage = @json(session('success', '')); // Trả về chuỗi rỗng nếu không có giá trị
      const errorMessage = @json(session('error', ''));
  
      if (successMessage) {
          Swal.fire({
              icon: 'success',
              title: 'Thành công!',
              text: successMessage,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'OK'
          }).then(() => {
              console.log('Thông báo thành công đã được hiển thị.');
              // Thực hiện logic khác nếu cần thiết
          });
      }
  
      if (errorMessage) {
          Swal.fire({
              icon: 'error',
              title: 'Lỗi!',
              text: errorMessage,
              confirmButtonColor: '#d33',
              confirmButtonText: 'Thử lại'
          }).then(() => {
              console.log('Thông báo lỗi đã được hiển thị.');
              // Thực hiện thêm logic nếu cần thiết
          });
      }
  });
  
  
      </script>
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc
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
   
 
</body>

</html>
