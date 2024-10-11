@extends('admin.layouts.master')

@section('title', 'Cập nhật trạng thái')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Cập nhật trạng thái</h4>
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
                            <label for="payment_method">Phương thức thanh toán</label>
                            <select name="payment_method" class="form-control" required>
                                <option value="Thanh toán khi nhận hàng" {{ $order->payment_method == 'Thanh toán khi nhận hàng' ? 'selected' : '' }}>Thanh toán khi nhận hàng</option>
                                <option value="Chuyển Khoản" {{ $order->payment_method == 'Chuyển Khoản' ? 'selected' : '' }}>Chuyển Khoản</option>
                                <option value="Đã thanh toán" {{ $order->payment_method == 'Đã thanh toán' ? 'selected' : '' }}>Đã thanh toán</option>
                            </select>
                        </div>  
                        <div class="form-group">
                            <label for="status_order">Trạng thái đơn hàng</label>
                            <select name="status_order" class="form-control" required>
                                <option value="Chưa giải quyết" {{ $order->status_order == 'Chưa giải quyết' ? 'selected' : '' }}>Chưa giải quyết</option>
                                <option value="Đang xử lý" {{ $order->status_order == 'Đang xử lý' ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="Hoàn thành" {{ $order->status_order == 'Hoàn thành' ? 'selected' : '' }}>Hoàn thành</option>
                                <option value="Đã hủy" {{ $order->status_order == 'Đã hủy' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </div>             
                        <div style="margin-top:10px">
                                <button type="submit" class="btn btn-primary" onclick="return confirm('Bạn có chắc chắn muốn sửa đơn hàng này?')">Cập nhật</button>
                                            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Trở về</a>
                        </div>
                   
                </form>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div>
@endsection
