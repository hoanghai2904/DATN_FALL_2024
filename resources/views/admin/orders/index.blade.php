@extends('admin.layouts.master')

@section('title')
  đơn hàng
@endsection

@section('script-libs')
  
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
    <div class="row mb-4">
        <!-- Tìm kiếm chung -->
        <div class="col-lg-4 mb-3">
            <h6 class="fw-semibold">Tìm kiếm chung</h6>
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                <span class="input-group-text">
                    <i class="ri-search-line search-icon"></i>
                </span>
            </div>
        </div>
     
        <!-- Ngày bắt đầu -->
        <div class="col-lg-2 mb-3">
            <h6 class="fw-semibold">Ngày bắt đầu</h6>
            <div class="input-group">
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
        </div>
        <!-- Ngày kết thúc -->
        <div class="col-lg-2 mb-3">
            <h6 class="fw-semibold">Ngày kết thúc</h6>
            <div class="input-group">
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
        </div>
        <!-- Trạng thái đơn hàng -->
        <div class="col-lg-2 mb-3">
            <h6 class="fw-semibold">Trạng thái đơn hàng</h6>
            <div class="input-group">
                <select name="status_order" class="form-control">
                    <option value="">Tất cả</option>
                    <option value="Chưa giải quyết" {{ request('status_order') == 'Chưa giải quyết' ? 'selected' : '' }}>Chưa giải quyết</option>
                    <option value="Đang xử lý" {{ request('status_order') == 'Đang xử lý' ? 'selected' : '' }}>Đang xử lý</option>
                    <option value="Hoàn thành" {{ request('status_order') == 'Hoàn thành' ? 'selected' : '' }}>Hoàn thành</option>
                    <option value="Đã hủy" {{ request('status_order') == 'Đã hủy' ? 'selected' : '' }}>Đã hủy</option>
                </select>
            </div>
        </div>
        <!-- Nút tìm kiếm -->
        <div class="col-lg-2 mb-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </div>
    </div>
</form>


                    <!-- Bảng danh sách đơn hàng -->
                    <div class="table-responsive table-card mb-1">
                        <table class="table table-nowrap align-middle" id="myTable" >
                            <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th scope="col" style="width: 25px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                        </div>
                                    </th>
                                    <th class="sort" >Id</th>
                                    <th class="sort" >Mã đơn hàng</th>                     
                                    <th class="sort" >Ngày đặt hàng</th>
                                    <th class="sort" >Tổng tiền</th>
                                    <th class="sort" >Phương thức </th>
                                    <th class="sort" >Trạng thái </th>
                                    <th class="sort">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($orders as $order)
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="checkAll" value="option1">
                                            </div>
                                        </th>
                                        <td class="id">{{ $order->id }}</td>
                                        <td class="id">
                                            <a href="{{ route('admin.orders.show', $order->order_code) }}" class="fw-medium link-primary">#{{ $order->order_code }}</a>
                                        </td>
                                       
                                        <td class="created_at">
                                            {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}
                                        </td>
                                        <td class="total_price"> {{ number_format($order->total_price - ($order->discount_price ?? 0) + $order->shipping_fee, 0, ',', '.') }}₫</td>
                                        <td class="payment_method">{{ $order->payment_method }}</td>
                                        <td>{{ $order->status_order }}</td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-primary d-inline-block">
                                                        <i class="ri-eye-fill fs-16"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="text-primary d-inline-block edit-item-btn">
                                                        <i class="ri-pencil-fill fs-16"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                @if ($order->status_order == 'Đã hủy')
                                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:inline;" >
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-danger d-inline-block remove-item-btn " style="border: none; background: none;">
                                                            <i class="ri-delete-bin-5-fill fs-16"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                </li>

                                            </ul>
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
@push('script')
    <script>
        $(document).ready(function() {
            $(".js-example-basic-single").select2(),
                $(".js-example-basic-multiple").select2({
                    // placeholder: "Chọn danh mục",
                });
        });

        // DataTable 
        $(document).ready(function() {
            var table = $('#myTable').DataTable({
                "dom": '<"top">rt<"bottom"><"clear">',
                // "searching": false,
               
                "language": {
                    "emptyTable": "Không có dữ liệu phù hợp", // Thay đổi thông báo không có dữ liệu
                    "zeroRecords": "Không tìm thấy bản ghi nào phù hợp", // Thay đổi thông báo không có bản ghi tìm thấy
                    "infoEmpty": "Không có bản ghi để hiển thị", // Thông báo khi không có dữ liệu để hiển thị
                }
            });

            // Tìm kiếm
            $('#customSearchBox').on('keyup', function() {
                table.search(this.value).draw(); // Áp dụng tìm kiếm trên bảng
            });

        });

    </script>
@endpush