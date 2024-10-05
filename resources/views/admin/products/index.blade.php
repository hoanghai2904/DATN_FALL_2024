@extends('admin.layouts.master')
@push('style')

@endpush

@section('title')
    Sản phẩm 
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
                    <form action="abc">
                        <div class="row mb-5 ">
                            <div class="col-lg-3" data-select2-id="select2-data-1">
                                <h6 class="fw-semibold">Danh mục</h6>
                                <select class="js-example-basic-multiple select2-hidden-accessible" name="states[]" multiple="" data-select2-id="select2-data-2" tabindex="-1" aria-hidden="true">
                                    <optgroup label="ABC" data-select2-id="select2-data-43-nhx0">
                                        <option value="A" selected data-select2-id="select2-data-44-2wrh">A</option>
                                        <option value="B" selected="" data-select2-id="select2-data-21-9hc0">B</option>
                                        <option value="C" data-select2-id="select2-data-45-zi4r">C</option>
                                    </optgroup>
                                </select>
                            </div>

                            <div class="col-lg-3" data-select2-id="select2-data-2">
                                <h6 class="fw-semibold">Thương hiệu</h6>
                                <select class="js-example-basic-single select2-hidden-accessible"  name="state"  data-select2-id="select2-data-16-g9og" tabindex="-1" aria-hidden="true">
                                    <option value="AL" data-select2-id="select2-data-18-9avy">Alabama</option>
                                    <option value="MA" data-select2-id="select2-data-73-26iq">Madrid</option>
                                    <option value="TO" data-select2-id="select2-data-74-9rir">Toronto</option>
                                    <option value="LO" data-select2-id="select2-data-75-jxz2">Londan</option>
                                    <option value="WY" data-select2-id="select2-data-76-uypr">Wyoming</option>
                                </select>
                            </div>

                            <div class="col-lg-4">
                                <div class="d-flex justify-content-start mt-4">
                                    <div class="search-box ms-2 w-100">
                                        <input type="text" class="form-control search" placeholder="Search...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-end mt-4">
                                <a href="b" class="btn btn-primary">Tìm kiếm</a>
                            </div>
                        </div>
                    </form>

                    <div class="live-preview mt-4">
                        <div class="table-responsive table-card">
                            <table class="table align-middle table-nowrap table-striped-columns mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width: 46px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="cardtableCheck">
                                                <label class="form-check-label" for="cardtableCheck"></label>
                                            </div>
                                        </th>
                                        {{-- <th scope="col">ID</th> --}}
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
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="cardtableCheck01">
                                                <label class="form-check-label" for="cardtableCheck01"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <img width="80px" class="img-thumbnail" src="https://product.hstatic.net/200000264739/product/royal_canin_kitten_645acb46d6a84c83bef4336c7db15fd9_master.jpg" alt="">
                                        </td>
                                        <td>Hạt Royal Canin Kitten cho mèo con</td>
                                        <td><a href="#" class="fw-medium">#VL2110</a></td>
                                        <td>85,500₫</td>
                                        <td>Sản phẩm cho mèo
                                            <li>Hạt cho mèo </li>
                                            <li>Thức ăn hạt</li>

                                        </td>
                                        <td>Royal Canin</td>
                                        <td>
                                            <div class="form-check form-switch form-switch-lg p-3" dir="ltr">
                                                <input type="checkbox" class="form-check-input" id="customSwitchsizemd">
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info">Chi tiết</button>
                                            <button type="button" class="btn btn-sm btn-warning">Sửa</button>
                                            {{-- <button type="button" class="btn   btn-sm btn-danger">Xóa</button> --}}
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
<!-- end row -->

@endsection

@push('script')
    <script>
        $(document).ready(function () {
            $(".js-example-basic-single").select2(),
            $(".js-example-basic-multiple").select2();
        });
    </script>
@endpush