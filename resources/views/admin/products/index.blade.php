@extends('admin.layouts.master')

@section('title')
    Sản phẩm 
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Danh sách @yield('title')</h4>
                    <a href="#" class="btn btn-danger mx-2">Xóa</a>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-success">Thêm mới</a>
                </div>
                <!-- end card header -->

                <div class="card-body">
                    {{-- <p class="text-muted mb-4">Use .<code>table-striped-columns</code> to add zebra-striping to any table column.</p> --}}

                    <div class="live-preview">
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
