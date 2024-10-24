@extends('admin.layouts.master')

@section('title', 'Chi tiết đơn hàng')

@section('content')

        <!-- Phần danh sách sản phẩm -->
        <div class="row">
                <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">Danh sách đơn hàng</h5>
                        <div class="flex-shrink-0">
                            <a href="{{ route('admin.orders.invoice', $order->id) }}" class="btn btn-success btn-sm"><i class="ri-download-2-fill align-middle me-1"></i> In hóa đơn</a>
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
                                        <td>
                                            @if($item->product_price_sale)
                                                <span class="text-decoration-line-through">{{ number_format($item->product_price, 0, ',', '.') }}₫</span>
                                                <span class="text-danger">{{ number_format($item->product_price_sale, 0, ',', '.') }}₫</span>
                                            @else
                                                {{ number_format($item->product_price, 0, ',', '.') }}₫
                                            @endif
                                        </td>
                                        <td>{{ $item->qty }}</td>
                                        <td>
                                            @if($item->product_price_sale)
                                                {{ number_format($item->product_price_sale * $item->qty, 0, ',', '.') }}₫
                                            @else
                                                {{ number_format($item->product_price * $item->qty, 0, ',', '.') }}₫
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">Không có sản phẩm nào trong đơn hàng.</td>
                                </tr>
                            @endif
                    
                            <tr class="border-top border-top-dashed">
                                <td colspan="3"></td>
                                <td colspan="2" class="fw-medium p-0">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <td>Tổng tiền :</td>
                                                <td class="text-end">{{ number_format($order->total_amount) }}₫</td>
                                            </tr>
                                            <tr>
                                                <td>Khuyến mãi ({{ $order->discount }}) :</td>
                                                <td class="text-end">-{{ number_format($order->discount) }}₫</td>
                                            </tr>
                                            <tr>
                                                <td>Phí vận chuyển :</td>
                                                <td class="text-end">{{ number_format($order->shipping_fee) }}₫</td>
                                            </tr>
                                           
                                            <tr class="border-top border-top-dashed">
                                                <th scope="row">Số tiền phải trả (VND) :</th>
                                                <th class="text-end">{{ number_format($order->total_amount - ($order->discount ?? 0) + $order->shipping_fee, 0, ',', '.') }}₫</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Thêm hàng tổng tiền từ sản phẩm -->
                    <div class="row text-end">
                        <div class="col-md-12">
                            <h5 class="mb-3">Tổng tiền :</h5>
                            <h5 class="text-danger" id="total-product-amount">
                                {{ number_format($orderItems->sum(function($item) {
                                    return $item->product_price_sale ? $item->product_price_sale * $item->qty : $item->product_price * $item->qty;
                                }), 0, ',', '.') }}₫
                            </h5>
                        </div>
                    </div>

                    <!-- Phần hiển thị tổng tiền và giảm giá -->
                    <div class="row text-end">
                        <div class="col-md-12">
                            <p class="mb-3"><strong>Tổng số lượng:</strong> <span id="total-quantity">{{ $orderItems->sum('qty') }}</span></p>
                            <p class="mb-3"><strong>Giảm giá:</strong> <span id="discount">{{ number_format($order->discount_price ?? 0, 0, ',', '.') }}₫</span></p>
                            <p class="mb-3"><strong>Phí vận chuyển:</strong> <span id="shipping-fee">{{ number_format($order->shipping_fee, 0, ',', '.') }}₫</span></p>
                            <h5 class="mb-3">Tổng tiền (sau khi áp dụng giảm giá và phí vận chuyển):</h5>
                            <h5 class="text-danger" id="total-amount-with-shipping">
                                {{ number_format($order->total_price - ($order->discount_price ?? 0) + $order->shipping_fee, 0, ',', '.') }}₫
                            </h5>
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