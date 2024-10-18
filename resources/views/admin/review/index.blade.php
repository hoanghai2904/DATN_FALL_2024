{{-- extends: Chỉ định layout được sử dụng --}}
@extends('admin.layouts.master')

@section('title')
    Review
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
{{-- section: định nghĩa nội dung của section --}}
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Danh sách @yield('title')</h4>
                
                <a href="{{ route('admin.review.create') }}"><button type="button" class="btn btn-success add-btn" ><i class="ri-add-line align-bottom me-1"></i> Thêm mới</button></a>
            </div>
            <!-- end card header -->
            @if (session('message'))
            <div class="alert alert-info" role="alert">
                {{ session('message') }}
            </div>
            
        @endif
            <div class="card-body">
                {{-- <p class="text-muted mb-4">Use .<code>table-striped-columns</code> to add zebra-striping to any table column.</p> --}}
                {{-- <div class="row mb-5 ">
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
                </div> --}}
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
                                @foreach ($reviews as $index => $item)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="cardtableCheck01">
                                        <label class="form-check-label" for="cardtableCheck01"></label>
                                    </div>
                                </td>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->user->full_name }}</td>
                                {{-- <td>{{ $item->order_statuses->status }}</td> --}}
                                {{-- <td>{{ $item->product->product_id }}</td> --}}
                                <td>{{ $item->rating }}</td>
                                <td>{{ $item->comment }}</td>
                                <td>
                                    {{-- <a href="{{ route('admin.review.edit', $item->id) }}">
                                        <button class="btn btn-sm btn-warning">Sửa</button>
                                    </a> --}}
                                    <form action="{{ route('admin.review.destroy', $item->id) }}" method="post" class="d-inline">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" onclick="return confirm('Bạn có muốn xóa không ???')" class="btn btn-sm btn-danger">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- end card-body -->
            {{-- <div class="p-3">
                {{ $review->links() }}
            </div> --}}
        </div>
        <!-- end card -->
    </div><!-- end col -->
</div>
    
        
@endsection

