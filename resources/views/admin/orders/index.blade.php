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
                    <form action="{{ route('admin.orders.index') }}" method="get">
                        @csrf
                        <div class="row mb-2">
                            <!-- Tìm kiếm chung -->
                            <div class="col-lg-2 mb-3">
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
                                    <select name="order_status" class="form-control">
                                        <option value="">Tất cả</option>
                                        <option value="Đang xử lí" {{ request('order_status') == 'Đang xử lí' ? 'selected' : '' }}>
                                            Đang xử lý
                                        </option>
                                        <option value="Đang giao" {{ request('order_status') == 'Đang giao' ? 'selected' : '' }}>
                                            Đang giao
                                        </option>
                                        <option value="Hoàn thành" {{ request('order_status') == 'Hoàn thành' ? 'selected' : '' }}>
                                            Hoàn thành
                                        </option>
                                        <option value="Đã hủy" {{ request('order_status') == 'Đã hủy' ? 'selected' : '' }}>
                                            Hủy đơn
                                        </option>
                                    </select>
                                </div>
                            </div>
                    
                            <!-- Trạng thái thanh toán -->
                            <div class="col-lg-2 mb-3">
                                <h6 class="fw-semibold">Trạng thái thanh toán</h6>
                                <div class="input-group">
                                    <select name="payment_status" class="form-control">
                                        <option value="">Tất cả</option>
                                        <option value="Đã thanh toán" {{ request('payment_status') == 'Đã thanh toán' ? 'selected' : '' }}>
                                            Đã thanh toán
                                        </option>
                                        <option value="Chưa thanh toán" {{ request('payment_status') == 'Chưa thanh toán' ? 'selected' : '' }}>
                                            Chưa thanh toán
                                        </option>
                                    </select>
                                </div>
                            </div>
                    
                            <!-- Nút tìm kiếm -->
                            <div class="col-lg-2 mb-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-info">
                                    <i class="ri-filter-3-line align-bottom me-1"></i> Tìm kiếm
                                </button>
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
                                            <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                        </div>
                                    </th>
                                    <th class="sort">Mã đơn hàng</th>
                                    <th class="sort">Tổng tiền</th>
                                    <th class="sort">Phương thức</th>
                                    <th class="sort">Trạng thái thanh toán</th>
                                    <th class="sort">Trạng thái giao hàng</th>
                                    <th class="sort">Ngày đặt hàng</th>
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
                        
                                    <!-- Mã đơn hàng -->
                                    <td class="id">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" 
                                           class="fw-medium link-primary">
                                           #{{ $order->order_code }}
                                        </a>
                                    </td>
                        
                                    <!-- Tổng tiền -->
                                    <td class="total_price">
                                        {{ number_format($order->total_amount - ($order->discount ?? 0) + $order->shipping_fee, 0, ',', '.') }}₫
                                    </td>
                        
                                    <!-- Phương thức thanh toán -->
                                    <td class="payment_method">
                                        {{ $order->payment_method }}
                                    </td>
                        
                                    <!-- Trạng thái thanh toán -->
                                    <td class="payment_status">
                                        @if ($order->payment_status === 'Chưa thanh toán')
                                        <span class="badge bg-warning">Chưa thanh toán</span>
                                        @else
                                            <span class="badge bg-success">{{ $order->payment_status }}</span>
                                        @endif
                                    </td>
                        
                                    <!-- Trạng thái giao hàng -->
                                    <td class="shipment_status">
                                        @if ($order->order_status === 'Đã giao')
                                            <span class="badge bg-success">Đã giao</span>
                                        @elseif ($order->order_status === 'Đang giao')
                                            <span class="badge bg-info">Đang giao</span>
                                        @elseif($order->order_status === 'Đã hủy')
                                            <span class="badge bg-danger">Đã Hủy</span>
                                        @else
                                        <span class="badge bg-warning">Đang xử lý</span>
                                        @endif
                                    </td>
                        
                                    <!-- Ngày đặt hàng -->
                                    <td class="created_at">
                                        {{ $order->created_at->format('d/m/Y') }},
                                        <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                    </td>
                        
                                    <!-- Hành động -->
                                    <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            <!-- Xem đơn hàng -->
                                            <li class="list-inline-item" data-bs-toggle="tooltip" title="Xem">
                                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                                   class="text-primary d-inline-block">
                                                    <i class="ri-eye-fill fs-16"></i>
                                                </a>
                                            </li>
                        
                                            <!-- Chỉnh sửa đơn hàng -->
                                            <li class="list-inline-item" data-bs-toggle="tooltip" title="{{ $order->order_status === 'Đã hủy' ? 'Delete' : 'Chỉnh sửa' }}">
                                                @if ($order->order_status === 'Đã hủy')
                                                    <!-- Nút xóa nếu đơn hàng đã hủy -->
                                                    <a class="remove-item-btn" data-bs-toggle="modal" href="#deleteRecordModal"
                                                       onclick="showDeleteModal({{ $order->id }})">
                                                        <i class="ri-delete-bin-fill fs-5 align-bottom" style="color:#FF6600;"></i>
                                                    </a>
                                                @else
                                                    <!-- Nút chỉnh sửa nếu đơn hàng chưa hủy -->
                                                    <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn"
                                                       data-id="{{ $order->id }}" 
                                                       data-order-status="{{ $order->order_status }}" 
                                                       data-payment-status="{{ $order->payment_status }}">
                                                        <i class="ri-pencil-fill fs-16"></i>
                                                    </a>
                                                @endif
                                            </li>
                                            
                                            
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                       <!-- Hiển thị các liên kết phân trang -->
                    </div>
                    {{ $orders->links() }} 
                </div>
            </div><!-- end card-body -->
        </div><!-- end card -->
        <div class="card-footer">
   
