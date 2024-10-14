@extends('admin.layouts.master')
@section('title')
    Vai trò
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Tạo mới vai trò</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="live-preview">
                        <form action="{{ route('admin.addRole') }}" class="row g-3 needs-validation" method="POST">
                            @csrf
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltip01" class="form-label">Vai trò *</label>
                                <input type="text" value="{{ old('role_name') }}" class="form-control"
                                    id="validationTooltip01" name="role_name" placeholder="Nhập tên vai trò">
                                @error('role_name')
                                    <small
                                        style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label">Thêm quyền mới</label>
                                <input type="text" value="{{ old('permission_name') }}" class="form-control"
                                    name="permission_name" placeholder="Nhập quyền mới">
                            </div>
                            <div class="col-md-12">
                                <label for="validationCustom04" class="form-label">Quyền *</label>
                                <span class="badge bg-danger-subtle text-danger">Click vào input để chọn quyền !</span>
                                <select id="validationCustom04"
                                    class="form-select js-example-basic-multiple select2-hidden-accessible"
                                    name="permissions[]" multiple>
                                    <optgroup label="Quyền hiện có">
                                        @foreach ($permissions as $permission)
                                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                @error('permissions')
                                    <small
                                        style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Tạo mới</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-8">
            <div class="card" id="leadsList">
                <div class="card-header border-0">
                    <form action="{{ route('admin.listRole') }}" method="GET">
                        @csrf
                        <div class="row g-4 align-items-center">
                            <div class="col-sm-3">
                                <div class="search-box">
                                    <input type="text" class="form-control search" name="query" placeholder="tìm kiếm theo vai trò ...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-lg-3" data-select2-id="select2-data-2">
                                <select class="js-example-basic-single select2-hidden-accessible" name="status"
                                    aria-hidden="true">
                                    <option value="" disabled selected>Tìm theo trạng thái</option>
                                    <option value="active" data-select2-id="select2-data-75-jxz2">active</option>
                                    <option value="inactive" data-select2-id="select2-data-76-uypr">inactive</option>
                                </select>
                            </div>

                            <div class="col-sm-auto ms-auto">
                                <div class="hstack gap-2">
                                    <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i
                                            class="ri-delete-bin-2-line"></i></button>
                                    <button type="submit" class="btn btn-info" data-bs-toggle="offcanvas"
                                        href="#offcanvasExample"><i class="ri-filter-3-line align-bottom me-1"></i>Tìm
                                        kiếm</button>


                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card">
                            <table class="table align-middle" id="customerTable">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width: 50px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkAll"
                                                    value="option">
                                            </div>
                                        </th>
                                        <th>ID</th>
                                        <th class="text-center">Vai trò</th>
                                        <th class="text-center">Quyền hạn</th>
                                        <th>Ngày tạo</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($roles as $role)
                                        <tr>
                                            <th scope="row">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="chk_child"
                                                        value="option{{ $role->id }}">
                                                </div>
                                            </th>
                                            <td class="id"><a href="javascript:void(0);"
                                                    class="fw-medium link-primary">#{{ $role->id }}</a></td>
                                            <td class="leads_score text-center ms-auto">{{ $role->name }}</td>
                                            <td class="tags text-center" style="width: 200px;">
                                                @foreach ($role->permissions as $permission)
                                                    <span
                                                        class="badge bg-primary-subtle text-primary">{{ $permission->name }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td class="date">{{ $role->created_at->format('d M, Y') }}</td>
                                            <td>
                                                <div class="form-check form-switch form-switch-success form-switch-md text-center"
                                                    dir="ltr">
                                                    <input type="checkbox" class="form-check-input"
                                                        {{ $role->status === 'active' ? 'checked' : '' }}
                                                        id="statusCheckbox{{ $role->id }}"
                                                        onchange="confirmStatusChange({{ $role->id }}, this)">
                                                </div>

                                            </td>
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                        
                                                    </li>

                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                        <a class="edit-item-btn" href="javascript:void(0);"
                                                            data-id="{{ $role->id }}" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModalgrid">
                                                            <i class="ri-pencil-fill align-bottom text-muted"></i>
                                                        </a>
                                                    </li>

                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                                        <a class="remove-item-btn" data-bs-toggle="modal"
                                                            href="#deleteRecordModal"
                                                            onclick="showDeleteModal({{ $role->id }})">
                                                            <i class="ri-delete-bin-fill align-bottom text-muted"></i>
                                                        </a>
                                                    </li>

                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                        </div>
                        <div class="mt-2">
                            {{ $roles->links() }}
                        </div>
                    </div>



                    <!-- Modal delete -->
                    <div id="deleteCustomer" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mt-2 text-center">
                                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                            colors="primary:#f7b84b,secondary:#f06548"
                                            style="width:100px;height:100px"></lord-icon>
                                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                            <h4>Xóa vai trò</h4>
                                            <p class="text-muted mx-4 mb-0">Bạn có muốn xóa vai trò này không ?</p>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                        <button type="button" class="btn w-sm btn-light"
                                            data-bs-dismiss="modal">Đóng</button>
                                        <button type="button" class="btn w-sm btn-danger" id="confirmDelete">Đồng
                                            ý</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end modal -->

                    <!-- Modal update status -->
                    <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mt-2 text-center">
                                        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop"
                                            colors="primary:#f7b84b,secondary:#f06548"
                                            style="width:100px;height:100px"></lord-icon>
                                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                            <h4>Khóa vai trò !</h4>
                                            <p class="text-muted mx-4 mb-0">Bạn có muốn khóa vai trò này không ?</p>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                        <button type="button" class="btn w-sm btn-light"
                                            data-bs-dismiss="modal">Đóng</button>
                                        <button type="button" class="btn w-sm btn-danger" id="updateStatus">Đồng
                                            ý</button>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>
                    <!--end modal -->

                    <!-- Modal edit -->
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModalgrid" tabindex="-1" aria-labelledby="exampleModalgridLabel"
                        aria-modal="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalgridLabel">Edit vai trò</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="updateRoleForm" method="POST" action="">
                                        @csrf
                                        @method('PUT')
                                        <div class="row g-3">
                                            <div class="col-lg-12">
                                                <h6 class="fw-semibold">Danh mục quyền</h6>
                                                <select id="rolePermissions"
                                                    class="js-example-basic-multiple form-control" name="permissions[]"
                                                    multiple="multiple">
                                                    <!-- Options will be populated dynamically using JavaScript -->
                                                </select>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                                </div>
                                            </div><!--end col-->
                                        </div><!--end row-->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--end modal -->

                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <script>
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

    fetch('{{ route('admin.updateStatusRole', ':id') }}'.replace(':id', customerId), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            status: status
        })
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

            // Hiển thị thông báo thành công bằng SweetAlert
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: 'Cập nhật trạng thái thành công!',
                confirmButtonText: 'Đồng ý'
            });
        } else {
            // Hiển thị thông báo lỗi bằng SweetAlert
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Cập nhật trạng thái không thành công!',
                confirmButtonText: 'Đồng ý'
            });
            checkbox.checked = !isChecked; // Khôi phục trạng thái nếu không thành công
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Hiển thị thông báo lỗi bằng SweetAlert
        Swal.fire({
            icon: 'error',
            title: 'Có lỗi xảy ra',
            text: 'Đã xảy ra lỗi trong quá trình cập nhật trạng thái.',
            confirmButtonText: 'Đồng ý'
        });
        checkbox.checked = !isChecked; // Khôi phục trạng thái nếu có lỗi
    });
}


        // Hàm hiển thị modal xác nhận xóa
        let deleteCustomerId;
        function showDeleteModal(customerId) {
            deleteCustomerId = customerId; // Lưu ID khách hàng vào biến
            $('#deleteCustomer').modal('show'); // Hiển thị modal xác nhận

            $('#confirmDelete').off('click').on('click', function() { // Off sự kiện trước đó để tránh gán nhiều lần
                if (deleteCustomerId) {
                    // Thực hiện yêu cầu xóa qua AJAX
                    fetch('{{ route('admin.deleteRole', ':id') }}'.replace(':id', deleteCustomerId), {
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
                                // Hiển thị thông báo thành công bằng SweetAlert
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công',
                                    text: 'Xóa vai trò thành công.',
                                    confirmButtonText: 'Đồng ý'
                                }).then(() => {
                                    location.reload(); // Tải lại trang sau khi xóa
                                });
                            } else {
                                // Hiển thị thông báo lỗi bằng SweetAlert
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi',
                                    text: 'Xóa vai trò không thành công!',
                                    confirmButtonText: 'Đồng ý'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Hiển thị thông báo lỗi bằng SweetAlert
                            Swal.fire({
                                icon: 'error',
                                title: 'Có lỗi xảy ra',
                                text: 'Có lỗi xảy ra trong quá trình xóa.',
                                confirmButtonText: 'Đồng ý'
                            });
                        });
                }
            });
        }


        // edit quyền 
        var editRoleUrl = "{{ route('admin.roles.edit', ':id') }}"; // Placeholder cho ID

