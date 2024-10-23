@extends('admin.layouts.master')

@section('title')
    Bình luận
@endsection

@push('style')
    <style>
        .comment-text {
            max-width: 150px;
            /* Chiều rộng tối đa của phần bình luận */
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            cursor: pointer;
        }

        td.comment-column {
            width: 28%;
            /* Giảm độ rộng của cột bình luận */
            white-space: normal;
            word-wrap: break-word;
        }

        td.status-column {
            width: 12%;
            /* Tăng độ rộng của cột trạng thái */
            text-align: center;
            /* Căn giữa nội dung trong cột trạng thái */
        }

        td.action-column {
            width: 10%;
            /* Đặt độ rộng cho cột hành động */
            text-align: center;
            /* Căn giữa nội dung trong cột hành động */
        }

        .gold-star {
            color: gold;
            /* Màu vàng cho sao */
        }
    </style>
@endpush


{{-- @section('content')
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
                                            <td>{{ $comment->user->full_name ?? 'user không tồn tại'}}</td>
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
    
@endsection --}}

@section('content')
    <div class="row">
        <div id="comment-list" class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.comments.listComment') }}" method="GET">
                        @csrf
                        <div class="row mb-2 ">
                            <!-- Tìm kiếm theo bình luận -->
                            {{-- <div class="col-lg-4">
                                <div class="d-flex justify-content-start">
                                    <div class="search-box ms-2 w-100">
                                        <input type="text" name="query" class="form-control search"
                                            placeholder="Tìm kiếm bình luận...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                            </div> --}}

                            <!-- Tìm kiếm theo người dùng -->
                            <div class="col-lg-3">
                                <div class="d-flex justify-content-start">
                                    <div class="search-box ms-2 w-100">
                                        <input type="text" name="user_query" class="form-control search"
                                            placeholder="Tìm kiếm theo tên người dùng...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Tìm kiếm theo trạng thái -->
                            <div class="col-lg-2">
                                <select class="form-control" name="status">
                                    <option value="" disabled selected>Tìm theo trạng thái</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <!-- Tìm kiếm theo ngày -->
                            <div class="col-lg-2">
                                <input type="date" name="date" class="form-control" placeholder="Tìm theo ngày">
                            </div>
                            <br>
                            <br>
                            <div class="col-lg-2 d-flex justify-content-start">
                                <button type="submit" class="btn btn-info" data-bs-toggle="offcanvas"
                                        href="#offcanvasExample"><i class="ri-filter-3-line align-bottom me-1"></i>Tìm
                                        kiếm</button>
                            </div>
                        </div>
                    </form>

                    <div class="live-preview mt-4">
                        <div class="table-responsive table-card">
                            <table class="table align-middle small" id="commentTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="sor" style="padding-left: 50px" data-sort="name">Người dùng</th>
                                        <th>Sản phẩm</th>
                                        <th>Đánh giá</th>
                                        <th >Bình luận</th>
                                        <th style="padding-left: 0px">Trạng thái</th>
                                        <th>Ngày bình luận</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listComment as $comment)
                                        <tr>
                                            <td style="padding-left: 50px">{{ $comment->user->full_name }}</td>
                                            <td>{{ $comment->product->name ?? 'Sản phẩm không tồn tại' }}</td>
                                            <td>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $comment->rating)
                                                        <i class="fas fa-star gold-star"></i> <!-- Sao đầy đủ màu vàng -->
                                                    @else
                                                        <i class="far fa-star"></i> <!-- Sao rỗng -->
                                                    @endif
                                                @endfor
                                            </td>
                                            <td >
                                                <div class="d-flex align-items-center">
                                                    <div class="comment-text me-2" id="comment-{{ $comment->id }}"
                                                        title="{{ $comment->comment }}">
                                                        {{ $comment->comment }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($comment->status == 1)
                                                    <div class="form-check form-switch form-switch-success form-switch-md text-start" dir="ltr">
                                                        <input type="checkbox" checked data-id="{{ $comment->id }}"
                                                            class="form-check-input change-status" id="customSwitchsizemd">
                                                    </div>
                                                @else
                                                    <div class="form-check form-switch form-switch-success form-switch-md" dir="ltr">
                                                        <input type="checkbox" data-id="{{ $comment->id }}"
                                                            class="form-check-input change-status" id="customSwitchsizemd">
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $comment->created_at }}</td>
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                        <a href="javascript:void(0);" class="view-item-btn"
                                                            data-comment-id="{{ $comment->id }}">
                                                            <i class="ri-eye-fill align-bottom text-muted fs-5"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Delete">

                                                        <a href="{{ route('admin.comments.deleteComment', $comment->id) }}"
                                                            class=" delete-item">
                                                            <i class="ri-delete-bin-fill align-bottom fs-5" style="color:#FF6600;"></i>
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
                        {{ $listComment->links() }}
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
    <!-- end row -->

    <!-- Modal Xem Bình luận -->
    <div class="modal fade" id="viewCommentModal" tabindex="-1" aria-labelledby="viewCommentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewCommentModalLabel">Chi tiết Bình luận</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="commentContent">
                        <!-- Nội dung bình luận sẽ được cập nhật qua JavaScript -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('script')
    <!-- Bootstrap JS -->


    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script>
        $(document).ready(function() {
            // Khi nhấn vào biểu tượng mắt
            $('.view-item-btn').on('click', function() {
                // Lấy ID bình luận từ thuộc tính data-comment-id
                var commentId = $(this).data('comment-id');
                console.log('ID của bình luận: ' + commentId);

                // Lấy nội dung bình luận tương ứng
                var commentText = $('#comment-' + commentId).text();
                console.log('Nội dung bình luận: ' + commentText);

                // Cập nhật nội dung cho modal
                $('#commentContent').text(commentText);

                // Mở modal
                $('#viewCommentModal').modal('show');
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
