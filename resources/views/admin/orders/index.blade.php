@extends('admin.layouts.master')

@section('title')
đơn hàng
@endsection

@section('script-libs')

<script>
    $(document).ready(function () {
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
                                    <input type="text" name="search" class="form-control" placeholder="Search..."
                                        value="{{ request('search') }}">
                                    <span class="input-group-text">
                                        <i class="ri-search-line search-icon"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Ngày bắt đầu -->
                            <div class="col-lg-2 mb-3">
                                <h6 class="fw-semibold">Ngày bắt đầu</h6>
                                <div class="input-group">
                                    <input type="date" name="start_date" class="form-control"
                                        value="{{ request('start_date') }}">
                                </div>
                            </div>
                            <!-- Ngày kết thúc -->
                            <div class="col-lg-2 mb-3">
                                <h6 class="fw-semibold">Ngày kết thúc</h6>
                                <div class="input-group">
                                    <input type="date" name="end_date" class="form-control"
                                        value="{{ request('end_date') }}">
                                </div>
                            </div>
                            <!-- Trạng thái đơn hàng -->
                            <div class="col-lg-2 mb-3">
                                <h6 class="fw-semibold">Trạng thái đơn hàng</h6>
                                <div class="input-group">
                                    <select name="status_order" class="form-control">
                                        <option value="">Tất cả</option>
                                        <option value="Hoàn thành" {{ request('status_order')=='Hoàn thành' ? 'selected'
                                            : '' }}>Hoàn thành</option>
                                        <option value="Đang xử lý" {{ request('status_order')=='Đang xử lý' ? 'selected'
                                            : '' }}>Đang xử lý</option>
                                        <option value="Hoàn thành" {{ request('status_order')=='Hoàn thành' ? 'selected'
                                            : '' }}>Hoàn thành</option>
                                        <option value="Hoàn thànhhủy" {{ request('status_order')=='Hoàn thànhhủy'
                                            ? 'selected' : '' }}>Hoàn thànhhủy</option>
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
                        <table class="table table-nowrap align-middle" id="myTable">
                            <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th scope="col" style="width: 25px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll"
                                                value="option">
                                        </div>
                                    </th>

                                    <th class="sort">Mã đơn hàng</th>
                                    <th class="sort">Ngày đặt hàng</th>
                                    <th class="sort">Tổng tiền</th>
                                    <th class="sort">Phương thức </th>
                                    <th class="sort">Trạng thái </th>
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
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="fw-medium link-primary">#{{ $order->order_code }}</a>
                                        </td>
                                        <td class="user_name">{{ $order->user_name }}</td>
                                        <td class="user_email">{{ $order->user_email }}</td>
                                        <td class="created_at">
                                                    {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }},
                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($order->created_at)->format('H:i') }}</small>
                                                </td>

                                        <td class="total_price">${{ $order->total_price }}</td>
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
                                                <form action="{{ route('admin.orders.destroy', $order->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('admin.orders.destroy', $order->id) }}" 
                                                        class="text-danger d-inline-block remove-item-btn delete-item">
                                                        <i class="ri-delete-bin-5-fill fs-16 delete-item"></i>
                                                    </a>
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
        <div class="card-footer">
    {{ $orders->links() }} <!-- Hiển thị các liên kết phân trang -->
</div>
    </div><!-- end col -->
</div>
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Cập nhật trạng thái</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            <div class="modal-body">
                <!-- Form cập nhật trạng thái đơn hàng -->
                <form method="POST">
                    @csrf
                    @method('PUT') <!-- Sử dụng method PUT để cập nhật -->

                    <!-- Hiển thị lỗi nếu có -->
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
                        <label for="delivered-status">Trạng thái đơn hàng</label>
                        <select name="status_order" id="delivered-status" class="form-control" required>
                            <option value="Chưa giải quyết">Chưa giải quyết</option>
                            <option value="Đang xử lý">Đang xử lý</option>
                            <option value="Hoàn thành">Hoàn thành</option>
                            <option value="Đã hủy">Đã hủy</option>
                        </select>
                    </div>

                    <div style="margin-top:10px">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- modal delete --}}
    <div id="deleteCustomer" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                            colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Xóa tài khoản</h4>
                            <p class="text-muted mx-4 mb-0">Bạn có muốn xóa tài khoản này không ?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn w-sm btn-danger" id="confirmDelete">Đồng ý</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

<!-- end row -->
@endsection
@push('script')
<script>
    $(document).ready(function () {
        $(".js-example-basic-single").select2(),
            $(".js-example-basic-multiple").select2({
                // placeholder: "Chọn danh mục",
            });
    });

    // DataTable 
    $(document).ready(function () {
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
        $('#customSearchBox').on('keyup', function () {
            table.search(this.value).draw(); // Áp dụng tìm kiếm trên bảng
        });

    });
    // edit from 
    $(document).on('click', '.edit-item-btn', function () {
        var orderId = $(this).data('id');  // Lấy ID đơn hàng từ nút Edit
        var orderStatus = $(this).data('status');  // Lấy trạng thái đơn hàng từ nút Edit

        // Cập nhật action của form với đường dẫn và ID đơn hàng
        $('form').attr('action', '/admin/orders/' + orderId);  // Route để cập nhật theo ID

        // Gán trạng thái đơn hàng vào select box
        $('#delivered-status').val(orderStatus);

        // Mở modal
        $('#showModal').modal('show');
    });
     // Hàm hiển thị modal xác nhận xóa
     let deleteCustomerId;

        function showDeleteModal(customerId) {
            deleteCustomerId = customerId; // Lưu ID khách hàng vào biến
            $('#deleteCustomer').modal('show'); // Hiển thị modal xác nhận
            $('#confirmDelete').on('click', function() {
                if (deleteCustomerId) {
                    // Thực hiện yêu cầu xóa qua AJAX
                    fetch('{{ route('admin.deleteCustomer', ':id') }}'.replace(':id', deleteCustomerId), {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                $('#deleteCustomer').modal('hide'); // Ẩn modal
                                // Cập nhật danh sách khách hàng (có thể reload trang hoặc xóa hàng từ table)
                                location.reload(); // Tải lại trang sau khi xóa
                            } else {
                                alert('Xóa tài khoản không thành công!');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Có lỗi xảy ra trong quá trình xóa.');
                        });
                }
            });
        }

    $(document).ready(function() {
        // CSRF Token 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // End CSRF Token

        // Sweet Alert 
        $('body').on('click', '.delete-item', function(event) {
            event.preventDefault();

            let deleteUrl = $(this).closest('form').attr('action'); // Lấy URL từ form

            Swal.fire({
                title: 'Bạn có chắc muốn xóa không ?',
                text: "Bạn có thể khôi phục lại được dữ liệu!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: deleteUrl,
                        success: function(data) {
                            if (data.status == 'success') {
                                Swal.fire(
                                    'Đã xóa!',
                                    data.message,
                                    'success'
                                )
                                setTimeout(() => {
                                    window.location.reload(); // Tải lại trang sau khi xóa
                                }, 2000);
                            } else if (data.status == 'error') {
                                Swal.fire(
                                    'Không thể xóa',
                                    data.message,
                                    'error'
                                )
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            });
        });
    });

</script>
@endpush