@extends('Client.index');
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
                                    <li><a href="index.html">Home</a></li>
                                    <li><a href="shop-grid-sidebar-left.html">Shop</a></li>
                                    <li class="active" aria-current="page">Login</li>
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
                      <h3 class="text-center mb-4">Login</h3>
                      <form action="#" method="POST">
                          <div class="default-form-box mb-3">
                              <label for="username">Username or email <span>*</span></label>
                              <input type="text" class="form-control" id="username" required />
                          </div>
                          <div class="default-form-box mb-3">
                              <label for="password">Passwords <span>*</span></label>
                              <input type="password" class="form-control" id="password" required />
                          </div>
                          <label class="checkbox-default mb-4" for="offer">
                              <input type="checkbox" id="offer" />
                              <span>Remember me</span>
                          </label>
                          <div class="login_submit">
                              <button class="btn btn-primary btn-block mb-3" type="submit">
                                  Login
                              </button>
                              <a href="#" class="text-decoration-none">Lost your password?</a>
                          </div>
                      </form>
                      <hr />
                      <div class="text-center">
                          <span>Don't have an account?</span>
                          <a href="{{route('account.rigester')}}" class="btn btn-outline-secondary btn-block mt-3 mb-5">
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
