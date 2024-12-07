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
          <ul class="list-group order-info">
            <li class="list-group-item"><span>Tên:</span> {{ $data['order']->user->name }}</li>
            <li class="list-group-item"><span>Email:</span> {{ $data['order']->user->email }}</li>
            <li class="list-group-item"><span>Số Điện Thoại:</span> {{ $data['order']->user->phone }}</li>
            <li class="list-group-item"><span>Địa Chỉ:</span> {{ $data['order']->user->address }}</li>
          </ul>
          @if($data['order']->status == 4 && !$data['order']->is_received)
            <button class="btn btn-success" onclick="handleReceiveOrder({{ $data['order']->id }})">Đã nhận hàng</button>
          @endif
        </div>
        
        <!-- Thông tin mua hàng -->
        <div class="col-md-6 mb-3">
          <h6>Thông Tin Mua Hàng</h6>
          <ul class="list-group order-info">
            <li class="list-group-item"><span>Tên:</span> {{ $data['order']->name }}</li>
            <li class="list-group-item"><span>Email:</span> {{ $data['order']->email }}</li>
            <li class="list-group-item"><span>Số Điện Thoại:</span> {{ $data['order']->phone }}</li>
            <li class="list-group-item"><span>Địa Chỉ:</span> {{ $data['order']->address }}</li>
            <li class="list-group-item"><span>Phương Thức Thanh Toán:</span> {{ $data['order']->payment_method->name ?? 'Chưa xác định' }}</li>
            <li class="list-group-item">
              <span>Trạng thái thanh toán:</span> {{ $data['order']->is_paid ? 'Đã thanh toán' : "Chưa thanh toán" }}
              @if (!$data['order']->is_paid && $data['order']->payment_method_id != 1)
                  <form id="payment-form-{{ $data['order']->id }}" action="{{ route('payment_now', $data['order']->id) }}" method="POST" style="display: none;">
                      @csrf
                      <input type="hidden" name="id" value="{{ $data['order']->id }}">
                  </form>
                  <button class="btn btn-primary ml-5" onclick="document.getElementById('payment-form-{{ $data['order']->id }}').submit();">Thanh toán ngay</button>
              @endif
            </li>
            <li class="list-group-item">
              <span>Trạng thái đơn hàng:</span>
                @switch($data['order']?->status)
                    @case(1)
                          <span class="label label-warning">Chờ xác nhận</span>
                        @break
                    @case(2)
                      <span class="label label-warning">Đã xác nhận</span>
                      @break
                    @case(3)
                        <span class="label label-primary">Đang chuẩn bị</span>
                        @break
                    @case(4)
                        <span class="label label-success">Đang giao hàng</span>
                        @break
                    @case(8)
                        <span class="label label-danger">Đã hủy</span>
                        @break
                    @case(6)
                        <span class="label label-success">Đã nhận được hàng</span>
                        @break
                @endswitch
            </li>
            <li class="list-group-item"><span>Trạng thái nhận hàng:</span> {{ $data['order']->is_received ? 'Đã nhận hàng' : 'Chưa nhận hàng' }}
            </td>
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
        <tr>
          <th colspan="5" class="text-end">Phí giao hàng</th>
          <th colspan="2" class="text-center text-danger">{{ number_format($data['order']?->fee, 0, ',', '.') }}₫</th>
        </tr>
        <tr>
          <th colspan="5" class="text-end">Giảm giá</th>
          <th colspan="2" class="text-center text-danger">{{ number_format($data['order']?->discount, 0, ',', '.') }}₫</th>
        </tr>
        <tr>
          <th colspan="5" class="text-end">
            <strong>Tổng Thanh Toán</strong>
          </th>
          <th colspan="2" class="text-center text-danger">
            <strong class="final-total">{{ number_format($totalAmount + $data['order']?->fee - $data['order']?->discount, 0, ',', '.') }}₫</strong>
          </th>
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
    .order-info span {
      font-weight: bold;
    }
    .final-total {
      font-size: 20px;
    }
  </style>
</style>
@endsection

@section('js')
  <script>
    const handleReceiveOrder = (id) => {
      $.ajax({
          url: "{{ route('receive_order', ['id' => ':id']) }}".replace(':id', id),
          method: 'POST',
          data: {
            id: id,
            _token: `{{ csrf_token() }}`
          },
          success: function(response) {
            if (response.status) {
              Swal.fire(
                'Thành công!',
                response.message,
                'success'
              ).then(() => {
                location.reload();
              });
            } else {
              Swal.fire(
                'Thất bại!',
                response.message,
                'error'
              );
            }
          }
        });
    }
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
