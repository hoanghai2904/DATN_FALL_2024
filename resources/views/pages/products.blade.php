@extends('layouts.master')

@section('title', 'Sản Phẩm')

@section('content')

  <section class="bread-crumb">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home_page') }}">{{ __('Trang Chủ') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Sản Phẩm</li>
      </ol>
    </nav>
  </section>

  <div class="site-products">
    <section class="section-advertise">
      <div class="content-advertise">
        <div id="slide-advertise" class="owl-carousel">
          @foreach($data['advertises'] as $advertise)
            <div class="slide-advertise-inner" style="background-image: url('{{ Helper::get_image_advertise_url($advertise->image) }}');" data-dot="<button>{{ $advertise->title }}</button>"></div>
          @endforeach
        </div>
      </div>
    </section>

    <section class="section-filter">
      <div class="section-header">
        <h2 class="section-title">Tìm Kiếm Và Sắp Xếp</h2>
      </div>
      <div class="section-content">
        <form action="{{ route('products_page') }}" method="GET" accept-charset="utf-8">
          <div class="row">
            <div class="col-md-10">
              <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-6">
                  <input type="text" name="name" placeholder="Tìm kiếm..." value="{{ Request::input('name') }}">
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6">
                  <select name='price'>
                    <option value='' {{ Request::input('price') == null ? 'selected' : '' }}>
                      Giá Sản Phẩm
                    </option>
                    <option value='asc' {{ Request::input('price') == 'asc' ? 'selected' : '' }}>
                      Giá từ thấp tới cao
                    </option>
                    <option value='desc' {{ Request::input('price') == 'desc' ? 'selected' : '' }}>
                      Giá từ cao tới thấp
                    </option>
                  </select>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6">
                  <select name='type'>
                    <option value='' {{ Request::input('type') == null ? 'selected' : '' }}>
                      Loại Sản Phẩm
                    </option>
                    <option value='promotion' {{ Request::input('type') == 'promotion' ? 'selected' : '' }}>
                      Sản phẩm khuyến mại
                    </option>
                    <option value='vote' {{ Request::input('type') == 'vote' ? 'selected' : '' }}>
                      Sản phẩm đánh giá cao
                    </option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <label for="price-range">Khoảng Giá</label>
                  <div id="price-range"></div>
                  <input type="hidden" id="price_min" name="price_min" value="{{ Request::input('price_min') }}">
                  <input type="hidden" id="price_max" name="price_max" value="{{ Request::input('price_max') }}">
                  <div class="price-range-values">
                    <span id="price-range-min"></span> - <span id="price-range-max"></span> VNĐ
                  </div>
                </div>
              </div>
            </div>
          </div>
            <div class="btn-group-filter">
              <button type="submit" class="btn btn-default">Lọc Sản Phẩm</button>
              <button type="button" class="btn btn-secondary" id="clear-filters">Xóa Bộ Lọc</button>
            </div>
          </div>
        </form>
      </div>
    </section>

    <section class="section-products">
      <div class="section-header">
        <div class="section-header-left">
          <h2 class="section-title">SẢN PHẨM</h2>
        </div>
        <div class="section-header-right">
          <ul>
            @foreach($data['producers'] as $producer)
              <li><a href="{{ route('producer_page', ['id' => $producer->id]) }}" title="{{ $producer->name }}">{{ $producer->name }}</a></li>
            @endforeach
          </ul>
        </div>
      </div>
      <div class="section-content">
        @if($data['products']->isEmpty())
          <div class="empty-content">
            <div class="icon"><i class="fab fa-searchengin"></i></div>
            <div class="title">Oooops!</div>
            <div class="content">Product Item Not Found</div>
          </div>
        @else
        <div class="product-container">
            @foreach($data['products'] as $key => $product)
              <div class="item-product">
                <a href="{{ route('product_page', ['id' => $product->id]) }}" title="{{ $product->name }}">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="image-product">
                        <img loading="lazy" src="{{ Helper::get_image_product_url($product->image) }}" 
                          alt="Product Image" 
                          style="width: 100%; height: 280px;"
                          onError="this.onerror=null; this.src='{{ asset('images/no_image.png') }}';" />
                        {!! Helper::get_promotion_percent($product->product_detail->sale_price, $product->product_detail->promotion_price, $product->product_detail->promotion_start_date, $product->product_detail->promotion_end_date) !!}
                      </div>
                      <div class="content-product">
                        <h3 class="title">{{ $product->name }}</h3>
                        <div class="start-vote">
                          {!! Helper::get_start_vote($product->rate) !!}
                        </div>
                        <div class="price">
                          {!! Helper::get_real_price($product->product_detail->sale_price, $product->product_detail->promotion_price, $product->product_detail->promotion_start_date, $product->product_detail->promotion_end_date) !!}
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            @endforeach
          </div>
        @endif
      </div>
      <div class="section-footer text-center">
        {{ $data['products']->appends(Request::query())->links() }}
      </div>
    </section>
  </div>