$(document).on('click', '.edit-item-btn', function() {
    var roleId = $(this).data('id'); // Lấy ID từ nút sửa
    var url = editRoleUrl.replace(':id', roleId); // Thay thế ID vào URL

    // Gọi route để lấy thông tin vai trò và quyền
    $.ajax({
        url: url,
        method: 'GET',
        success: function(response) {
            // Xóa các lựa chọn trước đó
            $('#rolePermissions').empty();

            // Hiển thị tất cả quyền trong select box
            $.each(response.all_permissions, function(index, permission) {
                var selected = response.permissions.includes(permission.id) ? 'selected' : '';
                $('#rolePermissions').append(
                    `<option value="${permission.id}" ${selected}>${permission.name}</option>`
                );
            });

            // Gán ID vai trò vào form
            $('#updateRoleForm').data('id', roleId);

            // Hiển thị modal
            $('#exampleModalgrid').modal('show');
        },
        error: function(xhr) {
            console.error('Lỗi khi lấy dữ liệu vai trò:', xhr);
        }
    });
});


        //update quyền vs thông báo bằng thư viện 
        // Kiểm tra khi người dùng thay đổi quyền
        var updateRoleUrl = "{{ route('admin.roles.update', ':id') }}"; // Placeholder cho ID

$(document).on('submit', '#updateRoleForm', function(e) {
    e.preventDefault(); // Ngăn chặn hành động gửi form mặc định

    var roleId = $(this).data('id'); // Lấy ID vai trò từ form
    var selectedPermissions = $('#rolePermissions').val(); // [id1, id2, ...]

    // Kiểm tra xem có quyền nào được chọn không
    if (selectedPermissions.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Cảnh báo',
            text: 'Vui lòng chọn ít nhất một quyền.',
            confirmButtonText: 'Đồng ý'
        });
        return;
    }

    // Gọi route để cập nhật quyền cho vai trò
    $.ajax({
        url: updateRoleUrl.replace(':id', roleId), // Sử dụng URL đã tạo
        method: 'PUT',
        data: {
            permissions: selectedPermissions,
            _token: '{{ csrf_token() }}' // Đảm bảo gửi token CSRF
        },
        success: function(response) {
            console.log('Cập nhật quyền thành công!', response);
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: 'Vai trò đã được cập nhật.',
                confirmButtonText: 'Đồng ý'
            }).then(() => {
                location.reload(); // Tải lại trang sau khi cập nhật
            });
        },
        error: function(xhr) {
            console.error('Lỗi khi cập nhật quyền:', xhr);
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Có lỗi xảy ra. Vui lòng thử lại.',
                confirmButtonText: 'Đồng ý'
            });
        }
    });
});

    </script>
@endsection
