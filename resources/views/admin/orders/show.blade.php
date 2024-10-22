@extends('admin.layouts.master')

@section('title', 'Chi tiết đơn hàng')

@section('content')
    <div class="container">
   

        <!-- Phần danh sách sản phẩm -->
        <div class="row">
                <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">Danh sách đơn hàng #{{ $order->order_code }}</h5>
                        <div class="flex-shrink-0">
                            <a href="{{ route('admin.orders.invoice', $order->id) }}" class="btn btn-success btn-sm"><i class="ri-download-2-fill align-middle me-1"></i> In hóa đơn</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered ">
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
<div class="card">
    <div class="card-header" style="padding: 10px 15px;">
        <div class="d-flex">
            <h5 class="card-title flex-grow-1 mb-0">Thông tin khách hàng</h5>
            <div class="flex-shrink-0">
                <a href="javascript:void(0);" class="link-secondary">Thông tin</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <ul class="list-unstyled mb-0 vstack gap-3">
            <li>
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('storage/' . auth()->user()->cover) }}" alt="" class="avatar-sm rounded me-3">
                    <div>
                        <h6 class="fs-14 mb-1">{{ $order->user_name }}</h6>
                        <p class="text-muted mb-0">Khách hàng</p>
                    </div>
                </div>
            </li>
            <li><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i>{{ $order->user_email }}</li>
            <li><i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>{{ $order->user_phone }}</li>
        </ul>
    </div>
</div>

<!-- Thông tin giao hàng -->
<div class="card mb-4">
    <div class="card-header" style="padding: 10px 15px;">
        <h5 class="mb-0">Thông tin giao hàng</h5>
    </div>
    <div class="card-body">
        <ul class="list-unstyled mb-0 vstack gap-3">
            <li>
                <div class="d-flex align-items-center mb-3">
                    <i class="ri-user-line me-2 align-middle text-muted fs-16"></i>
                    <strong>Tên người nhận:</strong> {{ $order->user_name }}
                </div>
            </li>
            <li>
                <div class="d-flex align-items-center mb-3">
                    <i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>
                    <strong>Số điện thoại người nhận:</strong> {{ $order->user_phone }}
                </div>
            </li>
            <li>
                <div class="d-flex align-items-center mb-3">
                    <i class="ri-map-pin-line me-2 align-middle text-muted fs-16"></i>
                    <strong>Địa chỉ:</strong> {{ $order->user_address }}
                </div>
            </li>
            <li>
                <div class="d-flex align-items-center mb-3">
                    <i class="ri-money-dollar-circle-line me-2 align-middle text-muted fs-16"></i>
                    <strong>Phương thức:</strong> {{ $order->payment_method }}
                </div>
            </li>
            <li>
                <div class="d-flex align-items-center mb-3">
                    <i class="ri-notes-line me-2 align-middle text-muted fs-16"></i>
                    <strong>Ghi chú:</strong> {{ $order->shipping_note ?? 'Không có ghi chú' }}
                </div>
            </li>
        </ul>
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