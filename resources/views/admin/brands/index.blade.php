{{-- extends: Chỉ định layout được sử dụng --}}
@extends('admin.layouts.master')

@section('title')
    Brands
@endsection
{{-- @push('style')
<style>
    #bannerCarousel {
        max-width: 400px; /* Adjust the width to your preference */
        margin: 0 auto; /* Centers the carousel horizontally */
    }
    #bannerCarousel img {
        max-height: 500px; /* Adjust the height to your preference */
        object-fit: cover; /* Ensures the images fit within the container without distortion */
    }
</style>
@endpush --}}
{{-- section: định nghĩa nội dung của section --}}
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Danh sách @yield('title')</h4>
                <a href="{{ route('admin.brands.create') }}" class="btn btn-success">Thêm mới</a>
            </div>
            <!-- end card header -->
            @if (session('message'))
            <div class="alert alert-info" role="alert">
                {{ session('message') }}
            </div>
            
        @endif
            <div class="card-body">
                {{-- <p class="text-muted mb-4">Use .<code>table-striped-columns</code> to add zebra-striping to any table column.</p> --}}
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
                                    <th scope="col">ID</th>
                                    <th scope="col">Hình ảnh</th>
                                    <th scope="col">Tên thương hiệu</th>
                                    <th scope="col">Đại diện thương hiệu</th>
                                    <th scope="col" style="width: 150px;">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brands as $index => $item)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""id="itemCheck{{ $item }}">
                                        <label class="form-check-label" for="itemCheck{{ $item }}"></label>
                                    </div>
                                </td>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img src="{{ Storage::url($item->logo) }}" width="100" height="100" alt="">
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->slug }}</td>
                                <td>
                                    <a href="{{ route('admin.brands.edit', $item->id) }}">
                                        <button class="btn btn-sm btn-warning">Sửa</button>
                                    </a>

                                    <form action="{{ route('admin.brands.destroy', $item->id) }}" method="post" class="d-inline">
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
        </div><!-- end card -->
    </div><!-- end col -->
</div>
    
        
@endsection
@push('script')
    <script>
        $(document).ready(function () {
            $(".js-example-basic-single").select2(),
            $(".js-example-basic-multiple").select2();
        });
    </script>
@endpush