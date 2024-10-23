@extends('admin.layouts.master')

@section('title')
liên hệ
@endsection

@section('style-libs')




<script>
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
        $('.js-example-basic-single').select2();

        // Chức năng chọn tất cả checkbox
        $('#checkAll').on('change', function () {
            $('input[name="checkAll"]').prop('checked', this.checked);
        });
    });
</script>
@endsection
@push('style')
<style>
    .message-text {
        max-width: 200px;
        /* Điều chỉnh chiều rộng tối đa */
        overflow: hidden;
        white-space: nowrap;
        /* Ngăn văn bản xuống dòng */
        text-overflow: ellipsis;
        /* Hiển thị ... khi văn bản quá dài */
        cursor: pointer;
        /* Thay đổi con trỏ để biểu thị có thể nhấp */
    }

    i.fas.fa-eye {
        color: #007bff;
        /* Màu cho biểu tượng mắt */
        font-size: 20px;
        /* Kích thước biểu tượng */

    }

    table {
        table-layout: fixed;
        /* Giữ độ rộng cố định */
        width: 100%;
        /* Đặt bảng chiếm toàn bộ chiều rộng */
    }

    td.message-column {
        width: 40%;
        /* Đặt độ rộng cột bình luận */
        white-space: normal;
        /* Cho phép xuống dòng */
        word-wrap: break-word;
        /* Chia nhỏ từ khi cần */
    }
