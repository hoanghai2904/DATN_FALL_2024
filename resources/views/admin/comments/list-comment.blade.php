@extends('admin.layouts.master')

@section('title')
    Bình luận
@endsection
@push('style')
    <style>
        .comment-text {
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

td.comment-column {
    width: 40%; /* Đặt độ rộng cột bình luận */
    white-space: normal; /* Cho phép xuống dòng */
    word-wrap: break-word; /* Chia nhỏ từ khi cần */
}

    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <br>
            <br>
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Danh sách @yield('title')</h4>
                </div>

                @if (session('message'))
                    <div class="alert alert-info" role="alert">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="card-body">
                    <div class="live-preview">
                        <div class="table-responsive table-card">
                            <table class="table align-middle table-nowrap table-striped-columns mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Người dùng</th>
                                        <th scope="col">Sản phẩm</th>
                                        <th scope="col">Đánh giá</th>
                                        <th scope="col">Bình luận</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col" style="width: 150px;">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listComment as $comment)
                                        <tr>
                                            <td>{{ $comment->id }}</td>
                                            <td>{{ $comment->user->full_name}}</td>
                                            <!-- Tên người dùng -->
                                            <td>{{ $comment->product->name ?? 'Sản phẩm không tồn tại' }}</td>
                                            <!-- Tên sản phẩm -->
                                            <td>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $comment->rating)
                                                        <i class="fas fa-star"></i> <!-- Sao đầy đủ -->
                                                    @else
                                                        <i class="far fa-star"></i> <!-- Sao rỗng -->
                                                    @endif
                                                @endfor
                                            </td> <!-- Đánh giá -->
                                            
                                            <td class="comment-column">
                                                <div class="d-flex align-items-center">
                                                    <div class="comment-text me-2" id="comment-{{ $comment->id }}" title="{{ $comment->comment }}">
                                                        {{ $comment->comment }}
                                                    </div>
                                                    <i class="fas fa-eye comment-icon" data-id="{{ $comment->id }}" style="cursor: pointer;"></i>
                                                </div>
                                                <div class="modal fade" id="commentModal{{ $comment->id }}" tabindex="-1"
                                                    aria-labelledby="commentModalLabel{{ $comment->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="commentModalLabel{{ $comment->id }}">Bình luận</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{ $comment->comment }}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($comment->status == 1)
                                                    <div class="form-check form-switch form-switch-lg p-3" dir="ltr">
                                                        <input type="checkbox" checked data-id="{{ $comment->id }}"
                                                            class="form-check-input change-status" id="customSwitchsizemd">
                                                    </div>
                                                @else
                                                    <div class="form-check form-switch form-switch-lg p-3" dir="ltr">
                                                        <input type="checkbox" data-id="{{ $comment->id }}"
                                                            class="form-check-input change-status" id="customSwitchsizemd">
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.comments.deleteComment', $comment->id) }}"
                                                    class="btn btn-sm btn-danger delete-item">Xóa</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{ $listComment->links() }}
                            </div>
                        </div>
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->
    <!-- Modal -->
    
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
            $('.comment-icon').on('click', function() {
                // Lấy ID bình luận từ thuộc tính data-id
                var commentId = $(this).data('id');
                console.log('ID của bình luận: ' + commentId);
                
                // Lấy nội dung bình luận tương ứng
                var commentText = $('#comment-' + commentId).text();
                console.log('Nội dung bình luận: ' + commentText);
                
                // Mở modal với ID tương ứng
                $('#commentModal' + commentId).modal('show');
            });
        });
    </script>
    
    <script>
        // trang thai
        const notyf = new Notyf();
        $(document).ready(function() {
            $('body').on('click', '.change-status', function() {
                let isChecked = $(this).is(':checked');
                let id = $(this).data('id');
                console.log(isChecked, id);


                $.ajax({
                    url: "{{ route('admin.comments.change-status') }}",
                    method: 'PUT',
                    data: {
                        status: isChecked,
                        id: id
                    },
                    success: function(data) {
                        // toastr.success(data.message)
                        notyf.success(data.message);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                })

            })
        })
    </script>
       <script>
        // rating
        var basicRater = raterJs({
            element: document.querySelector("#basic-rater"),
            rateCallback: function(rating, done) {
                this.setRating(rating); // Gán xếp hạng người dùng chọn
                done(); // Xác nhận hoàn thành xếp hạng
            }
        });
    </script>
@endpush
