@extends('admin.layouts.master')


@section('title')
    Khách hàng
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                
                <!-- end card header -->

                <div class="card-body">
                    <form action="{{ route('admin.listCusstomer') }}" method="GET">
                        @csrf
                        <div class="row mb-2 ">
                            <div class="col-lg-4">
                                <div class="d-flex justify-content-start">
                                    <div class="search-box ms-2 w-100">
                                        <input type="text" name="query" class="form-control search" placeholder="Search...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            </div>
                        </div>
                    </form>

                    <div class="live-preview mt-4">
                        <div class="table-responsive table-card">
                            <table class="table align-middle small" id="customerTable">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="cardtableCheck">
                                                <label class="form-check-label" for="cardtableCheck"></label>
                                            </div>
                                        </th>
                                        <th class="sort" data-sort="name">ID</th>
                                        <th class="sor" style="padding-left: 50px"   data-sort="name">Họ và Tên</th>
                                        
                                        <th class="sort" data-sort="name">Email</th>
                                        <th class="sort" data-sort="name">Ngày sinh</th>
                                        <th class="sort" data-sort="name">Số điện thoại</th>
                                        <th class="sort" data-sort="name">Giới tính</th>
                                        <th class="sort" data-sort="name">Trạng thái</th>
                                        <th >Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listCustomer as $customer)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="cardtableCheck{{ $customer->id }}">
                                                    <label class="form-check-label" for="cardtableCheck{{ $customer->id }}"></label>
                                                </div>
                                            </td>
                                            <td>{{ $customer->id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <img src="{{ $customer->cover ? asset('storage/'.$customer->cover) : asset('theme/admin/assets/images/users/user-dummy-img.jpg') }}" 
                                                        alt="" 
                                                        class="avatar-xxs rounded-circle image_src object-fit-cover">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 name text-start">{{ $customer->full_name }}</div>
                                                </div>
                                            </td>
                                          
                                            <td>{{ $customer->email }}</td>
                                            <td>{{ \Carbon\Carbon::parse($customer->birthday)->format('d/m/Y') }}</td>
                                            <td>{{ $customer->phone }}</td>
                                            <td>{{ $customer->gender == 1 ? 'Nam' : ($customer->gender == 2 ? 'Nữ' : 'Khác') }}</td>
                                            <td>
                                                <div class="form-check form-switch form-switch-success form-switch-md" dir="ltr">
                                                    <input type="checkbox" class="form-check-input"
                                                           {{ $customer->status === 'active' ? 'checked' : '' }}
                                                           id="statusCheckbox{{ $customer->id }}"
                                                           onchange="confirmStatusChange({{ $customer->id }}, this)">
                                                </div>
                                            </td>
                                            <td>
                                                <a href="" class="btn btn-sm btn-info">Chi tiết</a>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="showDeleteModal({{ $customer->id }})">
                                                    Xóa
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-4">
                        {{ $listCustomer->links() }}
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
    <!-- end row -->
    {{-- modal update status --}}
   <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Khóa tài khoản !</h4>
                        <p class="text-muted mx-4 mb-0">Bạn có muốn khóa tài khoản này không ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn w-sm btn-danger" id="updateStatus">Đồng ý</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
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
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
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
@endsection

<script>
    // confirm status 
    function confirmStatusChange(customerId, checkbox) {
        const originalChecked = checkbox.checked; // Lưu trạng thái ban đầu của checkbox
        console.log("Trạng thái ban đầu:", originalChecked);

        // Hiển thị modal
        $('#removeNotificationModal').modal('show');

        // Khi người dùng xác nhận cập nhật
        $('#updateStatus').off('click').on('click', function() {
            updateStatus(customerId, checkbox); // Truyền checkbox để xử lý
            $('#removeNotificationModal').modal('hide');

            // Loại bỏ sự kiện hủy khi đã xác nhận
            $('#removeNotificationModal').off('hidden.bs.modal');
        });

        // Khi người dùng hủy modal
        $('#removeNotificationModal').on('hidden.bs.modal', function() {
            checkbox.checked = !originalChecked; // Khôi phục trạng thái nếu người dùng hủy
            console.log("Trạng thái sau khi hủy:", checkbox.checked);
        });
    }

    function updateStatus(customerId, checkbox) {
        const isChecked = checkbox.checked;
        const status = isChecked ? 'active' : 'inactive'; // Cập nhật theo giá trị mong muốn

        fetch('{{ route("admin.updateStatus", ":id") }}'.replace(':id', customerId), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Response:', data); // Kiểm tra phản hồi
            if (data.success) {
                console.log("Cập nhật thành công");
                checkbox.checked = isChecked; // Giữ nguyên trạng thái sau khi thành công
                console.log("Trạng thái sau update thành công:", checkbox.checked);
                
            } else {
                alert('Cập nhật trạng thái không thành công!');
                checkbox.checked = !isChecked; // Khôi phục trạng thái nếu không thành công
            }
        })
        .catch(error => {
            console.error('Error:', error);
            checkbox.checked = !isChecked; // Khôi phục trạng thái nếu có lỗi
        });
    }



// Hàm hiển thị modal xác nhận xóa
let deleteCustomerId;
function showDeleteModal(customerId) {
    deleteCustomerId = customerId; // Lưu ID khách hàng vào biến
    $('#deleteCustomer').modal('show'); // Hiển thị modal xác nhận
$('#confirmDelete').on('click', function() {    
    if (deleteCustomerId) {
        // Thực hiện yêu cầu xóa qua AJAX
        fetch('{{ route("admin.deleteCustomer", ":id") }}'.replace(':id', deleteCustomerId), {
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

</script>


    
  

