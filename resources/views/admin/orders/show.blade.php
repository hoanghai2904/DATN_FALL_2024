@extends('admin.layouts.master')

@section('title', 'Chi tiết đơn hàng')

@section('content')
    <div class="container">
        <h1 class="my-4">Chi tiết đơn hàng #{{ $order->order_code }}</h1>

        <!-- Phần danh sách sản phẩm -->
        <div class="row">
            <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header">
                        <div class="d-flex align-items-center">
                                        <h5 class="card-title flex-grow-1 mb-0">Danh sách đơn hàng</h5>
                                        <div class="flex-shrink-0">
                                            <a href="{{ route('admin.orders.invoice', $order->id) }}" class="btn btn-success btn-sm"><i class="ri-download-2-fill align-middle me-1"></i> Invoice</a>
                                        </div>
                                    </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>SKU</th>
                                        <th>Size</th>
                                        <th>Màu sắc</th>
                                        <th>Giá (VND)</th>
                                        <th>Số lượng</th>
                                        <th>Tổng (VND)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($orderItems && $orderItems->count() > 0)
                                        @foreach($orderItems as $item)
                                            <tr>
                                                <td>{{ $item->product_name }}</td>
                                                <td>{{ $item->product_sku }}</td>
                                                <td>{{ $item->variant_size_name }}</td>
                                                <td>{{ $item->variant_color_name }}</td>
                                                <td>{{ number_format($item->product_price, 0, ',', '.') }}₫</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ number_format($item->product_price * $item->qty, 0, ',', '.') }}₫</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">Không có sản phẩm nào trong đơn hàng.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <!-- Phần hiển thị tổng tiền và giảm giá -->
                            <div class="row text-end">
                                <div class="col-md-12">
                                    <p class="mb-3"><strong>Tổng số lượng:</strong> <span id="total-quantity">{{ $orderItems->sum('qty') }}</span></p>
                                    <p class="mb-3"><strong>Giảm giá:</strong> <span id="discount">{{ number_format($order->discount_price ?? 0, 0, ',', '.') }}₫</span></p>
                                    <p class="mb-3"><strong>Phí vận chuyển:</strong> <span id="shipping-fee">{{ number_format($order->shipping_fee, 0, ',', '.') }}₫</span></p>
                                    <h5 class="mb-3">Tổng tiền:</h5>
                                    <h5 class="text-danger" id="total-amount">{{ number_format($order->total_price, 0, ',', '.') }}₫</h5>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>



            <!-- Phần thông tin khách hàng và giao hàng -->
            <div class="col-md-4">
            <!-- Thông tin khách hàng -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white" style="padding: 10px 15px;">
                    <h5 class="mb-0" style="color:black">Thông tin khách hàng</h5>
                </div>
                <div class="card-body">
                    <p><strong>Tên khách hàng:</strong> {{ $order->user_name }}</p>
                    <p><strong>Email:</strong> {{ $order->user_email }}</p>
                    <p><strong>Số điện thoại:</strong> {{ $order->user_phone }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->user_address }}</p>
                </div>
            </div>

            <!-- Thông tin giao hàng -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin giao hàng</h5>
                </div>
                <div class="card-body">
                    <p><strong>Tên người nhận:</strong> {{ $order->user_name }}</p>
                    <p><strong>Số điện thoại người nhận:</strong> {{ $order->user_phone }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->user_address }}</p>
                    <p><strong>Phương thức:</strong> {{ $order->payment_method }}</p>
                    <p><strong>Ghi chú:</strong> {{ $order->shipping_note ?? 'Không có ghi chú' }}</p> <!-- Nếu có ghi chú -->
                </div>
            </div>

    <!-- Nút quay lại -->
    <div class="text-end">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại danh sách đơn hàng</a>
    </div>
</div>

        </div>
    </div>
@endsection