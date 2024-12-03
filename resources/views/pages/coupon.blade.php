@extends('layouts.master')

@section('title', 'Mã giảm giá')

@section('content')

  <section class="bread-crumb">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home_page') }}">{{ __('Trang Chủ') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Mã giảm giá</li>
      </ol>
    </nav>
  </section>

  <div class="site-about">
    <section class="section-coupon">
      <div class="coupon-card">
        @foreach($coupons as $coupon)
            <div class="card-item mb-3">
                <div class="card-body">
                    <h2>
                        {{ $coupon->code }} - Giảm {{ $coupon->discount_percentage }}%
                    </h2>
                    <p class="card-text"><span>Giảm tối đa:</span> {{ number_format($coupon->max_discount_amount, 0, ',', '.') }}</p>
                    <p class="card-text"><span>Đơn hàng tối thiểu</span>: {{ number_format($coupon->min_order_amount, 0, ',', '.') }}</p>
                    <p class="card-text"><span>Thời gian áp dụng</span>: {{ $coupon->start_date }} ~ {{ $coupon->end_date }}</p>
                    @if(in_array($coupon->id, $savedCoupons))
                        <label>Đã lưu</label>
                    @else
                        <button class="btn btn-primary save-coupon" data-coupon-id="{{ $coupon->id }}">Lưu</button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    </section>

  </div>

@endsection

@section('css')
  <style>
    .section-coupon {
      padding: 20px;
      background: #fff;
    }
    .coupon-card {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(500px, 1fr));
      grid-gap: 20px;
    }
    .coupon-card .card-item {
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
      overflow: hidden;
      padding: 10px;
    }
    .coupon-card .card-item h2 {
      font-weight: bold;
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

      $('.save-coupon').on('click', function() {
            var couponId = $(this).data('coupon-id');
            $.ajax({
                url: '{{ route("save.coupon") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    coupon_id: couponId
                },
                success: function(response) {
                  if (response.status === 'success') {
                      Swal.fire({
                          title: 'Thành Công',
                          text: 'Coupon đã được lưu',
                          type: 'success'
                      }).then(() => {
                          location.reload();
                      });
                  } else if (response.status === 'not_logged_in') {
                      Swal.fire({
                          title: 'Lỗi',
                          text: 'Bạn cần đăng nhập để lưu coupon',
                          type: 'error'
                      });
                  }
                }
            });
        });
    });
  </script>
@endsection
