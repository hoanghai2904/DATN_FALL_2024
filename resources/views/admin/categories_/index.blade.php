@extends('admin.layouts.master')

@section('title')
    danh mục
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
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Danh sách @yield('title')</h4>
                    {{-- <a href="#" class="btn btn-danger mx-2">Xóa</a> --}}
                    <a href="{{ route('admin.categories_.create') }}" class="btn btn-success">Thêm mới</a>
                </div>
                <!-- end card header -->

                <div class="card-body">
                    <form action="{{ route('admin.categories_.index') }}" method="GET">
                        @csrf
                        <div class="row mb-5 ">
                            {{-- <div class="col-lg-3">
                            <h6 class="fw-semibold">Danh mục</h6>
                            <select class="js-example-basic-multiple select2-hidden-accessible" name="categories[]"
                                multiple="">
                                <option value="" disabled>Chọn danh mục </option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                         --}}

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
                    </form>

                    <div class="live-preview mt-4">
                        <div class="table-responsive table-card">
                            <table id="categoryTable" class="table align-middle table-nowrap table-striped-columns mb-0">
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
                                        <th scope="col">Tên Danh mục</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Ngày tạo mới</th>
                                        <th scope="col" style="width: 150px;">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="cardtableCheck01">
                                                    <label class="form-check-label" for="cardtableCheck01"></label>
                                                </div>
                                            </td>
                                            <td>{{ $category->id }}</td>
                                            <td>
                                                {{ $category->name }} <!-- Tên danh mục cha -->
                                                {{-- <div>
                                                    @if ($category->children->isNotEmpty())
                                                        <div style="padding-left: 20px;">
                                                            <!-- Thêm khoảng cách cho danh mục con -->
                                                            @foreach ($category->children as $child)
                                                                <div>&mdash; {{ $child->name }}</div>
                                                                <!-- Hiển thị tên danh mục con -->
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div> --}}
                                            </td>
                                            <td>
                                                @if ($category->status == 1)
                                                    <div class="form-check form-switch form-switch-lg p-3" dir="ltr">
                                                        <input type="checkbox" checked data-id="{{ $category->id }}"
                                                            class="form-check-input change-status" id="customSwitchsizemd">
                                                    </div>
                                                @else
                                                    <div class="form-check form-switch form-switch-lg p-3" dir="ltr">
                                                        <input type="checkbox" data-id="{{ $category->id }}"
                                                            class="form-check-input change-status" id="customSwitchsizemd">
                                                    </div>
                                                @endif

                                            </td>
                                            <td>{{ $category->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                {{-- <button type="button" class="btn btn-sm btn-info">Chi tiết</button> --}}
                                                <a href="{{ route('admin.categories_.edit', $category->id) }}"
                                                    class="btn btn-sm btn-warning">Sửa</a>
                                                <a href="{{ route('admin.categories_.destroy', $category->id) }}"
                                                    class="btn btn-sm btn-icon btn-danger delete-item"><i
                                                        class=" ri-delete-bin-line"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end card-body -->
                <div class="p-3">
                    {{ $categories->links() }}
                </div>
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
    <!-- end row -->
@endsection

@push('script')
    <script>
        // DataTable 
        $(document).ready(function() {
            var table = $('#categoryTable').DataTable({
                "dom": '<"top">rt<"bottom"><"clear">',
                "columnDefs": [{
                    "orderable": false,
                    "targets": [0, 3, 5]
                }],
                "language": {
                    "emptyTable": "Không có dữ liệu phù hợp", // Thay đổi thông báo không có dữ liệu
                    "zeroRecords": "Không tìm thấy bản ghi nào phù hợp", // Thay đổi thông báo không có bản ghi tìm thấy
                    "infoEmpty": "Không có bản ghi để hiển thị", // Thông báo khi không có dữ liệu để hiển thị
                }
            });

            // Tìm kiếm
            $('#customSearchBox').on('keyup', function() {
                table.search(this.value).draw(); // Áp dụng tìm kiếm trên bảng
            });

        });
        // change-status
        const notyf = new Notyf();
        $(document).ready(function() {
            $('body').on('click', '.change-status', function() {
                let isChecked = $(this).is(':checked');
                let id = $(this).data('id');


                $.ajax({
                    // Thay route 
                    url: "{{ route('admin.category.change-status') }}",
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
@endpush
