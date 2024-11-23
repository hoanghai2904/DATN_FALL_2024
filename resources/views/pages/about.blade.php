@extends('layouts.master')

@section('title', 'Giới Thiệu')

@section('content')

  <section class="bread-crumb">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home_page') }}">{{ __('Trang Chủ') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Giới Thiệu</li>
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
        <h2 class="section-title">Giới Thiệu</h2>
      </div>
      <div class="section-content">
        <div class="row">
          <div class="col-md-9 col-sm-8">
            <div class="content-left">
              <div class="note">
                <div class="note-icon"><i class="fas fa-info-circle"></i></div>
                <div class="note-content">
                  <p>website <strong>Shop Pet</strong> là một sản phẩm của đồ án tốt nghiệp đề tài: <i> Xây dựng Website bán hàng trực tuyến Paddy chạy được trên cả máy tính </i>. Được thực hiện bởi sinh viên . Mọi hoạt động mua sắm trên website đều không có giá trị !</p>
                </div>
              </div>
              <div class="content">
                <h3 class="text-center" style="font-weight: 800">Chào mừng đến với PAWS ON CHICON!</h3>
                <p>Paddy.vn là nhà bán lẻ chuyên cung cấp các sản phẩm chất lượng cao cho chó mèo, bao gồm thức ăn, snack, phụ kiện, thời trang, mỹ phẩm chăm sóc và đồ dùng vệ sinh từ các thương hiệu uy tín trên thế giới.</p>
                <p>Vào năm 2024, Paddy đã khai trương cửa hàng đầu tiên của mình, đồng thời cũng thành công trong việc vận hành hệ thống kênh bán hàng online trên Website và các sàn thương mại điện tử như Shopee, Lazada, Tiktok. Hiện tại, Paddy đang có 3 cửa hàng tại khu vực thành phố Hồ Chí Minh cung cấp hơn 2.000 sản phẩm chất lượng đạt tiêu chuẩn từ các thương hiệu lớn như Royal Canin, Nutrience, Taste of the Wild, Zenith, Bowwow, Nekko, Ganador, Minino, Kit Cat, The Pet...</p>
                <p>Với mong muốn không chỉ mang lại sản phẩm giá cả hợp lý, đảm bảo chất lượng cho khách hàng mà còn giúp họ cảm thấy thoải mái và tiện lợi khi mua sắm sản phẩm cho thú cưng, Paddy luôn nỗ lực để duy trì và nâng cao chất lượng dịch vụ của mình. Từ việc tư vấn khách hàng tận tình chu đáo đến giao hàng nhanh chóng và xử lý các vấn đề kịp thời - tất cả những điều này đã giúp Paddy xây dựng được lòng tin từ phía khách hàng và dần trở thành người bạn đồng hành tin cậy của các chủ nuôi thú cưng...</p>
              <img style="width: 100%" src="{{ asset('images/about.webp') }}" alt="">
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-4">
            <div class="content-right">
              <div class="online_support">
                <h2 class="title">CHÚNG TÔI LUÔN SẴN SÀNG<br>ĐỂ GIÚP ĐỠ BẠN</h2>
                <img src="{{ asset('images/support_online.jpg') }}">
                <h3 class="sub_title">Để được hỗ trợ tốt nhất. Hãy gọi</h3>
                <div class="phone">
                  <a href="tel:(+84) 377.887.668" title="(+84) 377.887.668">0377887668</a>
                </div>
                <div class="or"><span>HOẶC</span></div>
                <h3 class="title">Chat hỗ trợ trực tuyến</h3>
                <h3 class="sub_title">Chúng tôi luôn trực tuyến 24/7.</h3>
              </div>
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
    });
  </script>
@endsection
