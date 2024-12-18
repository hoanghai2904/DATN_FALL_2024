@extends('layouts.master')

@section('title', 'Danh Sách Yêu Thích')

@section('content')

    <section class="bread-crumb">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home_page') }}">{{ __('Trang Chủ') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh Sách Yêu Thích</li>
            </ol>
        </nav>
    </section>

    <div class="site-wishlist">
        <section class="section-advertise">
            <div class="content-advertise">
                <div id="slide-advertise" class="owl-carousel">
                    @foreach ($advertises as $advertise)
                        <div class="slide-advertise-inner"
                            style="background-image: url('{{ Helper::get_image_advertise_url($advertise->image) }}');"
                            data-dot="<button>{{ $advertise->title }}</button>"></div>
                    @endforeach
                </div>
            </div>
        </section>

    <section class="section-wishlist">
        <div class="section-header">
            <h2 class="section-title">Danh Sách Yêu Thích <span>( {{ $wishlistItems->count() }} Sản Phẩm )</span></h2>
        </div>
        <div class="section-content">
            @if($wishlistItems->isEmpty())

                <p>Danh sách yêu thích của bạn đang trống.</p>
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                      <div class="cart-empty">
                       
                        <div class="btn-cart-empty">
                          <a href="{{ route('products_page') }}" title="Tiếp tục mua sắm">Tiếp Tục Mua Sắm</a>
                        </div>
                      </div>
                    </div>
                  </div>
            @else
            <section class="section-products">
                <div class="section-content">
                  <div class="product-container">
                    @foreach($wishlistItems as $item)
                    <div>
                      <div class="item-product">
                          <a href="{{ route('product_page', ['id' => $item->product->id]) }}" title="{{ $item->product->name }}">
                            <div class="image-product">
                               <img loading="lazy" src="{{ Helper::get_image_product_url($item->product->image) }}" style="width: 100%; height: 284px;" alt="{{ $item->product->name }}"
                                  onError="this.onerror=null; this.src='{{ asset('images/no_image.png') }}';" />
                            </div>
                            <div class="content-product">
                                <h3 class="title">{{ $item->product?->name }}</h3>
                                <div class="start-vote">
                                  {!! Helper::get_start_vote($item->product?->rate) !!}
                                </div>
                                <p style="font-weight: 600">Phân loại: {{$item?->color}}</p>
                                @if ($item?->size)
                                    <p style="font-weight: 600">Size: {{$item?->size}}</p>
                                @endif
                                <div class="price">
                                  {!! Helper::get_real_price($item->sale_price, $item->promotion_price, $item->promotion_start_date, $item->promotion_end_date) !!}
                                </div>
                            </div>
                          </a>
                      </div>
                    </div>
                       
                    @endforeach
                  </div>
                </div>
            </section>
            @endif
        </div>
    </section>
</div>

@endsection
@section('css')
  <style>
    .btn-cart-empty a {
    display: block;
    width: fit-content;
    margin: 0 auto;
    padding: 10px;
    color: #fff;
    background: #f30;
    border-radius: 5px;
    font-size: 18px;
    font-weight: 600;
}
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
  <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
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
  <script src="{{ asset('js/cart.js') }}"></script>
@endsection
