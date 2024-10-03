{{-- extends: Chỉ định layout được sử dụng --}}
@extends('admin.layouts.master')

@section('title')
    Brands trash
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
                <a href="{{ route('admin.brands.index') }}" class="btn btn-success">Quay lại</a>
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
                                        <button class="btn btn-sm btn-warning">Phục hồi</button>
                                    </a>
                                    {{-- <a href="{{ route('admin.brands.edit', $item->id) }}">
                                        <button class="btn btn-sm btn-warning">Sửa</button>
                                    </a> --}}

                                    <form action="{{ route('admin.brands.destroy', $item->id) }}" method="post" class="d-inline">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" onclick="return confirm('Bạn có muốn xóa không ???')" class="btn btn-sm btn-danger">Xóa vĩnh viễn</button>
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
