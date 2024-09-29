@extends('admin.layouts.master')

@section('title', 'Chỉnh sửa địa chỉ')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Chỉnh sửa địa chỉ</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                        <div class="form-group">
                            <label for="user_name">	Tên khách hàng: </label>
                            <input type="text" name="user_name" value="{{ $order->user_name }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="user_email">Email:</label>
                            <input type="email" name="user_email" value="{{ $order->user_email }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="user_phone">Số điện thoại:</label>
                            <input type="text" name="user_phone" value="{{ $order->user_phone }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="user_address">Địa chỉ</label>
                            <textarea name="user_address" class="form-control" required>{{ $order->user_address }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="status_order">Trạng thái đơn hàng</label>
                            <select name="status_order" class="form-control" required>
                                <option value="Chưa giải quyết" {{ $order->status_order == 'Chưa giải quyết' ? 'selected' : '' }}>Chưa giải quyết</option>
                                <option value="Đã vận chuyển" {{ $order->status_order == 'Đã vận chuyển' ? 'selected' : '' }}>Đã vận chuyển</option>
                                <option value="Đã giao hàng" {{ $order->status_order == 'Đã giao hàng' ? 'selected' : '' }}>Đã giao hàng</option>
                                <option value="Đã hủy" {{ $order->status_order == 'Đã hủy' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="shipping_fee">Phí vận chuyển</label>
                            <input type="number" name="shipping_fee" value="{{ $order->shipping_fee }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="total_price">Tổng giá</label>
                            <input type="number" name="total_price" value="{{ $order->total_price }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="discount_price">Giá giảm giá</label>
                            <input type="number" name="discount_price" value="{{ $order->discount_price }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="payment_method">Phương thức thanh toán</label>
                            <select name="payment_method" class="form-control" required>
                                <option value="Thanh toán khi nhận hàng" {{ $order->payment_method == 'Thanh toán khi nhận hàng' ? 'selected' : '' }}>Thanh toán khi nhận hàng</option>
                                <option value="Chuyển Khoản" {{ $order->payment_method == 'Chuyển Khoản' ? 'selected' : '' }}>Chuyển Khoản</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Order</button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Trở về</a>
                </form>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div>
@endsection
