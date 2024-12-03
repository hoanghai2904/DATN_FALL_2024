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
                @foreach($advertises as $advertise)
                    <div class="slide-advertise-inner" style="background-image: url('{{ Helper::get_image_advertise_url($advertise->image) }}');" data-dot="<button>{{ $advertise->title }}</button>"></div>
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