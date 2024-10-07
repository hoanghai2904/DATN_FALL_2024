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
                            <label for="status_order">Trạng thái đơn hàng</label>
                            <select name="status_order" class="form-control" required>
                                <option value="Chưa giải quyết" {{ $order->status_order == 'Chưa giải quyết' ? 'selected' : '' }}>Chưa giải quyết</option>
                                <option value="Đã vận chuyển" {{ $order->status_order == 'Đã vận chuyển' ? 'selected' : '' }}>Đã vận chuyển</option>
                                <option value="Đã giao hàng" {{ $order->status_order == 'Đã giao hàng' ? 'selected' : '' }}>Đã giao hàng</option>
                                <option value="Đã hủy" {{ $order->status_order == 'Đã hủy' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </div>            
                        <div style="margin-top:10px">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                                            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Trở về</a>
                        </div>
                   
                </form>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div>
@endsection
