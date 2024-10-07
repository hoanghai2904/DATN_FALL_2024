@extends('Client.index')
@section('main')
    <!-- ...:::: Start Breadcrumb Section:::... -->
    <div class="breadcrumb-section breadcrumb-bg-color--golden">
        <div class="breadcrumb-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="breadcrumb-title">Login</h3>
                        <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                            <nav aria-label="breadcrumb">
                                <ul>
                                    <li><a href="index.html">Trang chủ</a></li>
                                    <li><a href="shop-grid-sidebar-left.html">Shop</a></li>
                                    <li class="active" aria-current="page">Đăng nhập</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ...:::: End Breadcrumb Section:::... -->
    <!-- ...:::: Start Customer Login Section :::... -->
    <div class="customer-login mb-10">
        <div class="container">
            <div class="row justify-content-center">
                <!--login area start-->
                <div class="col-lg-6 col-md-8">
                    <div class="account_form p-4 border rounded shadow-sm" data-aos="fade-up" data-aos-delay="0">
                        <h3 class="text-center mb-4">Đăng nhập</h3>
                        <form action="{{ route('account.Check_login') }}" method="POST">
                            @csrf
                            <div class="default-form-box mb-3">
                                <label for="email">Email <span>*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required />
                                @if ($errors->has('email') && $errors->first('email') !== 'Tài khoản của bạn chưa được xác minh email. Vui lòng kiểm tra email để xác minh tài khoản.')
                                <div style="color: red; font-size: 12px;">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                            <div class="default-form-box mb-3">
                                <label for="password">Mật khẩu <span>*</span></label>
                                <input type="password" class="form-control" id="password" name="password" required />
                                @if ($errors->has('password'))
                                <div style="color: red; font-size: 12px;">{{ $errors->first('password') }}</div>
                                @endif
                            </div>
                            <label class="checkbox-default mb-4" for="offer">
                                <input type="checkbox" id="remember" name="remember" />
                                <span>Ghi nhớ mật khẩu</span>
                            </label>
                            <div class="login_submit">
                                <button class="btn btn-md btn-black-default-hover btn-block mb-3" type="submit">
                                    Đăng nhập
                                </button>
                                <!-- Button trigger modal -->
                                <a href="#" class="text-decoration-none" data-toggle="modal" data-target="#forgotPasswordModal">Quên mật khẩu?</a>
                            </div>
                        </form>
                        <hr />
                        <div class="text-center">
                            <span>Bạn chưa có tài khoản?</span>
                            <a href="{{ route('account.rigester') }}" class="btn btn-outline-secondary btn-block mt-3 mb-5">
                                Register
                            </a>
                        </div>
                    </div>
                </div>
                <!--login area end-->
            </div>
        </div>
    </div>

    <!-- Modal Quên mật khẩu -->
  <!-- Modal Quên mật khẩu -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="forgotPasswordModalLabel">Quên mật khẩu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="forgotPasswordForm">
                    @csrf
                    <div class="form-group">
                        <label for="forgot-email">Email</label>
                        <input type="email" class="form-control" id="forgot-email" name="email" required />
                    </div>
                    <center>
                    <button type="submit" class="btn btn-md btn-black-default-hover btn-block mb-3 mt-5 custom-width">Đặt lại mật khẩu</button>
                </center>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    #forgotPasswordModal .modal-dialog {
        max-width: 400px; /* Giảm kích thước modal */
        margin: auto; /* Căn giữa modal */
    }
    #forgotPasswordModal .modal-content {
        padding: 20px;
    }
    .custom-width {
        width: 30%; /* Điều chỉnh kích thước cho phù hợp */
        max-width: 200px; /* Đặt kích thước tối đa cho nút */
        margin: 0 auto; /* Căn giữa nút */
    }
</style>

    <!-- ...:::: End Modal :::... -->
@endsection
