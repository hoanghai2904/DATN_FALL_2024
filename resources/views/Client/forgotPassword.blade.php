@extends('Client.index')
@section('main')
    <!-- ...:::: Start Breadcrumb Section:::... -->
    <div class="breadcrumb-section breadcrumb-bg-color--golden">
        <div class="breadcrumb-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="breadcrumb-title">Lấy lại mật khẩu</h3>
                        <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                            <nav aria-label="breadcrumb">
                                <ul>
                                    <li><a href="index.html">Trang chủ</a></li>
                                    <li><a href="shop-grid-sidebar-left.html">Shop</a></li>
                                    <li class="active" aria-current="page">Lấy lại mật khẩu</li>
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
                        <h3 class="text-center mb-4">Lấy lại mật khẩu</h3>
                        <form action="{{ route('account.Check_login') }}" method="POST">
                            @csrf
                            <div class="default-form-box mb-3">
                                <label for="email">Email <span>*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required />
                                @if ($errors->has('email') && $errors->first('email') !== 'Tài khoản của bạn chưa được xác minh email. Vui lòng kiểm tra email để xác minh tài khoản.')
                                <div style="color: red; font-size: 12px;">{{ $errors->first('email') }}</div>
                                @endif
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
@endsection
