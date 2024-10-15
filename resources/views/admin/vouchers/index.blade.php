@extends('admin.layouts.master')

@section('title')
    Bài viết
@endsection

@section('style-libs')
    <style>
        td.break-word {
            width: 250px;
            word-wrap: break-word;
            word-break: break-all;
            white-space: normal;
        }

        th.no-sort::after,
        th.no-sort::before {
            display: none !important;
            /* Ẩn icon sắp xếp cột checkbox */
        }
    </style>
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12">
            @if (session('msg'))
                <div class="alert alert-success">{{ session('msg') }}</div>
            @endif
            @if (session('msg_warning'))
                <div class="alert alert-danger">{{ session('msg_warning') }}</div>
            @endif
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Danh sách @yield('title')</h4>
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-success" style="width: 150px;">Thêm mới</a>
                </div>
                <!-- end card header -->

                <div class="card-body">
                    <form action="{{ route('admin.posts.index') }}" method="GET">
                        @csrf
                        <div class="row mb-5">
                            <div class="col-lg-3">
                                <h6 class="fw-semibold">Danh mục</h6>
                                <select class="js-example-basic-multiple select2-hidden-accessible" name="categories[]" multiple="">
                                    <option value="" disabled>Chọn danh mục</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3">
                                <h6 class="fw-semibold">Tác giả</h6>
                                <select class="js-example-basic-single select2-hidden-accessible" name="authors">
                                    <option value="" disabled selected>Chọn tác giả</option>
                                    @foreach ($authors as $author)
                                        <option value="{{ $author->id }}">{{ $author->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-4">
                                <div class="d-flex justify-content-start mt-4">
                                    <div class="search-box ms-2 w-100">
                                        <input type="text" id="customSearchBox" class="form-control search" placeholder="Nhập từ khóa tìm kiếm...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 mt-4">
                                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            </div>
                        </div>
                    </form>

                    <div class="live-preview mt-4">
                        <div class="table-responsive table-card">
                            <table id="myTable" class="table align-middle table-nowrap table-striped-columns mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="no-sort">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="cardtableCheck">
                                                <label class="form-check-label" for="cardtableCheck"></label>
                                            </div>
                                        </th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Tác giả</th>
                                        <th scope="col">Tiêu đề</th>
                                        <th scope="col">Danh mục</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col" style="width: 150px;">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $post)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="cardtableCheck01">
                                                    <label class="form-check-label" for="cardtableCheck01"></label>
                                                </div>
                                            </td>
                                            <td>{{ $post->id }}</td>
                                            <td>{{ $post->User ? $post->User->full_name : 'Không tên tác giả' }}</td>
                                            <td class="break-word">{{ $post->title }}</td>
                                            <td>{{ $post->Category ? $post->Category->name : 'Không có danh mục' }}</td>
                                            <td>
                                                @if ($post->status == 2)
                                                    <div class="form-check form-switch form-switch-lg p-3" dir="ltr">
                                                        <input type="checkbox" checked data-id="{{ $post->id }}" class="form-check-input change-status" id="customSwitchsizemd">
                                                    </div>
                                                @else
                                                    <div class="form-check form-switch form-switch-lg p-3" dir="ltr">
                                                        <input type="checkbox" data-id="{{ $post->id }}" class="form-check-input change-status" id="customSwitchsizemd">
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                                                <a href="{{ route('admin.posts.destroy', $post->id) }}" class="btn btn-sm btn-danger delete-item">Xóa</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end card-body -->
                <div class="p-3">
                    {{ $posts->links() }}
                </div>
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
    <!-- end row -->
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $(".js-example-basic-single").select2(),
            $(".js-example-basic-multiple").select2({
                // placeholder: "Chọn danh mục",
            });
        });

        $(document).ready(function() {
            var table = $('#myTable').DataTable({
                "dom": '<"top">rt<"bottom"><"clear">',
                "columnDefs": [{
                    "orderable": false,
                    "targets": [0, 2, 5, 6] // Không hiển thị sắp xếp ở cột checkbox, trạng thái và hành động
                }],
                "language": {
                    "emptyTable": "Không có dữ liệu phù hợp",
                    "zeroRecords": "Không tìm thấy bản ghi nào phù hợp",
                    "infoEmpty": "Không có bản ghi để hiển thị",
                }
            });

            $('#customSearchBox').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>

    <script>
        const notyf = new Notyf();
        $(document).ready(function() {
            $('body').on('click', '.change-status', function() {
                let isChecked = $(this).is(':checked');
                let id = $(this).data('id');
                console.log(isChecked, id);

                $.ajax({
                    url: "{{ route('admin.posts.updateStatus') }}",
                    method: 'PUT',
                    data: {
                        status: isChecked,
                        id: id
                    },
                    success: function(data) {
                        notyf.success(data.message);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endpush
