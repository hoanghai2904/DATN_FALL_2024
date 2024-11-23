@extends('layouts.master')

@section('title', 'Trang Chủ')

@section('content')
  <div class="site-home">
    <section class="section-advertise">
      <div class="row">
        <div class="col-md-8">
          <div class="content-advertise">
            <div id="slide-advertise" class="owl-carousel">
              @foreach($data['advertises'] as $advertise)
                <div class="slide-advertise-inner" style="background-image: url('{{ Helper::get_image_advertise_url($advertise->image) }}');" data-dot="<button>{{ $advertise->title }}</button>"></div>
              @endforeach
            </div>
            <div class="custom-dots-slide-advertises"></div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="new-posts">
            <div class="posts-header">
              <h3 class="posts-title">TIN TỨC THÚ CƯNG</h3>
            </div>
            <div class="posts-content">
              @foreach($data['posts'] as $post)
                <div class="post-item">
                  <a href="{{ route('post_page', ['id' => $post->id]) }}" title="{{ $post->title }}">
                    <div class="row">
                      <div class="col-md-4 col-sm-3 col-xs-3 col-xs-responsive">
                        <div class="post-item-image">
                          <img loading="lazy" src="{{ Helper::get_image_post_url($post->image) }}" 
                              alt="Post Image" 
                              style="width: 100%; height: 50px; object-fit: contain;"
                              onError="this.onerror=null; this.src='{{ asset('images/no_image.png') }}';" />
                        </div>
                      </div>
                      <div class="col-md-8 col-sm-9 col-xs-9 col-xs-responsive">
                        <div class="post-item-content">
                          <h4 class="post-content-title">{{ $post->title }}</h4>
                          <p class="post-content-date">{{ date_format($post->created_at, 'h:i A d/m/Y') }}</p>
                        </div>
                      </div>
                    </div>
                  </a>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="section-favorite-products">
      <div class="section-header">
        <h2 class="section-title">SẢN PHẨM ƯA THÍCH</h2>
      </div>
      <div class="section-content">
        <div id="slide-favorite" class="owl-carousel">
          @foreach($data['favorite_products'] as $product)
          @if($product->rate >= 3.5)
            <div class="item-product">
              <a href="{{ route('product_page', ['id' => $product->id]) }}" title="{{ $product->name }}">
                <div class="image-product">
                  <img loading="lazy" src="{{ Helper::get_image_product_url($product->image) }}" 
                        alt="Product Image" 
                        style="width: 100%; height: 284px;"
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
              </a>
            </div>
            @endif 
          @endforeach
        </div>
      </div>
    </section>
    <section class="section-products">
      <div class="section-header">
        <div class="section-header-left">
          <h2 class="section-title">Sản Phẩm</h2>
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
        <div class="product-container">
          @foreach($data['products'] as $key => $product)
            <div>
              <div class="item-product">
                <a href="{{ route('product_page', ['id' => $product->id]) }}" title="{{ $product->name }}">
                  <div class="image-product">
                    <img loading="lazy" src="{{ Helper::get_image_product_url($product->image) }}" 
                        alt="Product Image" 
                        style="width: 100%; height: 284px;"
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
                </a>
              </div>
            </div>
          @endforeach
        </div>
      </div>
      <div style="display: flex; justify-content:center">
        {{ $data['products']->links() }}
      </div>
    </section>
  </div>
@endsection

@section('js')
  <script>
    $(document).ready(function(){
      $("#slide-advertise").owlCarousel({
        items: 1,
        autoplay: true,
        autoplayHoverPause: true,
        loop: true,
        nav: true,
        dots: true,
        dotsData: true,
        responsive:{
          0:{
            nav:false,
            dots: false
          },
          641:{
            nav:true,
            dots: true
          }
        },
        navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
        dotsContainer: '.custom-dots-slide-advertises'
      });

      $("#slide-favorite").owlCarousel({
        items: 5,
        autoplay: true,
        autoplayHoverPause: true,
        nav: true,
        dots: false,
        responsive:{
          0:{
              items:1,
              nav:false
          },
          480:{
              items:2,
              nav:false
          },
          769:{
              items:3,
              nav:true
          },
          992:{
              items:4,
              nav:true,
          },
          1200:{
              items:5,
              nav:true
          }
        },
        navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>']
      });

      @if(session('alert'))
        Swal.fire(
          '{{ session('alert')['title'] }}',
          '{{ session('alert')['content'] }}',
          '{{ session('alert')['type'] }}'
        )
      @endif
    });
  </script>
@endsection
