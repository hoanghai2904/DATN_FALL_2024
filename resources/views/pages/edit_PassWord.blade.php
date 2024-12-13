
@extends('layouts.master')

@section('title', 'Thay Đổi Thông Tin')

@section('content')

  <section class="bread-crumb">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home_page') }}">{{ __('Trang Chủ') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('show_user') }}">Tài Khoản</a></li>
        <li class="breadcrumb-item active" aria-current="page">Thay Đổi Mật KhẩuKhẩu</li>
      </ol>
    </nav>
  </section>

  <div class="site-user">
    <section class="section-advertise">
      <div class="content-advertise">
        <div id="slide-advertise" class="owl-carousel">
          @foreach($data['advertises'] as $advertise)
            <div class="slide-advertise-inner" style="background-image: url('{{ Helper::get_image_advertise_url($advertise->image) }}');" data-dot="<button>{{ $advertise->title }}</button>"></div>
          @endforeach
        </div>
      </div>
    </section>

    <section class="section-user">
      <div class="section-header">
        <h2 class="section-title">Đổi Mật KhẩuKhẩu</h2>
      </div>
      <div class="section-content">
        <div class="row">
          <div class="col-md-9">
            <div class="user">
                <form class="form-user" action="{{ route('save_Password') }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $data['user']->id }}">
                    <div class="row">
                        <div class="col-md-9 col-sm-8 col-xs-8">
                            <div class="user-info">
                                <div class="info">
                                    <div class="info-label">Email</div>
                                    <div class="info-content">
                                        <input type="email" name="email" placeholder="Email" value="{{ $data['user']->email }}" disabled>
                                    </div>
                                </div>
                                <div class="info">
                                    <div class="info-label">Mật Khẩu Hiện Tại</div>
                                    <div class="info-content">
                                        <input id="old_password" type="password" class="@error('old_password') is-invalid @enderror" name="old_password" placeholder="Mật khẩu hiện tại" value="{{ old('old_password') }}" required autocomplete="current-password">
                                        @error('old_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="info">
                                    <div class="info-label">Mật Khẩu Mới</div>
                                    <div class="info-content">
                                        <input id="new_password" type="password" class="@error('new_password') is-invalid @enderror" name="new_password" placeholder="Mật khẩu mới" value="{{ old('new_password') }}" required autocomplete="new-password">
                                        @error('new_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="info">
                                    <div class="info-label">Xác Nhận Mật Khẩu</div>
                                    <div class="info-content">
                                        <input id="confirm_password" type="password" class="@error('confirm_password') is-invalid @enderror" name="confirm_password" placeholder="Xác nhận lại mật khẩu" value="{{ old('confirm_password') }}" required autocomplete="new-password">
                                        @error('confirm_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="action-edit">
                                <button type="submit" class="btn btn-default" title="Lưu Thay Đổi">Lưu Thay Đổi</button>
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>
          </div>
          <div class="col-md-3">
            <div class="online_support">
              <h2 class="title">CHÚNG TÔI LUÔN SẴN SÀNG<br>ĐỂ GIÚP ĐỠ BẠN</h2>
              <img src="{{ asset('images/support_online.jpg') }}">
              <h3 class="sub_title">Để được hỗ trợ tốt nhất. Hãy gọi</h3>
              <div class="phone">
                <a href="tel:18006750" title="1800 6750">1800 6750</a>
              </div>
              <div class="or"><span>HOẶC</span></div>
              <h3 class="title">Chat hỗ trợ trực tuyến</h3>
              <h3 class="sub_title">Chúng tôi luôn trực tuyến 24/7.</h3>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

@endsection

@section('css')
  <style>
    .slide-advertise-inner {
      background-repeat: no-repeat;
      background-size: cover;
      padding-top: 21.25%;
    }
    #slide-advertise.owl-carousel .owl-item.active {
      -webkit-animation-name: zoomIn;
      animation-name: zoomIn;
      -webkit-animation-duration: .6s;
      animation-duration: .6s;
    }
  </style>
@endsection

@section('js')
  <script>
    $(document).ready(function(){

      $("#slide-advertise").owlCarousel({
        items: 2,
        autoplay: true,
        loop: true,
        margin: 10,
        autoplayHoverPause: true,
        nav: true,
        dots: false,
        responsive:{
          0:{
            items: 1,
          },
          992:{
            items: 2,
            animateOut: 'zoomInRight',
            animateIn: 'zoomOutLeft',
          }
        },
        navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>']
      });

      $("#upload").change(function() {
        $('.site-user .upload-avatar .avatar-preview').css('background-image', 'url("' + getImageURL(this) + '")');
      });

      @if(session('alert'))
        Swal.fire(
          '{{ session('alert')['title'] }}',
          '{{ session('alert')['content'] }}',
          '{{ session('alert')['type'] }}'
        )
      @endif
    });

    function getImageURL(input) {
      return URL.createObjectURL(input.files[0]);
    };
  </script>
@endsection
