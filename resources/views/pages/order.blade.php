@extends('layouts.master')

@section('title', $data['order']->order_code)

@section('content')
<section class="bread-crumb">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home_page') }}">Trang Chủ</a></li>
      <li class="breadcrumb-item"><a href="{{ route('orders_page') }}">Đơn Hàng</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $data['order']->order_code }}</li>
    </ol>
  </nav>
</section>

<div class="container my-4">
  <!-- Section quảng cáo -->
  <section class="section-advertise">
    <div class="content-advertise">
      <div id="slide-advertise" class="owl-carousel">
        @foreach($data['advertises'] as $advertise)
          <div class="slide-advertise-inner" style="background-image: url('{{ Helper::get_image_advertise_url($advertise->image) }}');" data-dot="<button>{{ $advertise->title }}</button>"></div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Thông tin đơn hàng -->
  <div class="card my-4">
    <div class="card-header d-flex justify-content-between">
      <h5>Đơn Hàng: {{ $data['order']->order_code }}</h5>
      <span>Ngày tạo: {{ date_format($data['order']->created_at, 'd/m/Y') }}</span>
    </div>
    <div class="card-body">
      <div class="row">
        <!-- Thông tin tài khoản -->
        <div class="col-md-6 mb-3">
          <h6>Thông Tin Tài Khoản</h6>
          <ul class="list-group">
            <li class="list-group-item">Tên: {{ $data['order']->user->name }}</li>
            <li class="list-group-item">Email: {{ $data['order']->user->email }}</li>
            <li class="list-group-item">Số Điện Thoại: {{ $data['order']->user->phone }}</li>
            <li class="list-group-item">Địa Chỉ: {{ $data['order']->user->address }}</li>
          </ul>
        </div>
        
        <!-- Thông tin mua hàng -->
        <div class="col-md-6 mb-3">
          <h6>Thông Tin Mua Hàng</h6>
          <ul class="list-group">
            <li class="list-group-item">Tên: {{ $data['order']->name }}</li>
            <li class="list-group-item">Email: {{ $data['order']->email }}</li>
            <li class="list-group-item">Số Điện Thoại: {{ $data['order']->phone }}</li>
            <li class="list-group-item">Địa Chỉ: {{ $data['order']->address }}</li>
            <li class="list-group-item">Phương Thức Thanh Toán: {{ $data['order']->payment_method->name ?? 'Chưa xác định' }}</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Bảng thông tin sản phẩm -->
  <div class="table-responsive mb-4">
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th class="text-center">STT</th>
          <th class="text-center">Mã Sản Phẩm</th>
          <th class="text-center">Tên Sản Phẩm</th>
          <th class="text-center">Màu Sắc</th>
          <th class="text-center">Số Lượng</th>
          <th class="text-center">Đơn Giá</th>
          <th class="text-center">Thành Tiền</th>
        </tr>
      </thead>
      <tbody>
        @php
          $totalQuantity = 0;
          $totalAmount = 0;
        @endphp
        @foreach($data['order']->order_details as $key => $order_detail)
          @php
            $totalQuantity += $order_detail->quantity;
            $totalAmount += $order_detail->price * $order_detail->quantity;
          @endphp
          <tr>
            <td class="text-center">{{ $key + 1 }}</td>
            <td class="text-center">#{{ $order_detail->product_detail->product->sku_code }}</td>
            <td class="text-center">{{ $order_detail->product_detail->product->name }}</td>
            <td class="text-center">{{ $order_detail->product_detail->color }}</td>
            <td class="text-center">{{ $order_detail->quantity }}</td>
            <td class="text-center text-danger">{{ number_format($order_detail->price, 0, ',', '.') }}₫</td>
            <td class="text-center text-danger">{{ number_format($order_detail->price * $order_detail->quantity, 0, ',', '.') }}₫</td>
          </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th colspan="4" class="text-end">Tổng Cộng</th>
          <th class="text-center">{{ $totalQuantity }}</th>
          <th colspan="2" class="text-center text-danger">{{ number_format($totalAmount, 0, ',', '.') }}₫</th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
@endsection

@section('css')
<style>
  .carousel-item {
    height: 300px;
  }
  .carousel-item img {
    object-fit: cover;
  }

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