</div>
    </div><!-- end col -->
</div>
{{-- modal edit --}}
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Cập nhật trạng thái</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="updateStatusForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label for="order-status">Trạng thái đơn hàng</label>
                            <select class="form-select mb-3" id="order-status" name="order_status">
                                <option value="" disabled selected>Chọn trạng thái đơn hàng</option>
                                <option value="Đang xử lí">Đang xử lý</option>
                                <option value="Đang giao">Đang giao</option>
                                <option value="Đã giao">Đã giao</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="payment-status">Trạng thái thanh toán</label>
                            <select class="form-select mb-3" id="payment-status" name="payment_status">
                                <option value="" disabled selected>Chọn trạng thái thanh toán</option>
                                <option value="Đã thanh toán">Đã thanh toán</option>
                                <option value="Chưa thanh toán">Chưa thanh toán</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3 float-end">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- modal delete --}}
    <div id="deleteOrder" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
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
                            <h4>Xóa đơn hàng</h4>
                            <p class="text-muted mx-4 mb-0">Bạn có muốn xóa đơn hàng này không ?</p>
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
  // Lắng nghe sự kiện click cho tất cả các nút chỉnh sửa
  const modalElement = document.getElementById('showModal');
const modal = new bootstrap.Modal(modalElement);
const updateStatusForm = document.getElementById('updateStatusForm');
const updateOrderRoute = "{{ route('admin.updateOrder', ['id' => ':id']) }}";

// Reset giá trị khi đóng modal
modalElement.addEventListener('hidden.bs.modal', () => {
    ['order-status', 'payment-status'].forEach(id => document.getElementById(id).value = '');
});

// Mở modal và gán giá trị
document.querySelectorAll('.edit-item-btn').forEach(button => {
    button.addEventListener('click', () => {
        const { id: orderId, orderStatus, paymentStatus } = button.dataset;
        document.getElementById('order-status').value = orderStatus;
        document.getElementById('payment-status').value = paymentStatus;
        updateStatusForm.setAttribute('data-id', orderId);
        modal.show();
    });
});

// Cập nhật trạng thái đơn hàng
updateStatusForm.addEventListener('submit', event => {
    event.preventDefault();
    const orderId = updateStatusForm.getAttribute('data-id');
    const url = updateOrderRoute.replace(':id', orderId);

    fetch(url, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({
            order_status: document.getElementById('order-status').value,
            payment_status: document.getElementById('payment-status').value,
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                modal.hide();
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Thất bại!',
                text: data.message,
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Lỗi!',
            text: 'Có lỗi xảy ra. Vui lòng thử lại!',
        });
        console.error('Có lỗi xảy ra:', error);
    });
});

     // Hàm hiển thị modal xác nhận xóa
     let deleteOrderId;

function showDeleteModal(orderId) {
    deleteOrderId = orderId; // Lưu ID đơn hàng
    $('#deleteOrder').modal('show'); // Hiển thị modal xác nhận

    // Xử lý sự kiện khi nhấn nút "Xóa"
    $('#confirmDelete').off('click').on('click', function () {
        if (deleteOrderId) {
            // Lấy CSRF token từ meta trong <head>
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`{{ route('admin.destroyOrder', ':id') }}`.replace(':id', deleteOrderId), {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Đảm bảo truyền token động
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    $('#deleteOrder').modal('hide'); // Ẩn modal sau khi xóa
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        text: data.message,
                        confirmButtonText: 'Đồng ý'
                    }).then(() => {
                        location.reload(); // Tải lại trang
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: data.message,
                        confirmButtonText: 'Đồng ý'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Có lỗi xảy ra',
                    text: 'Không thể xóa đơn hàng!',
                    confirmButtonText: 'Đồng ý'
                });
            });
        }
    });
}


</script>
@endpush