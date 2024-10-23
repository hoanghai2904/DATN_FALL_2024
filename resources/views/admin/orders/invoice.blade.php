@extends('admin.layouts.master')

@section('title')
  Đơn hàng
@endsection

@section('style-libs')
    <link href="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('script-libs')
<style>
    .card-body {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 15px; /* Điều chỉnh khoảng cách giữa các nút */
    }

    .btn {
        padding: 10px 20px; /* Tăng khoảng cách bên trong nút nếu cần */
    }

    .text-end {
        text-align: right; /* Căn chỉnh văn bản bên phải */
    }
</style>
    <script src="{{ asset('theme/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('theme/admin/vendor/select2/select2.min.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
            $('.js-example-basic-single').select2();
        });

        // Xử lý in
        document.getElementById('btn-print').addEventListener('click', function() {
            window.print();
        });
    </script>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xxl-9">
        <div class="card" id="demo">
            <div class="row">
     
                <div class="col-lg-12">
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-lg-3 col-6">
                                <p class="text-muted mb-2 text-uppercase fw-semibold">Mã đơn</p>
                                <h5 class="fs-14 mb-0">#VL<span id="invoice-no">{{ $order->order_code }}</span></h5>
                            </div>
                            <div class="col-lg-3 col-6">
                                <p class="text-muted mb-2 text-uppercase fw-semibold">Ngày</p>
                                <h5 class="fs-14 mb-0"><span id="invoice-date">{{ $order->created_at->format('d M, Y') }}</span> <small class="text-muted" id="invoice-time">{{ $order->created_at->format('h:i A') }}</small></h5>
                            </div>
                            <div class="col-lg-3 col-6">
                                <p class="text-muted mb-2 text-uppercase fw-semibold">Trạng thái thanh toán</p>
                                <span class="badge bg-success-subtle text-success fs-11" id="payment-status">{{ $order->status_order }}</span>
                            </div>
                            <div class="col-lg-3 col-6">
                                <p class="text-muted mb-2 text-uppercase fw-semibold">Tổng số tiền</p>
                                <h5 class="fs-14 mb-0"><span id="total-amount">{{ number_format($order->total_price, ) }}</span>₫</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card-body p-4 border-top border-top-dashed">
                        <div class="row g-3">
                            <div class="col-6">
                                <h6 class="text-muted text-uppercase fw-semibold mb-3">Địa chỉ thanh toán</h6>
                                <p class="fw-medium mb-2" id="billing-name">{{ $order->name }}</p>
                                <p class="text-muted mb-1" id="billing-address-line-1">{{ $order->user_address }}</p>
                                <p class="text-muted mb-1"><span>Số điện thoại: +</span><span id="billing-phone-no">{{ $order->	user_phone }}</span></p>
                                <p class="text-muted mb-0"><span>Chi tiết: </span><span id="billing-tax-no">{{ $order->user_note }}</span></p>
                            </div>
                            <div class="col-6">
                                <h6 class="text-muted text-uppercase fw-semibold mb-3">Địa chỉ giao hàng</h6>
                                <p class="fw-medium mb-2" id="billing-name">{{ $order->name }}</p>
                                <p class="text-muted mb-1" id="billing-address-line-1">{{ $order->user_address }}</p>
                                <p class="text-muted mb-1"><span>Số điện thoại: +</span><span id="billing-phone-no">{{ $order->	user_phone }}</span></p>
                                <p class="text-muted mb-0"><span>Chi tiết: </span><span id="billing-tax-no">{{ $order->user_note }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                <thead>
                                    <tr class="table-active">
                                        <th scope="col" style="width: 50px;">#</th>
                                        <th scope="col">Chi tiết sản phẩm</th>
                                        <th scope="col">Giá</th>
                                        <th scope="col">Giá giảm</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col" class="text-end">Tổng tiền</th>
                                    </tr>
                                </thead>
                                <tbody id="order-items-list">
                                    @foreach($orderItems as $index => $item)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $item->product_name}}</td>
                                            <td>{{ number_format($item->product_price) }}₫</td>
                                            <td>{{ number_format($item->product_price_sale) }}₫</td>
                                            <td>{{ $item->qty }}</td>
                                            <td class="text-end">{{ number_format($item->product_price_sale * $item->qty) }}₫</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-end">Tổng tiền:</th>
                                        <td class="text-end">{{ number_format($order->total_price) }}₫</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <div class="row text-end">
                                                <div class="col-md-12">
                                                    <p class="mb-3">
                                                        <strong>Tổng số lượng:</strong> 
                                                        <span id="total-quantity">{{ $orderItems->sum('qty') }}</span>
                                                    </p>
                                                    <p class="mb-3">
                                                        <strong>Giảm giá:</strong> 
                                                        <span id="discount">{{ number_format($order->discount_price ?? 0, 0, ',', '.') }}₫</span>
                                                    </p>
                                                    <p class="mb-3">
                                                        <strong>Phí vận chuyển:</strong> 
                                                        <span id="shipping-fee">{{ number_format($order->shipping_fee, 0, ',', '.') }}₫</span>
                                                    </p>
                                                    <h5 class="mb-3">Tổng tiền (sau khi áp dụng giảm giá và phí vận chuyển):</h5>
                                                    <h5 class="text-danger" id="total-amount-with-shipping">
                                                        {{ number_format($order->total_price - ($order->discount_price ?? 0) + $order->shipping_fee, 0, ',', '.') }}₫
                                                    </h5>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card-body p-4 text-end border-top border-top-dashed d-flex justify-content-end align-items-center gap-3">
                        <a href="javascript:window.print()" class="btn btn-success">
                            <i class="ri-printer-line align-bottom me-1"></i> In
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại </a>
                    </div>
                </div>
        
            </div>
        </div>
    </div>
</div>
@endsection
