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

    <div class="container my-5">
      
  <!-- Thông tin đơn hàng và Bảng sản phẩm -->
  <div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
      <h4 class="mb-0">Đơn Hàng: {{ $data['order']->order_code }}</h4>
      <span>Ngày tạo: {{ date_format($data['order']->created_at, 'd/m/Y') }}</span>
    </div>
    <div class="card-body p-4">
      <div class="row">
        <!-- Thông tin mua hàng - Bên trái -->
        <div class="col-md-4">
          <h3 class="text-primary border-bottom pb-2 mb-3">Thông Tin Mua Hàng</h3>
          <ul class="list-group list-group-flush order-info">
            <li class="list-group-item" style="display: flex; justify-content: space-between;"><strong style="font-size: 1.1em">Tên:</strong> <span>{{ $data['order']->name }}</span></li>
            <li class="list-group-item" style="display: flex; justify-content: space-between;"><strong style="font-size: 1.1em">Email:</strong> <span>{{ $data['order']->email }}</span></li>
            <li class="list-group-item" style="display: flex; justify-content: space-between;"><strong style="font-size: 1.1em">Số Điện Thoại:</strong> <span>{{ $data['order']->phone }}</span></li>
            <li class="list-group-item" style="display: flex; justify-content: space-between;"><strong style="font-size: 1.1em">Địa Chỉ:</strong> <span>{{ $data['order']->address }}</span></li>
            <li class="list-group-item" style="display: flex; justify-content: space-between;"><strong style="font-size: 1.1em">Phương Thức Thanh Toán:</strong> <span>{{ $data['order']->payment_method->name ?? 'Chưa xác định' }}</span></li>
            <li class="list-group-item" style="display: flex; justify-content: space-between; align-items: center;">
              <strong style="font-size: 1.1em">Trạng thái thanh toán:</strong> 
              <div class="d-flex flex-column align-items-end">
                <span class="badge {{ $data['order']->is_paid ? 'bg-success' : 'bg-warning' }}">{{ $data['order']->is_paid ? 'Đã thanh toán' : 'Chưa thanh toán' }}</span>
                @if (!$data['order']->is_paid && $data['order']->payment_method_id != 1 && $data['order']->status !== 8)
                  <form id="payment-form-{{ $data['order']->id }}" action="{{ route('payment_now', $data['order']->id) }}" method="POST" class="mt-2">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data['order']->id }}">
                    <button class="btn btn-primary btn-sm">Thanh toán ngay</button>
                  </form>
                @endif
              </div>
            </li>
            
            <li class="list-group-item" style="display: flex; justify-content: space-between; align-items: center;">
              <strong style="font-size: 1.1em">Trạng thái đơn hàng:</strong>
              <span class="badge 
                @switch($data['order']?->status)
                    @case(1)
                        bg-warning
                        @break
                    @case(2)
                        bg-info
                        @break
                    @case(3)
                        bg-primary
                        @break
                    @case(4)
                        bg-info
                        @break
                    @case(8)
                        bg-danger
                        @break
                    @case(6)
                        bg-success
                        @break
                @endswitch
              ">
                @switch($data['order']?->status)
                    @case(1)
                        Chờ xác nhận
                        @break
                    @case(2)
                        Đã xác nhận
                        @break
                    @case(3)
                        Đang chuẩn bị
                        @break
                    @case(4)
                        Đang giao hàng
                        @break
                    @case(8)
                        Đã hủy
                        @break
                    @case(6)
                        Đã nhận được hàng
                        @break
                @endswitch
              </span>
            </li>
            <li class="list-group-item" style="display: flex; justify-content: space-between;">
              <strong style="font-size: 1.1em">Trạng thái nhận hàng:</strong>
              <span class="badge {{ $data['order']->is_received ? 'bg-success' : 'bg-warning' }}">
                {{ $data['order']->is_received ? 'Đã nhận hàng' : 'Chưa nhận hàng' }}
              </span>
            </li>
          </ul>
          @if($data['order']->status == 4 && !$data['order']->is_received)
            <button class="btn btn-success mt-3 w-100" onclick="handleReceiveOrder({{ $data['order']->id }})">Đã nhận hàng</button>
          @endif
        </div>

        <!-- Bảng thông tin sản phẩm - Bên phải -->
        <div class="col-md-8">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead class="table-dark">
                <tr>
                  <th class="text-center" width="5%">STT</th>
                  <th class="text-center" width="15%">Mã Sản Phẩm</th>
                  <th class="text-center" width="25%">Tên Sản Phẩm</th>
                  <th class="text-center" width="15%">Loại</th>
                  <th class="text-center" width="10%">Số Lượng</th>
                  <th class="text-center" width="15%">Đơn Giá</th>
                  <th class="text-center" width="15%">Thành Tiền</th>
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
                    <td class="text-center">#{{ $order_detail->variants->product->sku_code }}</td>
                    <td>{{ $order_detail->variants->product->name }}</td>
                    <td class="text-center">
                        {{ implode('-', array_slice(explode('-', $order_detail->variants->sku), 1)) }}
                    </td>
                    <td class="text-center fw-bold">{{ $order_detail->quantity }}</td>
                    <td class="text-end text-price fw-bold fs-5">{{ number_format($order_detail->price, 0, ',', '.') }}₫</td>
                    <td class="text-end text-price fw-bold fs-5">{{ number_format($order_detail->price * $order_detail->quantity, 0, ',', '.') }}₫</td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot class="table-light border-top">
                <tr class="total-row">
                  <td colspan="4" class="text-end"><strong>Tổng Cộng:</strong></td>
                  <td class="text-center"><strong>{{ $totalQuantity }}</strong></td>
                  <td colspan="2" class="text-end text-price fw-bold fs-5"><strong>{{ number_format($totalAmount, 0, ',', '.') }}₫</strong></td>
                </tr>
                <tr>
                  <td colspan="5" class="text-end"><strong>Phí giao hàng:</strong></td>
                  <td colspan="2" class="text-end fw-bold fs-5"><strong>{{ number_format($data['order']?->fee, 0, ',', '.') }}₫</strong></td>
                </tr>
                <tr>
                  <td colspan="5" class="text-end"><strong>Giảm giá:</strong></td>
                  <td colspan="2" class="text-end fw-bold fs-5"><strong>{{ number_format($data['order']?->discount, 0, ',', '.') }}₫</strong></td>
                </tr>
                <tr class="table-primary total-row">
                  <td colspan="5" class="text-end">
                    <strong class="fs-3">Tổng Thanh Toán:</strong>
                  </td>
                  <td colspan="2" class="text-end">
                    <strong class="fs-2 text-danger">{{ number_format($totalAmount + $data['order']?->fee - $data['order']?->discount, 0, ',', '.') }}₫</strong>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('css')
    <style>
        .bread-crumb {
            background-color: #f5f5f5;
            padding: 20px 0;
            margin-bottom: 40px;
            border-bottom: 1px solid #eee;
        }

        .breadcrumb {
            margin-bottom: 0;
            padding: 0;
            font-size: 15px;
        }

        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.15) !important;
        }

        .card-header {
            background-color: #1a237e !important;
            padding: 1.5rem;
        }

        .card-header h4 {
            font-size: 1.4rem;
            font-weight: 600;
            margin: 0;
        }

        .list-group-item {
            padding: 18px 20px;
            border-left: none;
            border-right: none;
        }

        .list-group-item strong {
            color: #555;
        }

        .badge {
            padding: 10px 15px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.1rem !important;
            letter-spacing: 0.5px;
        }

        .btn {
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }

        .btn-success {
            background-color: #2ecc71;
            border-color: #2ecc71;
        }

        .btn-success:hover {
            background-color: #27ae60;
            border-color: #27ae60;
        }

        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead.table-dark th {
            background-color: #1a237e !important;
            color: #ffffff;
            padding: 1rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #eee;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tfoot {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .table tfoot td {
            padding: 1rem;
        }

        .text-price {
            color: #e74c3c;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .order-info span {
            font-weight: 500;
        }

        .total-row td {
            font-size: 1.1rem;
            font-weight: 600;
            background-color: #f8f9fa;
        }

        .table-primary td {
            background-color: #e3f2fd !important;
        }

        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start !important;
            }
            
            .card-header span {
                margin-top: 10px;
            }

            .table-responsive {
                font-size: 0.9rem;
            }
        }

        /* Thêm style cho các trạng thái */
        .bg-warning {
            background-color: #f1c40f !important;
            color: #000 !important;
            font-size: 1.1rem !important;
        }

        .bg-info {
            background-color: #3498db !important;
            color: #fff !important;
            font-size: 1.1rem !important;
        }

        .bg-primary {
            background-color: #2980b9 !important;
            color: #fff !important;
            font-size: 1.1rem !important;
        }

        .bg-danger {
            background-color: #e74c3c !important;
            color: #fff !important;
            font-size: 1.1rem !important;
        }

        .bg-success {
            background-color: #2ecc71 !important;
            color: #fff !important;
            font-size: 1.1rem !important;
        }

        /* Hiệu ứng hover cho badge */
        .badge:hover {
            opacity: 0.9;
        }

        /* Giữ màu đen cho header của bảng */
        .table thead.table-dark th {
            background-color: #212529 !important;
            color: #ffffff !important;
        }

        /* Giữ màu cho dòng tổng cộng */
        .table tfoot tr.table-primary td {
            background-color: #cfe2ff !important;
        }

        /* Style cho card thông tin mua hàng */
        .card-body {
            padding: 2rem;
        }

        /* Style cho tiêu đề */
        .card-body h3 {
            font-size: 1.5rem;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #3498db;
            font-weight: 600;
        }

        /* Style cho list group */
        .order-info {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .list-group-item {
            padding: 1.2rem 1.5rem;
            background: #f8f9fa;
            border: none;
            margin-bottom: 2px;
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            background: #f1f3f5;
        }

        .list-group-item strong {
            color: #34495e;
            font-size: 1rem;
            font-weight: 600;
            min-width: 180px;
            display: inline-block;
        }

        .list-group-item span {
            color: #2c3e50;
            font-weight: 500;
        }

        /* Style cho badge trạng thái */
        .badge {
            padding: 0.8rem 1.2rem;
            border-radius: 6px;
            font-size: 0.95rem !important;
            font-weight: 500;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Style cho button thanh toán */
        .btn-primary.btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            border-radius: 5px;
            margin-top: 0.5rem;
            font-weight: 500;
            text-transform: none;
            letter-spacing: 0.5px;
        }

        /* Style cho button đã nhận hàng */
        .btn-success {
            margin-top: 1.5rem;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 1px;
            box-shadow: 0 4px 6px rgba(46, 204, 113, 0.2);
        }

        .btn-success:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 8px rgba(46, 204, 113, 0.3);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }

            .list-group-item {
                padding: 1rem;
                flex-direction: column;
                align-items: flex-start !important;
            }

            .list-group-item strong {
                margin-bottom: 0.5rem;
            }

            .badge {
                padding: 0.6rem 1rem;
                font-size: 0.9rem !important;
            }
        }

        /* Style cho bảng sản phẩm */
        .table-responsive {
            border-radius: 15px 15px 0 0;
            background: #fff;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead.table-dark th {
            background-color: #1a237e !important;
            color: #ffffff;
            padding: 1rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #eee;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tfoot {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .table tfoot td {
            padding: 1rem;
        }

        .text-price {
            color: #e74c3c;
            font-weight: 600;
            font-size: 1.1rem;
        }

        /* Style cho đường kẻ phân cách */
        hr {
            margin: 0;
            border-top: 2px solid #eee;
        }

        /* Điều chỉnh card */
        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.15) !important;
        }

        .card-header {
            background-color: #1a237e !important;
            padding: 1.5rem;
        }

        .card-header h4 {
            font-size: 1.4rem;
            font-weight: 600;
            margin: 0;
        }

        /* Style cho dòng tổng cộng */
        .total-row td {
            font-size: 1.1rem;
            font-weight: 600;
            background-color: #f8f9fa;
        }

        .table-primary td {
            background-color: #e3f2fd !important;
        }

        /* Điều chỉnh layout cho 2 cột */
        .card-body {
            background-color: #fff;
        }

        /* Style cho cột thông tin mua hàng */
        .col-md-4 {
            border-right: 2px solid #eee;
            padding-right: 2rem;
        }

        /* Style cho cột bảng sản phẩm */
        .col-md-8 {
            padding-left: 2rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .col-md-4 {
                border-right: none;
                border-bottom: 2px solid #eee;
                padding-right: 15px;
                padding-bottom: 2rem;
                margin-bottom: 2rem;
            }
            
            .col-md-8 {
                padding-left: 15px;
            }
        }

        /* Style cho dòng Tổng Thanh Toán */
        .table-primary.total-row {
            background-color: #e3f2fd !important;
        }

        .table-primary.total-row td {
            padding: 1.5rem 1rem !important;
        }

        .table-primary.total-row .fs-3 {
            font-size: 1.8rem !important;
            color: #2c3e50;
        }

        .table-primary.total-row .fs-2 {
            font-size: 2rem !important;
            font-weight: 700 !important;
        }
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
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Thất bại!',
                            text: response.message
                        });
                    }
                }
            });
        }
    </script>
@endsection
