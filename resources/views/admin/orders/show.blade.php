<!-- resources/views/orders/show.blade.php -->
@extends('admin.layouts.master')

@section('title', 'Chi tiết đơn hàng')

@section('content')
    <div class="container">
        <h1>Chi tiết đơn hàng #{{ $order->id }}</h1>
        
        <!-- Thông tin khách hàng -->
        <div class="card mb-3">
            <div class="card-header">Thông tin khách hàng</div>
            <div class="card-body">
                <p><strong>Tên:</strong> {{ $order->user_name }}</p>
                <p><strong>Email:</strong> {{ $order->user_email }}</p>
                <p><strong>Số điện thoại:</strong> {{ $order->user_phone }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->user_address }}</p>
                <p><strong>Ghi chú:</strong> {{ $order->user_note }}</p>
                <p><strong>Trạng thái:</strong> {{ $order->status_order }}</p>
                <p><strong>Phí vận chuyển:</strong> {{ number_format($order->shipping_fee, 2) }} VNĐ</p>
                <p><strong>Tổng tiền:</strong> {{ number_format($order->total_price, 2) }} VNĐ</p>
                <p><strong>Giảm giá:</strong> {{ number_format($order->discount_price, 2) }} VNĐ</p>
                <p><strong>Phương thức thanh toán:</strong> {{ $order->payment_method }}</p>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="card mb-3">
            <div class="card-header">Danh sách sản phẩm</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>SKU</th>
                            <th>Hình ảnh</th>
                            <th>Giá</th>
                            <th>Giá khuyến mãi</th>
                            <th>Số lượng</th>
                            <th>Kích thước</th>
                            <th>Màu sắc</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderItems as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->product_sku }}</td>
                                <td><img src="{{ $item->product_thumbnail }}" alt="{{ $item->product_name }}" style="width: 50px;"></td>
                                <td>{{ number_format($item->product_price, 2) }} VNĐ</td>
                                <td>{{ number_format($item->product_price_sale, 2) }} VNĐ</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->variant_size_name }}</td>
                                <td>{{ $item->variant_color_name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quay lại danh sách đơn hàng -->
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại danh sách đơn hàng</a>
    </div>
@endsection
