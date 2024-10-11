@extends('admin.layouts.master')
@push('style')
@endpush
@section('title')
    Nhân viên
@endsection

@section('content')
    <div class="row" >
        <div class="col-lg-12">
            <div class="card" id="leadsList">
                <div class="card-header border-0">
                    <form action="{{ route('admin.listUser') }}" method="GET">
                        @csrf
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-2">
                            <select class="js-example-basic-single select2-hidden-accessible" name="status"
                                aria-hidden="true">
                                <option value="" disabled selected>Tìm theo trạng thái</option>
                                <option value="active">active</option>
                                <option value="inactive">inactive</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <select class="js-example-basic-single select2-hidden-accessible" name="role_id" aria-hidden="true">
                                <option value="" disabled selected>Tìm theo Vai trò</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <div class="search-box">
                                <input type="text" class="form-control search" name="search" placeholder="Search for...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                    
                        <div class="col-sm-auto ms-auto">
                            <div class="hstack gap-2">
                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i
                                        class="ri-delete-bin-2-line"></i></button>
                                <button type="submit" class="btn btn-info" data-bs-toggle="offcanvas"
                                    href="#offcanvasExample"><i class="ri-filter-3-line align-bottom me-1"></i>
                                    Tìm kiếm</button>
                                <button type="button" class="btn btn-success add-btn" id="openModalButton"
                                    data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i>Thêm nhân viên
                                </button>
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
                                    <tr class="">
                                        <th scope="col" style="width: 50px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkAll"
                                                    value="option">
                                            </div>
                                        </th>
                                        <th>#ID</th>
                                        <th style="padding-left: 50px">Họ và tên</th>
                                        <th style="padding-left: 50px">Email</th>
                                        <th>Điện thoại</th>
                                        <th>Vai trò</th>
                                        <th>Trạng thái</th>
                                        <th>Create Date</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all"  >
                                    @foreach ($employees as $employee)
                                        <tr>
                                            <th scope="row">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="chk_child"
                                                        value="{{ $employee->id }}"
                                                        onchange="previewImage(event, 'avatar-img')">
                                                </div>
                                            </th>
                                            <td>{{ $employee->id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <img src="{{ $employee->cover ? asset('storage/' . $employee->cover) : asset('theme/admin/assets/images/users/user-dummy-img.jpg') }}"
                                                            alt=""
                                                            class="avatar-xxs rounded-circle image_src object-fit-cover">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 name text-start">{{ $employee->full_name }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $employee->email }}</td>
                                            <td>{{ $employee->phone }}</td>
                                            <td class="tags">
                                                @foreach ($employee->roles as $role)
                                                    <span class="badge bg-primary-subtle text-primary">{{ $role->name }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td>
                                                <div class="form-check form-switch form-switch-success form-switch-md text-center" dir="ltr">
                                                    <input type="checkbox" class="form-check-input"
                                                           {{ $employee->status === 'active' ? 'checked' : '' }}
                                                           id="statusCheckbox{{ $employee->id }}"
                                                           onchange="confirmStatusChange({{ $employee->id }}, this)">
                                                </div>
                                            </td>
                                            <td>{{ $employee->created_at->format('d M, Y') }}</td>
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                        <a href="javascript:void(0);"><i
                                                                class="ri-eye-fill align-bottom text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                        <a href="javascript:void(0);" class="btn-info view-details-btn"
                                                            data-id="{{ $employee->id }}"> <i
                                                                class="ri-pencil-fill align-bottom text-muted"></i></a>
                                                    </li>

                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                                        <a class="remove-item-btn" data-bs-toggle="modal"
                                                            href="#deleteRecordModal"
                                                            onclick="showDeleteModal({{ $employee->id }})">
                                                            <i class="ri-delete-bin-fill align-bottom text-muted"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Phân trang -->


                        </div>
                        <div class="mt-3">
                            {{ $employees->links() }}
                        </div>
                    </div>
                    {{-- modal add user --}}
                    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="exampleModalLabel">Thêm người dùng</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        id="close-modal"></button>
                                </div>
                                <form id="add-user-form" class="tablelist-form" autocomplete="off"
                                    enctype="multipart/form-data" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" id="id-field" name="id" />
                                        <div class="row g-3">
                                            <!-- Hình đại diện -->
                                            <div class="col-lg-12">
                                                <div class="text-center">
                                                    <div class="position-relative d-inline-block">
                                                        <div class="position-absolute bottom-0 end-0">
                                                            <label for="avatar-input" class="mb-0"
                                                                data-bs-toggle="tooltip" data-bs-placement="right"
                                                                title="Chọn ảnh">
                                                                <div class="avatar-xs cursor-pointer">
                                                                    <div
                                                                        class="avatar-title bg-light border rounded-circle text-muted">
                                                                        <i class="ri-image-fill"></i>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                            <input class="form-control d-none" id="avatar-input"
                                                                name="cover" type="file"
                                                                accept="image/png, image/gif, image/jpeg"
                                                                onchange="previewImage(event, 'avatar-img')">
                                                        </div>
                                                        <div class="avatar-lg p-1">
                                                            <div class="avatar-title bg-light rounded-circle">
                                                                <img src="{{ asset('theme/admin/assets/images/users/user-dummy-img.jpg') }}"
                                                                    id="avatar-img"
                                                                    class="avatar-md rounded-circle object-fit-cover avatar-img" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h5 class="fs-13 mt-3">Ảnh đại diện</h5>
                                                </div>
                                            </div>

                                            <!-- Họ và tên -->
                                            <div class="col-lg-6">
                                                <div>
                                                    <label for="name-field" class="form-label">Họ và tên *</label>
                                                    <input type="text" id="name-field" class="form-control"
                                                        placeholder="Nhập họ và tên" name="full_name" />
                                                </div>
                                            </div>

                                            <!-- Ngày sinh -->
                                            <div class="col-lg-6">
                                                <div>
                                                    <label for="dob-field" class="form-label">Ngày sinh</label>
                                                    <input type="date" id="dob-field" class="form-control"
                                                        name="birthday" placeholder="Chọn ngày sinh" />
                                                </div>
                                            </div>

                                            <!-- Email -->
                                            <div class="col-lg-6">
                                                <div>
                                                    <label for="email-field" class="form-label">Email *</label>
                                                    <input type="email" id="email-field" class="form-control"
                                                        name="email" placeholder="Nhập email" />
                                                </div>
                                            </div>

                                            <!-- Điện thoại -->
                                            <div class="col-lg-6">
                                                <div>
                                                    <label for="phone-field" class="form-label">Điện thoại *</label>
                                                    <input type="text" id="phone-field" class="form-control"
                                                        name="phone" placeholder="Nhập số điện thoại" />
                                                </div>
                                            </div>

                                            <!-- Mật khẩu -->
                                            <div class="col-lg-12">
                                                <div>
                                                    <label for="password-field" class="form-label">Mật khẩu *</label>
                                                    <input type="password" id="password-field" class="form-control"
                                                        name="password" placeholder="Nhập mật khẩu" />
                                                </div>
                                            </div>

                                            <!-- Vai trò -->
                                            <div class="col-md-12">
                                                <label for="role-field" class="form-label">Vai trò *</label>
                                                <span class="badge bg-danger-subtle text-danger">Click vào để chọn vai
                                                    trò!</span>
                                                <select id="role-field" class="form-select js-example-basic-multiple"
                                                    name="roles[]" multiple>
                                                    <optgroup label="Quyền hiện có">
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->id }}">{{ $role->name }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                                @error('roles')
                                                    <small
                                                        style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- end row -->
                                    </div>

                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" class="btn btn-success" id="add-btn">Thêm
                                                mới</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end modal-->

                    {{-- modal edit --}}
                    <div class="modal fade" id="userDetailsModal" tabindex="-1" aria-labelledby="userDetailsModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="userDetailsModalLabel">Thông tin người dùng</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="updateUserForm" class="tablelist-form" autocomplete="off"
                                    enctype="multipart/form-data" method="POST"
                                    action="{{ route('admin.updateUser', ':id') }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <input type="hidden" id="id-field" name="id" />
                                        <div class="row g-3">
                                            <!-- Hình đại diện -->
                                            <div class="col-lg-12">
                                                <div class="text-center">
                                                    <div class="position-relative d-inline-block">
                                                        <div class="position-absolute bottom-0 end-0">
                                                            <label for="cover-input" class="mb-0"
                                                                data-bs-toggle="tooltip" data-bs-placement="right"
                                                                title="Chọn ảnh">
                                                                <div class="avatar-xs cursor-pointer">
                                                                    <div
                                                                        class="avatar-title bg-light border rounded-circle text-muted">
                                                                        <i class="ri-image-fill"></i>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                            <input class="form-control d-none" id="cover-input"
                                                                name="cover" type="file"
                                                                accept="image/png, image/gif, image/jpeg"
                                                                onchange="previewImage(event, 'cover-img')">
                                                        </div>
                                                        <div class="avatar-lg p-1">
                                                            <div class="avatar-title bg-light rounded-circle">
                                                                <img src="{{ asset('theme/admin/assets/images/users/user-dummy-img.jpg') }}"
                                                                    id="cover-img"
                                                                    class="avatar-md rounded-circle object-fit-cover" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h5 class="fs-13 mt-3">Ảnh đại diện</h5>
                                                </div>
                                            </div>

                                            <!-- Họ và tên -->
                                            <div class="col-lg-6">
                                                <div>
                                                    <label for="modal-name" class="form-label">Họ và tên *</label>
                                                    <input type="text" id="modal-name" class="form-control"
                                                        placeholder="Nhập họ và tên" name="full_name" required />
                                                </div>
                                            </div>

                                            <!-- Ngày sinh -->
                                            <div class="col-lg-6">
                                                <div>
                                                    <label for="modal-dob" class="form-label">Ngày sinh</label>
                                                    <input type="date" id="modal-dob" class="form-control"
                                                        name="birthday" />
                                                </div>
                                            </div>

                                            <!-- Email -->
                                            <div class="col-lg-6">
                                                <div>
                                                    <label for="modal-email" class="form-label">Email *</label>
                                                    <input type="email" id="modal-email" class="form-control"
                                                        name="email" required />
                                                </div>
                                            </div>

                                            <!-- Điện thoại -->
                                            <div class="col-lg-6">
                                                <div>
                                                    <label for="modal-phone" class="form-label">Điện thoại *</label>
                                                    <input type="text" id="modal-phone" class="form-control"
                                                        name="phone" required />
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <h6 class="fw-semibold">Vai trò</h6>
                                                <select class="js-example-basic-multiple form-control" name="roles[]"
                                                    multiple="multiple" id="modal-roles">
                                                    <optgroup label="Quyền hiện có">
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->id }}">{{ $role->name }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" class="btn btn-success" id="updateUserBtn">Cập
                                                Nhập</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>



                    {{-- end modal --}}

                    <!-- Modal -->
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


                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <script>
        function previewImage(event, imgId) {
            const input = event.target; // Lấy phần tử input mà người dùng chọn
            const reader = new FileReader(); // Tạo đối tượng FileReader để đọc file
            reader.onload = function() {
                const imgElement = document.getElementById(imgId); // Tìm hình ảnh tương ứng với ID được truyền vào
                imgElement.src = reader.result; // Cập nhật nguồn của hình ảnh bằng dữ liệu ảnh đã chọn
            }
            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]); // Đọc file ảnh nếu tồn tại
            }
        }

        // add user
        $(document).ready(function() {
            // Mở modal khi nhấn nút thêm người dùng
            $('#openModalButton').on('click', function() {
                $('#showModal').modal('show');
            });

            // Xử lý sự kiện gửi form
            $('#add-user-form').on('submit', function(e) {
                e.preventDefault(); // Ngăn form submit theo cách thông thường

                var formData = new FormData(this); // Tạo đối tượng FormData để gửi file

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.addUser') }}',
                    data: formData,
                    contentType: false, // Để gửi file, cần false
                    processData: false,
                    success: function(response) {
                        // Kiểm tra xem response có success hay không
                        if (response.success) {
                            // Sử dụng SweetAlert thay vì alert
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công',
                                text: response.message,
                                confirmButtonText: 'OK'
                            }).then(function() {
                                $('#showModal').modal('hide'); // Đóng modal
                                location.reload(); // Reload lại trang (nếu cần)
                            });
                        } else {
                            // Thông báo lỗi bằng SweetAlert
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: response.message,
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        // Xử lý lỗi chung
                        let errorMessage = 'Xin vui lòng thử lại.';

                        // Nếu có lỗi từ server, lấy thông báo lỗi
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Đã có lỗi xảy ra',
                            text: errorMessage,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });

        //edit form
        $(document).ready(function() {
            // Khởi tạo Select2 cho vai trò
            $('#modal-roles').select2();

            // Khi click vào nút "Chi tiết"
            $('.view-details-btn').on('click', function() {
                var userId = $(this).data('id'); // Lấy ID người dùng từ data attribute

                // Gửi yêu cầu AJAX để lấy thông tin người dùng
                var url = '{{ route('admin.showUser', ':id') }}';
                url = url.replace(':id', userId);
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data) {
                        // Điền thông tin người dùng vào modal
                        $('#id-field').val(data.id);
                        $('#modal-name').val(data.full_name);
                        $('#modal-email').val(data.email);
                        $('#modal-phone').val(data.phone);
                        $('#modal-dob').val(data.birthday);

                        // Cập nhật avatar nếu có
                        if (data.cover) {
                            $('#cover-img').attr('src', '{{ asset('storage') }}/' + data
                            .cover);
                        } else {
                            $('#cover-img').attr('src',
                                '{{ asset('theme/admin/assets/images/users/user-dummy-img.jpg') }}'
                                );
                        }

                        // Hiển thị danh sách vai trò
                        $('#modal-roles').val(data.roles.map(role => role.id)).trigger(
                        'change');

                        // Hiển thị modal
                        $('#userDetailsModal').modal('show');
                    },
                    error: function(xhr) {
                        console.error('Error fetching user data:', xhr);
                        alert('Đã xảy ra lỗi khi lấy thông tin người dùng.');
                    }
                });
            });

            // Xử lý cập nhật thông tin người dùng qua AJAX
            $('#updateUserForm').on('submit', function(e) {
                e.preventDefault(); // Ngăn chặn hành vi submit mặc định của form

                var userId = $('#id-field').val(); // Lấy ID người dùng
                var url = '{{ route('admin.updateUser', ':id') }}';
                url = url.replace(':id', userId);

                var formData = new FormData(this); // Lấy toàn bộ dữ liệu từ form

                $.ajax({
                    url: url,
                    method: 'POST', // Phương thức POST với @method('PUT') trong form
                    data: formData,
                    processData: false, // Không xử lý dữ liệu vì có file upload
                    contentType: false, // Không thiết lập content-type
                    success: function(response) {
                        // Đóng modal sau khi cập nhật thành công
                        $('#userDetailsModal').modal('hide');

                        // Hiển thị thông báo thành công (Swal hoặc toastr)
                        Swal.fire({
                            icon: 'success',
                            title: 'Cập nhật thành công!',
                            text: response.message
                        });
                        location.reload();
                        // Tùy chọn: Cập nhật lại danh sách người dùng trên giao diện
                    },
                    error: function(xhr) {
                        console.error('Error updating user:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: xhr.responseJSON.message ||
                                'Đã xảy ra lỗi khi cập nhật.'
                        });

                    }
                });
            });
        });

        //Delete user with role
        let deleteCustomerId;

        function showDeleteModal(customerId) {
            deleteCustomerId = customerId; // Lưu ID khách hàng vào biến
            $('#deleteCustomer').modal('show'); // Hiển thị modal xác nhận

            $('#confirmDelete').off('click').on('click', function() { // Off sự kiện trước đó để tránh gán nhiều lần
                if (deleteCustomerId) {
                    // Thực hiện yêu cầu xóa qua AJAX
                    fetch('{{ route('admin.destroyUser', ':id') }}'.replace(':id', deleteCustomerId), {
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
                                    text: 'Xóa nhân viên thành công.',
                                    confirmButtonText: 'Đồng ý'
                                }).then(() => {
                                    location.reload(); // Tải lại trang sau khi xóa
                                });
                            } else {
                                // Hiển thị thông báo lỗi bằng SweetAlert
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi',
                                    text: 'Xóa nhân viên không thành công!',
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
    </script>
@endsection
