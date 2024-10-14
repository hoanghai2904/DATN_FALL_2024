@extends('admin.layouts.master')

@section('title')
  đơn hàng
@endsection

@section('style-libs')
    <!-- Custom styles for this page -->
    <link href="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('script-libs')
    <!-- Page level plugins -->
    <script src="{{ asset('theme/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->


      <script src="{{ asset('theme/admin/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('theme/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('theme/admin/js/demo/datatables-demo.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
            $('.js-example-basic-single').select2();
        });
        
    </script>

@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Danh sách @yield('title')</h4>
            </div>
            <!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
              <!-- Form tìm kiếm -->
              <form action="{{ route('admin.orders.index') }}" method="GET">
                    <div class="row mb-5">
                        <!-- Ô tìm kiếm Mã đơn hàng -->
                        <div class="col-lg-3">
                            <h6 class="fw-semibold">Mã đơn hàng</h6>
                            <div class="input-group">
                                <input type="text" name="order_code" class="form-control" placeholder="Nhập mã đơn hàng" value="{{ request('order_code') }}">
                                <button type="submit" class="btn btn-primary">Áp dụng</button>
                            </div>
                        </div>

                        <!-- Ô tìm kiếm Tên khách hàng -->
                        <div class="col-lg-3">
                            <h6 class="fw-semibold">Tên khách hàng</h6>
                            <div class="input-group">
                                <input type="text" name="user_name" class="form-control" placeholder="Nhập tên khách hàng" value="{{ request('user_name') }}">
                                <button type="submit" class="btn btn-primary">Áp dụng</button>
                            </div>
                        </div>

                        <!-- Ô tìm kiếm chung -->
                        <div class="col-lg-3">
                            <h6 class="fw-semibold">Tìm kiếm chung</h6>
                            <div class="search-box w-100">
                                <input type="text" name="search" class="form-control search" placeholder="Search..." value="{{ request('search') }}">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>

                        <!-- Nút tìm kiếm -->
                        <div class="col-lg-3 d-flex align-items-end justify-content-end">
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        </div>
                    </div>
                </form>



                    <!-- Bảng danh sách đơn hàng -->
                    <div class="table-responsive table-card">
                        <table class="table table-sm align-middle table-nowrap table-striped-columns mb-0">
                            <thead class="table-light">
                                <tr>
                                <th scope="col" style="width: 46px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="cardtableCheck">
                                                <label class="form-check-label" for="cardtableCheck"></label>
                                            </div>
                                        </th>
                                    <th>ID</th>
                                    <th>Mã đơn hàng</th>
                                    <th>Tên khách hàng</th>
                                    <th>Email</th>
                                    <th>Thanh toán</th>
                                    <th>Trạng thái</th>
<<<<<<< HEAD
=======
                                    <th>Ngày</th>
                                    <th>Hành động</th>
>>>>>>> 4a675e8a8530ac82e872416461338d5b489da1b5
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->order_code }}</td>
                                    <td>{{ $order->user_name }}</td>
                                    <td>{{ $order->user_email }}</td>
                                    <td>{{ $order->payment_method }}</td>
                                    <td>{{ $order->status_order }}</td>
                                    <td>{{ $order->created_at}}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info">Chi tiết</a>
                                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-warning">Chỉnh sửa</a>
                                        @if ($order->status_order == 'Đã hủy')
                                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:inline;" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Xóa</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div>
<!-- end row -->
@endsection

