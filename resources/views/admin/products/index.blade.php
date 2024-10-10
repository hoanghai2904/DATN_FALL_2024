@extends('admin.layouts.master')
@push('style')
@endpush

@section('title')
    Sản phẩm
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
                    <a href="{{ route('admin.products.create') }}" class="btn btn-success">Thêm mới</a>
                </div>
                <!-- end card header -->

                <div class="card-body">
                    <form action="{{ route('admin.products.index') }}" method="GET">
                        @csrf
                        <div class="row mb-5 ">
                            <div class="col-lg-3">
                                <h6 class="fw-semibold">Danh mục</h6>
                                <select class="js-example-basic-multiple select2-hidden-accessible" name="categories[]"
                                    multiple="">
                                    <option value="" disabled>Chọn danh mục </option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3">
                                <h6 class="fw-semibold">Thương hiệu</h6>
                                <select class="js-example-basic-single select2-hidden-accessible" name="brands">
                                    <option value="" disabled selected>Chọn thương hiệu </option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>

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
                                        <th scope="col">Hình ảnh</th>
                                        <th scope="col">Tên</th>
                                        <th scope="col">Mã sản phẩm</th>
                                        <th scope="col">Giá</th>
                                        <th scope="col">Danh mục</th>
                                        <th scope="col">Thương hiệu</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col" style="width: 150px;">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="cardtableCheck01">
                                                    <label class="form-check-label" for="cardtableCheck01"></label>
                                                </div>
                                            </td>
                                            <td>{{ $product->id }}</td>
                                            <td>
                                                <img width="80px" class="img-thumbnail"
                                                    src="{{ asset('storage/' . $product->thumbnail) }}" alt="">
                                            </td>
                                            <td class="break-word">{{ $product->name }}</td>
                                            <td><a href="#" class="fw-medium">{{ $product->sku }}</a></td>
                                            <td>
                                                @if ($product->price_sale > 0)
                                                    <div>
                                                        <div data-order="{{ $product->price_sale }}">
                                                            {{ number_format($product->price_sale, 0, ',', '.') }}₫</div>
                                                        <del style="color: red"
                                                            data-order="{{ $product->price }}">{{ number_format($product->price, 0, ',', '.') }}₫</del>
                                                    </div>
                                                @else
                                                    <div data-order="{{ $product->price }}">
                                                        {{ number_format($product->price, 0, ',', '.') }}₫</div>
                                                @endif
                                            </td>
                                            <td>{{ $product->category->name }}
                                            </td>
                                            <td>{{ $product->brand->name }}</td>
                                            <td>
                                                {{-- <div class="form-check form-switch form-switch-lg p-3" dir="ltr">
                                                    <input type="checkbox" class="form-check-input" id="customSwitchsizemd">
                                                </div> --}}

                                                @if ($product->status == 1)
                                                    <div class="form-check form-switch form-switch-lg p-3" dir="ltr">
                                                        <input type="checkbox" checked data-id="{{ $product->id }}"
                                                            class="form-check-input change-status" id="customSwitchsizemd">
                                                    </div>
                                                @else
                                                    <div class="form-check form-switch form-switch-lg p-3" dir="ltr">
                                                        <input type="checkbox" data-id="{{ $product->id }}"
                                                            class="form-check-input change-status" id="customSwitchsizemd">
                                                    </div>
                                                @endif

                                            </td>
                                            <td>
                                                {{-- <button type="button" class="btn btn-sm btn-info">Chi tiết</button> --}}
                                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                                                <a href="{{ route('admin.products.destroy', $product->id) }}"
                                                    class="btn btn-sm btn-danger delete-item">Xóa</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end card-body -->
                <div class="p-3">
                    {{ $products->links() }}
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
                // "searching": false,
                "columnDefs": [{
                    "orderable": false,
                    "targets": [0, 2, 8,
                        9] // Ko hiển thị sắp xếp cột checkbox , hình ảnh , trạng thái , hđộng
                }],
                "language": {
                    "emptyTable": "Không có dữ liệu phù hợp", // Thay đổi thông báo không có dữ liệu
                    "zeroRecords": "Không tìm thấy bản ghi nào phù hợp", // Thay đổi thông báo không có bản ghi tìm thấy
                    "infoEmpty": "Không có bản ghi để hiển thị", // Thông báo khi không có dữ liệu để hiển thị
                }
            });

            $('#customSearchBox').on('keyup', function() {
                table.search(this.value).draw(); // Áp dụng tìm kiếm trên bảng
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
                    url: "{{ route('admin.product.change-status') }}",
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