</style>
@endpush
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Danh sách @yield('title')</h4>
            </div>
            <!-- end card header -->
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="card-body">
                <div class="live-preview">
                    <!-- Form tìm kiếm -->
                    <form action="{{ route('admin.contacts.index') }}" method="GET">
                        <div class="row mb-5">
                            <!-- Tìm kiếm chung -->
                            <div class="col-lg-4 mb-3">
                                <h6 class="fw-semibold">Tìm kiếm chung</h6>
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" id="customSearchBox"
                                        placeholder="Search..." value="{{ request('search') }}">
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
                            <!-- Lọc theo trạng thái liên hệ -->
                            <div class="col-lg-2 mb-3">
                                <h6 class="fw-semibold">Trạng thái</h6>
                                <div class="input-group">
                                    <select name="status_contacts" class="form-control">
                                        <option value="">Tất cả</option>
                                        <option value="Chưa phản hồi" {{ request('status_contacts')=='Chưa phản hồi'
                                            ? 'selected' : '' }}>Chưa phản hồi</option>
                                        <option value="Đã phản hồi" {{ request('status_contacts')=='Đã phản hồi'
                                            ? 'selected' : '' }}>Đã phản hồi</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Nút tìm kiếm -->
                            <div class="col-lg-2 mb-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            </div>
                        </div>
                    </form>

                    <!-- Bảng danh sách liên hệ -->
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
                                    <th class="sort" data-sort="id">ID</th>
                                    <th class="sort" data-sort="name">Tên khách hàng</th>
                                    <th class="sort" data-sort="email" style="width:180px;">Email</th>
                                    <th class="sort" data-sort="phone">Điện thoại</th>
                                    <th class="sort">Ngày đặt hàng</th>
                                    <th class="sort" data-sort="message">Thông điệp</th>
                                    <th class="sort" data-sort="status">Trạng thái</th>
                                    <th class="sort" data-sort="actions">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($contacts as $contact)
                                <tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="checkAll"
                                                value="option1">
                                        </div>
                                    </th>
                                    <td class="id">{{ $contact->id }}</td>
                                    <td class="name">{{ $contact->name }}</td>
                                    <td class="email">{{ $contact->email }}</td>
                                    <td class="phone">{{ $contact->phone }}</td>
                                    <td class="created_at">
                                        {{ \Carbon\Carbon::parse($contact->created_at)->format('d/m/Y') }}
                                    </td>
                                    <td class="message-column">
                                        <div class="d-flex align-items-center">
                                            <div class="message-text me-2" id="message-{{ $contact->id }}"
                                                title="{{  $contact->message}}">
                                                {{ $contact->message}}
                                            </div>
                                            <!-- <i class="fas fa-eye message-icon" data-id="{{ $contact->id }}" style="cursor: pointer; font-size: 12px;"></i> -->
                                        </div>
                                        <div class="modal fade" id="messageModal{{ $contact->id }}" tabindex="-1"
                                            aria-labelledby="messageModalLabel{{ $contact->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="messageModalLabel{{ $contact->id }}">Bình luận</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{ $contact->message}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Đóng</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="status_contacts">
                                        @if($contact->status_contacts === 'Đã phản hồi')
                                        <span class="badge bg-success">Đã phản hồi</span>
                                        @else
                                        <span class="badge bg-warning">Chưa giải quyết</span>
                                        @endif
                                    </td>
                                    <td>
                                        <ul class="list-inline hstack gap-2 mb-0">

                                            <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                <a href="#showModal" data-bs-toggle="modal"
                                                    class="text-primary d-inline-block edit-item-btn"
                                                    data-id="{{ $contact->id }}"
                                                    data-name="{{ $contact->name }}"
                                                    data-email="{{ $contact->email }}">
                                                    <i class="ri-mail-fill fs-16"></i>
                                                    </a>
                                            </li>

                                            <i class="fas fa-eye message-icon" data-id="{{ $contact->id }}"
                                                style="cursor: pointer; font-size: 12px;"></i>
                                            <li class="list-inline-item" data-bs-toggle="tooltip"
                                                data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                @if ($contact->status_contacts == 'Đã phản hồi')
                                                <form action="{{ route('admin.contacts.destroy', $contact->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('admin.contacts.destroy', $contact->id) }}" 
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
                    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="exampleModalLabel">Phản hồi liên hệ</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        id="close-modal"></button>
                                </div>
                                @foreach ($contacts as $contact)
                                <form action="{{ route('admin.contacts.sendResponse', $contact->id) }}" method="POST" id="responseForm">
                                    @csrf
                                    <div class="modal-body">
                                    <div class="mb-3 d-flex align-items-center">
                                        <label class="form-label mb-0 me-2">Name:</label>
                                        <p class="contact-name mb-0">{{ $contact->name }}</p>
                                    </div>
                                    <div class="mb-3 d-flex align-items-center">
                                        <label class="form-label mb-0 me-2">Email:</label>
                                        <p class="contact-email mb-0">{{ $contact->email }}</p>
                                    </div>
                                        <div class="mb-3">
                                            <label for="response_message" class="form-label">Nội dung phản hồi</label>
                                            <textarea class="form-control" name="response_message" rows="4" required>{{ old('response_message') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-primary">Gửi phản hồi</button>
                                    </div>
                                </form>
                                @endforeach
                            </div>
                        </div>
                    </div>


                    <!-- Phân trang -->
                    <div class="d-flex justify-content-end">
                        {{ $contacts->links() }}
                    </div>

                </div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div>
<!-- end row -->
@endsection
@push('script')
<!-- Bootstrap JS -->


<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script>
    $(document).ready(function () {
        // Khi nhấn vào biểu tượng mắt
        $('.message-icon').on('click', function () {
            // Lấy ID bình luận từ thuộc tính data-id
            var messageId = $(this).data('id');
            console.log('ID của bình luận: ' + messageId);

            // Lấy nội dung bình luận tương ứng
            var messageText = $('#message-' + messageId).text();
            console.log('Nội dung bình luận: ' + messageText);

            // Mở modal với ID tương ứng
            $('#messageModal' + messageId).modal('show');
        });
    });
</script>

<script>


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
    $(document).on('click', '.edit-item-btn', function () {
    var contactId = $(this).data('id');
    var contactName = $(this).data('name');
    var contactEmail = $(this).data('email');

    // Cập nhật thông tin vào modal
    $('#showModal form').attr('action', '/admin/contacts/' + contactId + '/sendResponse');
    $('#showModal .modal-body p.contact-name').text(contactName);
    $('#showModal .modal-body p.contact-email').text(contactEmail);

    // Mở modal
    $('#showModal').modal('show');
});


</script>
@endpush