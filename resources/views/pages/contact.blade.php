@extends('layouts.master')

@section('title', 'Liên Hệ')

@section('content')

  <section class="bread-crumb">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home_page') }}">{{ __('Trang Chủ') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Liên Hệ</li>
      </ol>
    </nav>
  </section>

  <div class="site-about">
    <section class="section-advertise">
      <div class="content-advertise">
        <div id="slide-advertise" class="owl-carousel">
          @foreach($advertises as $advertise)
            <div class="slide-advertise-inner" style="background-image: url('{{ Helper::get_image_advertise_url($advertise->image) }}');" data-dot="<button>{{ $advertise->title }}</button>"></div>
          @endforeach
        </div>
      </div>
    </section>

    <section class="section-about">
      <div class="section-header">
        <h2 class="section-title">Liên Hệ</h2>
      </div>
      <div class="section-content">
        <div class="row" style="margin-bottom: 16px;">
          <div class="col-md-9">
            <div class="section-content">
              <form id="contact-form" action="{{ route('send_contact') }}" method="POST">
                @csrf
                <div class="form-group">
                  <label for="name">Tên <span class="text-red">*</span></label>
                  <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                  <label for="email">Email <span class="text-red">*</span></label>
                  <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                  <label for="message">Nội Dung <span class="text-red">*</span></label>
                  <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary" id="submit-button">
                  <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                  Gửi
                </button>
              </form>
            </div>
          </div>
          <div class="col-md-3">
            <div class="content-right">
              <div class="online_support">
                <h2 class="title">CHÚNG TÔI LUÔN SẴN SÀNG<br>ĐỂ GIÚP ĐỠ BẠN</h2>
                <img src="{{ asset('images/support_online.jpg') }}">
                <h3 class="sub_title">Để được hỗ trợ tốt nhất. Hãy gọi</h3>
                <div class="phone">
                  <a href="tel:0377887668" title="0377887668">0377887668</a>
                </div>
                <div class="or"><span>HOẶC</span></div>
                <h3 class="title">Chat hỗ trợ trực tuyến</h3>
                <h3 class="sub_title">Chúng tôi luôn trực tuyến 24/7.</h3>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="content-left">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.863806019075!2d105.74468687471467!3d21.038134787457583!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313455e940879933%3A0xcf10b34e9f1a03df!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEZQVCBQb2x5dGVjaG5pYw!5e0!3m2!1svi!2s!4v1731421678197!5m2!1svi!2s" width="800" height="400" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
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
    .text-red {
      color: red;
    }
  </style>
@endsection

@section('js')
<script src="{{ asset('AdminLTE/bower_components/jquery-validate/jquery.validate.js') }}"></script>
<script>
 $(document).ready(function() {

// Initialize Owl Carousel
$("#slide-advertise").owlCarousel({
  items: 2,
  autoplay: true,
  loop: true,
  margin: 10,
  autoplayHoverPause: true,
  nav: true,
  dots: false,
  responsive: {
    0: {
      items: 1
    },
    992: {
      items: 2,
      animateOut: 'zoomInRight',
      animateIn: 'zoomOutLeft'
    }
  },
  navText: [
    '<i class="fas fa-angle-left"></i>', 
    '<i class="fas fa-angle-right"></i>'
  ]
});

// Initialize jQuery Validation for Contact Form
$('#contact-form').validate({
  rules: {
    name: {
      required: true,
      minlength: 2
    },
    email: {
      required: true,
      email: true
    },
    message: {
      required: true,
      minlength: 10
    }
  },
  messages: {
    name: {
      required: "Vui lòng nhập tên của bạn",
      minlength: "Tên phải có ít nhất 2 ký tự"
    },
    email: {
      required: "Vui lòng nhập địa chỉ email",
      email: "Vui lòng nhập địa chỉ email hợp lệ"
    },
    message: {
      required: "Vui lòng nhập nội dung",
      minlength: "Nội dung phải có ít nhất 10 ký tự"
    }
  },
  errorPlacement: function(error, element) {
    error.addClass('text-danger'); // Thêm class phù hợp để hiển thị lỗi
    error.insertAfter(element);
  },
  submitHandler: function(form) {
    var submitButton = $('#submit-button');

    // Disable button and show spinner
    submitButton.prop('disabled', true);
    submitButton.html('<span class="spinner-border spinner-border-sm"></span> Đang gửi...');

    // Submit the form
    form.submit();
  }
});

});

</script>
@endsection
