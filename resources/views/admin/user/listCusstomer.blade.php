@extends('admin.layouts.master')
<style>
    #contact-view-detail {
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    .address-list {
        max-height: 200px;
        /* Giới hạn chiều cao */
        overflow-y: auto;
        /* Cho phép cuộn dọc */
        padding-right: 10px;
    }

    .address-list li {
        border-bottom: 1px dashed #e3e6ef;
        padding-bottom: 8px;
    }

    .address-list li:last-child {
        border-bottom: none;
    }

    input[type="radio"] {
        accent-color: #198754;
        /* Màu của radio button */
    }

    label {
        font-weight: 600;
        color: #495057;
    }

    p {
        margin-top: 0;
        color: #6c757d;
    }
</style>

@section('title')
    Khách hàng
@endsection

@section('content')
    <div class="row">
        <div id="user-list" class="col-xl-12">
            <div class="card">

                <!-- end card header -->

                <div class="card-body">
                    <form action="{{ route('admin.listCusstomer') }}" method="GET">
                        @csrf
                        <div class="row mb-2 ">
                            <div class="col-lg-4">
                                <div class="d-flex justify-content-start">
                                    <div class="search-box ms-2 w-100">
                                        <input type="text" name="query" class="form-control search"
                                            placeholder="Search...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
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
                                        <th Class="">ID</th>
                                        <th class="sor" style="padding-left: 50px" data-sort="name">Họ và Tên</th>

                                        <th>Email</th>
                                        <th Class="">Ngày sinh</th>
                                        <th Class="">Số điện thoại</th>
                                        <th Class="">Giới tính</th>
                                        <th Class="">Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listCustomer as $customer)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="cardtableCheck{{ $customer->id }}">
                                                    <label class="form-check-label"
                                                        for="cardtableCheck{{ $customer->id }}"></label>
                                                </div>
                                            </td>
                                            <td>{{ $customer->id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <img src="{{ $customer->cover ? asset('storage/' . $customer->cover) : asset('theme/admin/assets/images/users/user-dummy-img.jpg') }}"
                                                            alt=""
                                                            class="avatar-xxs rounded-circle image_src object-fit-cover">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 name text-start">{{ $customer->full_name }}
                                                    </div>
                                                </div>
                                            </td>

                                            <td>{{ $customer->email }}</td>
                                            <td>{{ \Carbon\Carbon::parse($customer->birthday)->format('d/m/Y') }}</td>
                                            <td>{{ $customer->phone }}</td>
                                            <td>{{ $customer->gender == 1 ? 'Nam' : ($customer->gender == 2 ? 'Nữ' : 'Khác') }}
                                            </td>
                                            <td>
                                                <div class="form-check form-switch form-switch-success form-switch-md text-center"
                                                    dir="ltr">
                                                    <input type="checkbox" class="form-check-input"
                                                        {{ $customer->status === 'active' ? 'checked' : '' }}
                                                        id="statusCheckbox{{ $customer->id }}"
                                                        onchange="confirmStatusChange({{ $customer->id }}, this)">
                                                </div>
                                            </td>
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="View">

                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                        <a href="javascript:void(0);" class="view-item-btn"
                                                            data-user-id="{{ $customer->id }}">
                                                            <i class="ri-eye-fill align-bottom text-muted"></i>
                                                        </a>
                                                    </li>


                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                                        <a class="remove-item-btn" data-bs-toggle="modal"
                                                            href="#deleteRecordModal"
                                                            onclick="showDeleteModal({{ $customer->id }})">
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
                    </div>
                    <div class="mt-4">
                        {{ $listCustomer->links() }}
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!-- end col -->
        <div class="col-xxl-3">
            <div class="card d-none" id="contact-view-detail">
                <div class="card-body text-center">
                    <div class="position-relative d-inline-block">
                        <img src="http://127.0.0.1:8000/theme/admin/assets/images/users/avatar-7.jpg" alt=""
                            class="avatar-lg rounded-circle img-thumbnail object-fit-cover">
                        <span class="contact-active position-absolute rounded-circle bg-success">
                            <span class="visually-hidden"></span>
                        </span>
                    </div>
                    <h5 class="mt-4 mb-1">Hà Thế Bảo</h5>
                </div>

                <div class="card-body">
                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Địa chỉ khách hàng</h6>
                    <div class="address-list">
                        <ul class="list-unstyled">
                            <li class="text-muted mb-3">
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="is_default" id="address1" class="me-2">
                                    <label for="address1" class="fw-semibold">Địa chỉ 1:</label>
                                </div>
                                <p>Tổ 5 khu 10, Bãi Cháy, Hạ Long, Quảng Ninh</p>
                            </li>

                            <li class="text-muted mb-3">
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="is_default" id="address2" class="me-2">
                                    <label for="address2" class="fw-semibold">Địa chỉ 2:</label>
                                </div>
                                <p>Đường Hùng Thắng, Khu đô thị Hạ Long Marina, Quảng Ninh</p>
                            </li>

                            <li class="text-muted mb-3">
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="is_default" id="address3" class="me-2">
                                    <label for="address3" class="fw-semibold">Địa chỉ 3:</label>
                                </div>
                                <p>Phường Hồng Gai, TP. Hạ Long, Quảng Ninh</p>
                            </li>
                            <!-- Thêm các địa chỉ khác tại đây -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>


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
                        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop"
                            colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
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

        fetch('{{ route('admin.updateStatus', ':id') }}'.replace(':id', customerId), {
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

    // Lắng nghe sự kiện click vào icon mắt
    const userAddressesRoute = "{{ route('admin.getAddresses', ':userId') }}";
document.addEventListener('click', function (event) {
    if (event.target.closest('.view-item-btn')) {
        const btn = event.target.closest('.view-item-btn');
        const userId = btn.dataset.userId; // Lấy ID người dùng
        const url = userAddressesRoute.replace(':userId', userId); // Thay thế :userId trong route
        console.log("Fetching data for user ID:", userId);

        fetch(url)
            .then(response => response.json())
            .then(data => {
                console.log('Dữ liệu nhận được:', data); // Kiểm tra cấu trúc của dữ liệu
                if (!data.address) {
                    console.error('Dữ liệu địa chỉ không hợp lệ:', data.address);
                    return;
                }
                // Gọi hàm cập nhật danh sách địa chỉ và hiển thị card
                updateAddressList(data);
                
                // Xóa lớp d-none để hiển thị card địa chỉ
                document.getElementById('contact-view-detail').classList.remove('d-none');
                // Thay đổi kích thước của danh sách user
                document.getElementById('user-list').classList.remove('col-xxl-12');
                document.getElementById('user-list').classList.add('col-xxl-9');
            })
            .catch(error => console.error('Error:', error));
    }
});

// Hàm cập nhật thông tin người dùng và danh sách địa chỉ
function updateAddressList(data) {
    const { user, address } = data;

    // Kiểm tra nếu addresses là mảng
    if (!Array.isArray(address)) {
        console.error('Dữ liệu địa chỉ không hợp lệ:', address);
        return;
    }

    // Cập nhật thông tin người dùng
    document.querySelector('#contact-view-detail h5').innerText = user.name;
    document.querySelector('#contact-view-detail img').src = user.avatar;

    const addressList = document.querySelector('.address-list ul');
    addressList.innerHTML = ''; // Xóa nội dung cũ

    // Lặp qua các địa chỉ và thêm vào danh sách
    address.forEach((address, index) => {
        const li = document.createElement('li');
        li.className = 'text-muted mb-3';
        li.innerHTML = `
            <div class="d-flex align-items-center">
                <input type="radio" name="is_default" id="address${index}" class="me-2"
                    ${address.is_default ? 'checked' : ''}>
                <label for="address${index}" class="fw-semibold">Địa chỉ ${index + 1}:</label>
            </div>
            <p>${address.address}</p>
        `;
        addressList.appendChild(li);
    });
}

</script>
