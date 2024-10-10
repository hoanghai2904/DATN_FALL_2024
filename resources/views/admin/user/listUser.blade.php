@extends('admin.layouts.master')
@push('style')
@endpush
@section('title')
    Nhân viên
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="leadsList">
            <div class="card-header border-0">

                <div class="row g-4 align-items-center">
                    <div class="col-sm-3">
                        <div class="search-box">
                            <input type="text" class="form-control search" placeholder="Search for...">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>
                    <div class="col-sm-auto ms-auto">
                        <div class="hstack gap-2">
                            <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                            <button type="button" class="btn btn-info" data-bs-toggle="offcanvas" href="#offcanvasExample"><i class="ri-filter-3-line align-bottom me-1"></i> Fliters</button>
                            <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Add Leads</button>
                            <span class="dropdown">
                                <button class="btn btn-soft-info btn-icon fs-14" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-settings-4-line"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="#">Copy</a></li>
                                    <li><a class="dropdown-item" href="#">Move to pipline</a></li>
                                    <li><a class="dropdown-item" href="#">Add to exceptions</a></li>
                                    <li><a class="dropdown-item" href="#">Switch to common form view</a></li>
                                    <li><a class="dropdown-item" href="#">Reset form view to default</a></li>
                                </ul>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div>
                    <div class="table-responsive table-card">
                        <table class="table align-middle" id="customerTable">
                            <thead class="table-light">
                                <tr class="">
                                    <th scope="col" style="width: 50px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                        </div>
                                    </th>
                                    <th>#ID</th>
                                    <th style="padding-left: 50px">Name</th>
                                    <th style="padding-left: 50px">Email</th>
                                    <th>Phone</th>                 
                                    <th>Vai trò</th>
                                    <th>Trạng thái</th>
                                    <th>Create Date</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach($employees as $employee)
                                    <tr >
                                        <th scope="row">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="chk_child" value="{{ $employee->id }}">
                                            </div>
                                        </th>
                                        <td>{{ $employee->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="{{ $employee->cover ? asset('storage/'.$employee->cover) : asset('theme/admin/assets/images/users/user-dummy-img.jpg') }}" 
                                                    alt="" 
                                                    class="avatar-xxs rounded-circle image_src object-fit-cover">
                                                </div>
                                                <div class="flex-grow-1 ms-2 name text-start">{{ $employee->full_name }}</div>
                                            </div>
                                        </td>
                                        <td >{{ $employee->email }}</td>
                                        <td>{{ $employee->phone }}</td>
                                        <td class="tags">
                                            @foreach($employee->roles as $role)
                                                <span class="badge bg-primary-subtle text-primary">{{ $role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="form-check form-switch form-switch-success form-switch-md text-center" dir="ltr">
                                                <input type="checkbox" class="form-check-input" {{ $employee->status == 'active' ? 'checked' : '' }} >
                                            </div>
                                        </td>
                                        <td>{{ $employee->created_at->format('d M, Y') }}</td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                    <a href="javascript:void(0);"><i class="ri-eye-fill align-bottom text-muted"></i></a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                    <a class="edit-item-btn" href="#showModal" data-bs-toggle="modal"><i class="ri-pencil-fill align-bottom text-muted"></i></a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                                    <a class="remove-item-btn" data-bs-toggle="modal" href="#deleteRecordModal">
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
              
                <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="exampleModalLabel"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                            </div>
                            <form class="tablelist-form" autocomplete="off" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <input type="hidden" id="id-field" />
                                    <div class="row g-3">
                                        <!-- Hình đại diện -->
                                        <div class="col-lg-12">
                                            <div class="text-center">
                                                <div class="position-relative d-inline-block">
                                                    <div class="position-absolute bottom-0 end-0">
                                                        <label for="avatar-input" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="right" title="Chọn ảnh">
                                                            <div class="avatar-xs cursor-pointer">
                                                                <div class="avatar-title bg-light border rounded-circle text-muted">
                                                                    <i class="ri-image-fill"></i>
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <input class="form-control d-none" id="avatar-input" type="file" accept="image/png, image/gif, image/jpeg" onchange="previewImage(event)">
                                                    </div>
                                                    <div class="avatar-lg p-1">
                                                        <div class="avatar-title bg-light rounded-circle">
                                                            <!-- Thẻ img sẽ hiển thị ảnh đại diện -->
                                                            <img src="{{asset('theme/admin/assets/images/users/user-dummy-img.jpg')}}" id="avatar-img" class="avatar-md rounded-circle object-fit-cover" />
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
                                                <input type="text" id="name-field" class="form-control" placeholder="Nhập họ và tên" required />
                                            </div>
                                        </div>
                            
                                        <!-- Ngày sinh -->
                                        <div class="col-lg-6">
                                            <div>
                                                <label for="dob-field" class="form-label">Ngày sinh</label>
                                                <input type="date" id="dob-field" class="form-control" placeholder="Chọn ngày sinh" />
                                            </div>
                                        </div>
                            
                                        <!-- Email -->
                                        <div class="col-lg-6">
                                            <div>
                                                <label for="email-field" class="form-label">Email *</label>
                                                <input type="email" id="email-field" class="form-control" placeholder="Nhập email" required />
                                            </div>
                                        </div>
                            
                                        <!-- Điện thoại -->
                                        <div class="col-lg-6">
                                            <div>
                                                <label for="phone-field" class="form-label">Điện thoại *</label>
                                                <input type="text" id="phone-field" class="form-control" placeholder="Nhập số điện thoại" required />
                                            </div>
                                        </div>
                            
                                        <!-- Mật khẩu -->
                                        <div class="col-lg-12">
                                            <div>
                                                <label for="password-field" class="form-label">Mật khẩu *</label>
                                                <input type="password" id="password-field" class="form-control" placeholder="Nhập mật khẩu" required />
                                            </div>
                                        </div>
                            
                                        <!-- Vai trò -->
                                        <div class="col-md-12">
                                            <label for="role-field" class="form-label">Vai trò *</label>
                                            <span class="badge bg-danger-subtle text-danger">Click vào để chọn vai trò!</span>
                                            <select id="role-field" class="form-select js-example-basic-multiple" name="roles[]" multiple>
                                                <optgroup label="Quyền hiện có">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            @error('roles')
                                                <small style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                                            @enderror
                                        </div>
                            
                                    </div>
                                    <!-- end row -->
                                </div>
                            
                                <div class="modal-footer">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-success" id="add-btn">Thêm mới</button>
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
                <!--end modal-->

                <!-- Modal -->
                <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-labelledby="deleteRecordLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                            </div>
                            <div class="modal-body p-5 text-center">
                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                <div class="mt-4 text-center">
                                    <h4 class="fs-semibold">You are about to delete a lead ?</h4>
                                    <p class="text-muted fs-14 mb-4 pt-1">Deleting your lead will remove all of your information from our database.</p>
                                    <div class="hstack gap-2 justify-content-center remove">

                                        <button class="btn btn-link link-success fw-medium text-decoration-none" id="deleteRecord-close" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                                        <button class="btn btn-danger" id="delete-record">Yes, Delete It!!</button>
                                    </div>
                                </div>
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
    function previewImage(event) {
    const input = event.target;
    const reader = new FileReader();

    reader.onload = function() {
        const imgElement = document.getElementById('avatar-img');
        imgElement.src = reader.result; // Cập nhật ảnh mới được chọn
    }

    if (input.files && input.files[0]) {
        reader.readAsDataURL(input.files[0]); // Đọc dữ liệu ảnh
    }
}

// add user và tạo role cho user đó
document.getElementById('add-btn').addEventListener('click', function(event) {
    event.preventDefault(); // Ngăn chặn form submit mặc định

    // Lấy dữ liệu từ form
    const name = document.getElementById('name-field').value;
    const dob = document.getElementById('dob-field').value;
    const email = document.getElementById('email-field').value;
    const phone = document.getElementById('phone-field').value;
    const password = document.getElementById('password-field').value;
    const roles = Array.from(document.querySelectorAll('#role-field option:checked')).map(option => option.value);
    
    // Tạo FormData để gửi lên server
    const formData = new FormData();
    formData.append('name', name);
    formData.append('dob', dob);
    formData.append('email', email);
    formData.append('phone', phone);
    formData.append('password', password);
    formData.append('roles', JSON.stringify(roles));

    const avatarInput = document.getElementById('avatar-input');
    if (avatarInput.files.length > 0) {
        formData.append('avatar', avatarInput.files[0]);
    }

    // Gửi dữ liệu lên server bằng Fetch API
    fetch('/users', { // Đường dẫn này cần thay đổi cho phù hợp với route lưu người dùng của bạn
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Bảo vệ CSRF
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Hiển thị thông báo thành công
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: 'Thêm người dùng thành công!',
                confirmButtonText: 'Đồng ý'
            }).then(() => {
                // Đóng modal
                $('#showModal').modal('hide');
                // Có thể refresh lại danh sách người dùng ở đây nếu cần
            });
        } else {
            // Hiển thị thông báo lỗi
            Swal.fire({
                icon: 'error',
                title: 'Có lỗi xảy ra!',
                text: data.message,
                confirmButtonText: 'Đồng ý'
            });
        }
    })
    .catch(error => {
        console.error('Lỗi:', error);
        // Thông báo lỗi khi có sự cố mạng hoặc vấn đề khác
        Swal.fire({
            icon: 'error',
            title: 'Có lỗi xảy ra!',
            text: 'Không thể kết nối tới máy chủ.',
            confirmButtonText: 'Đồng ý'
        });
    });
});

</script>
@endsection