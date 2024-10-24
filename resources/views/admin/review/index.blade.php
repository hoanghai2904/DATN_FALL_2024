{{-- extends: Chỉ định layout được sử dụng --}}
@extends('admin.layouts.master')

@section('title')
    Review
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
{{-- section: định nghĩa nội dung của section --}}
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Danh sách @yield('title')</h4>
            </div>
            <!-- end card header -->
            @if (session('message'))
            <div class="alert alert-info" role="alert">
                {{ session('message') }}
            </div>
            
        @endif
            <div class="card-body">
                <div class="row mb-5 ">
                    <div class="col-lg-4">
                        <div class="d-flex justify-content-start mt-4">
                            <div class="search-box ms-2 w-100">
                                <input type="text" id="customSearchBox" class="form-control search"
                                    placeholder="Search...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 mt-4">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                </div>
                <div class="live-preview">
                    <div class="table-responsive table-card">
                        <table id="myTable" class="table align-middle table-nowrap table-striped-columns mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 46px;" class="no-sort">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="cardtableCheck">
                                            <label class="form-check-label" for="cardtableCheck"></label>
                                        </div>
                                    </th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Id User</th>
                                    <th scope="col">Id trạng thái đơn hàng</th>
                                    <th scope="col">Id sản phấm </th>
                                    <th scope="col">Đánh giá  </th>
                                    <th scope="col">Nội dung </th>
                                    <th scope="col" style="width: 150px;">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listReview as $review)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="cardtableCheck01">
                                        <label class="form-check-label" for="cardtableCheck01"></label>
                                    </div>
                                </td>
                                <td>{{ $review->id }}</td>
                                <td>{{ $review->user->full_name }}</td>
                                <td>{{ $review->order_statuses->status }}</td>
                                {{-- <td>{{ $review->product->name 'Sản phẩm không tồn tại' }}</td> --}}
                                {{-- <td>{{ $review->rating }}</td> --}}
                                <td>
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            <i class="fas fa-star"></i> <!-- Sao đầy đủ -->
                                        @else
                                            <i class="far fa-star"></i> <!-- Sao rỗng -->
                                        @endif
                                    @endfor
                                </td> <!-- Đánh giá -->

                                {{-- <td>{{ $review->comment }}</td> --}}
                                <td class="comment-column">
                                    <div class="d-flex align-items-center">
                                        <div class="comment-text me-2" id="review-{{ $review->id }}" title="{{ $review->comment }}">
                                            {{ $review->comment }}
                                        </div>
                                        <i class="fas fa-eye comment-icon" data-id="{{ $review->id }}" style="cursor: pointer;"></i>
                                    </div>
                                    <div class="modal fade" id="reviewModal{{ $review->id }}" tabindex="-1"
                                        aria-labelledby="reviewModalLabel{{ $review->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="reviewModalLabel{{ $review->id }}">Bình luận</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ $review->comment }}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            {{-- <li class="list-inline-item" data-bs-toggle="tooltip"
                                                data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                <a href="javascript:void(0);" class="view-item-btn"
                                                    data-comment-id="{{ $item->id }}">
                                                    <i class="ri-eye-fill align-bottom text-muted fs-5"></i>
                                                </a>
                                            </li> --}}
                                            <li class="list-inline-item" data-bs-toggle="tooltip"
                                                data-bs-trigger="hover" data-bs-placement="top" title="Delete">
    
                                                <a href="{{ route('admin.review.deleteReview', $review->id) }}"
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
            </div><!-- end card-body -->
            <div class="p-3">
                {{ $listReview->links() }}
            </div>
        </div>
        <!-- end card -->
    </div><!-- end col -->
</div>
    
        
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
            $('.review-icon').on('click', function() {
                // Lấy ID bình luận từ thuộc tính data-id
                var reviewId = $(this).data('id');
                console.log('ID của bình luận: ' + reviewId);
                
                // Lấy nội dung bình luận tương ứng
                var reviewText = $('#review-' + reviewId).text();
                console.log('Nội dung bình luận: ' + reviewText);
                
                // Mở modal với ID tương ứng
                $('#reviewModal' + reviewId).modal('show');
            });
        });
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