@endsection

@section('css')
  <link rel="stylesheet" href="{{ asset('common/noUiSlider/dist/nouislider.min.css') }}">
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
    .price-range-values {
      margin-top: 12px;
    }
    .btn-group-filter {
      display: flex;
      justify-content: center;
      gap: 12px;
    }
  </style>
@endsection

@section('js')
<script src="{{ asset('common/noUiSlider/dist/nouislider.min.js') }}"></script>
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
<script>
  $(document).ready(function() {
    var priceRange = document.getElementById('price-range');
    var priceMin = $('#price_min');
    var priceMax = $('#price_max');
    var priceRangeMin = $('#price-range-min');
    var priceRangeMax = $('#price-range-max');
    var priceAbove1M = $('#price_above_1m');

    noUiSlider.create(priceRange, {
      start: [priceMin.val() || 0, priceMax.val() || 20000000],
      connect: true,
      range: {
        'min': 0,
        '10%': 100000,
        '30%': 500000,
        '50%': 1000000,
        '70%': 5000000,
        '90%': 10000000,
        'max': 20000000
      },
      snap: true,
      format: {
        to: function (value) {
          return Math.round(value);
        },
        from: function (value) {
          return Number(value);
        }
      }
    });

    priceRange.noUiSlider.on('update', function (values, handle) {
      priceMin.val(values[0]);
      priceMax.val(values[1]);
      priceRangeMin.text(new Intl.NumberFormat().format(values[0]));
      priceRangeMax.text(new Intl.NumberFormat().format(values[1]));
    });

    // Update the slider values on page load
    priceRange.noUiSlider.set([priceMin.val() || 0, priceMax.val() || 20000000]);

    // Handle the checkbox state
    priceAbove1M.change(function() {
      if ($(this).is(':checked')) {
        priceRange.setAttribute('disabled', true);
        priceMin.val(1000001);
        priceMax.val(20000000); // Set a high value to cover all prices above 1 million
        priceRangeMin.text('1,000,001');
        priceRangeMax.text('20,000,000+');
      } else {
        priceRange.removeAttribute('disabled');
        priceRange.noUiSlider.set([priceMin.val() || 0, priceMax.val() || 20000000]);
      }
    });

    // Initialize the checkbox state
    if (priceAbove1M.is(':checked')) {
      priceRange.setAttribute('disabled', true);
      priceMin.val(1000001);
      priceMax.val(20000000);
      priceRangeMin.text('1,000,001');
      priceRangeMax.text('20,000,000+');
    }

    $('#clear-filters').click(function() {
      // Reset input fields
      $('input[name="name"]').val('');
      $('select[name="price"]').prop('selectedIndex', 0);
      $('select[name="type"]').prop('selectedIndex', 0);
      $('#price_min').val('');
      $('#price_max').val('');
      $('#price-range-min').text('');
      $('#price-range-max').text('');

      // Reset the price range slider
      if (priceRange.noUiSlider) {
        priceRange.noUiSlider.set([0, 20000000]);
      }

      window.location.href = "{{ route('products_page') }}";
    });
  });
</script>
@endsection
