@extends('admin.layouts.master')

@section('title')
  liên hệ
@endsection

@section('style-libs')
    <!-- Custom styles for this page -->
    <link href="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('script-libs')
    <!-- Page level plugins -->
    <script src="{{ asset('theme/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('theme/admin/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('theme/admin/js/demo/datatables-demo.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
            $('.js-example-basic-single').select2();

            // Chức năng chọn tất cả checkbox
            $('#checkAll').on('change', function() {
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
    table-layout: fixed; /* Giữ độ rộng cố định */
    width: 100%; /* Đặt bảng chiếm toàn bộ chiều rộng */
}

td.message-column {
    width: 40%; /* Đặt độ rộng cột bình luận */
    white-space: normal; /* Cho phép xuống dòng */
    word-wrap: break-word; /* Chia nhỏ từ khi cần */
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
                            <div class="col-lg-3 mb-3">
                                <h6 class="fw-semibold">Tìm kiếm chung</h6>
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                                    <span class="input-group-text">
                                        <i class="ri-search-line search-icon"></i>
                                    </span>
                                </div>
                            </div>
                            <!-- Tìm kiếm theo email -->
                            <div class="col-lg-2 mb-3">
                                <h6 class="fw-semibold">Email</h6>
                                <div class="input-group">
                                    <input type="text" name="email" class="form-control" placeholder="Nhập email" value="{{ request('email') }}">
                                </div>
                            </div>
                            <!-- Lọc theo trạng thái liên hệ -->
                            <div class="col-lg-2 mb-3">
                                <h6 class="fw-semibold">Trạng thái</h6>
                                <div class="input-group">
                                    <select name="status_contacts" class="form-control">
                                        <option value="">Tất cả</option>
                                        <option value="Chưa phản hồi" {{ request('status_contacts') == 'Chưa phản hồi' ? 'selected' : '' }}>Chưa phản hồi</option>
                                        <option value="Đã phản hồi" {{ request('status_contacts') == 'Đã phản hồi' ? 'selected' : '' }}>Đã phản hồi</option>
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
                        <table class="table table-nowrap align-middle" id="contactTable">
                            <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th scope="col" style="width: 25px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                        </div>
                                    </th>
                                    <th class="sort" data-sort="id">ID</th>
                                    <th class="sort" data-sort="name">Tên</th>
                                    <th class="sort" data-sort="email">Email</th>
                                    <th class="sort" data-sort="phone">Điện thoại</th>
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
                                                <input class="form-check-input" type="checkbox" name="checkAll" value="option1">
                                            </div>
                                        </th>
                                        <td class="id">{{ $contact->id }}</td>
                                        <td class="name">{{ $contact->name }}</td>
                                        <td class="email">{{ $contact->email }}</td>
                                        <td class="phone">{{ $contact->phone }}</td>
                                        
                                        <td class="message-column">
                                                <div class="d-flex align-items-center">
                                                    <div class="message-text me-2" id="message-{{ $contact->id }}" title="{{  $contact->message}}">
                                                        {{  $contact->message}}
                                                    </div>
                                                    <i class="fas fa-eye message-icon" data-id="{{ $contact->id }}" style="cursor: pointer;"></i>
                                                </div>
                                                <div class="modal fade" id="messageModal{{ $contact->id }}" tabindex="-1"
                                                    aria-labelledby="messageModalLabel{{ $contact->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="messageModalLabel{{ $contact->id }}">Bình luận</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{  $contact->message}}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        <td class="status_contacts">{{ $contact->status_contacts}}</td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Reply">
                                                    <a href="{{ route('admin.contacts.reply', $contact->id) }}" class="text-primary d-inline-block">
                                                        <i class="ri-mail-send-line fs-16"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                    <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-danger d-inline-block remove-item-btn delete-item" style="border: none; background: none;">
                                                            <i class="ri-delete-bin-5-fill fs-16"></i>
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rater-js/1.1.0/rater.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/rater-js/1.1.0/rater.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
 
    <script>
        $(document).ready(function() {
            // Khi nhấn vào biểu tượng mắt
            $('.message-icon').on('click', function() {
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

@endpush