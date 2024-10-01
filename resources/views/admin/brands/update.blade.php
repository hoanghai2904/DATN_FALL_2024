{{-- extends: Chỉ định layout được sử dụng --}}
@extends('admin.layouts.master')

@section('title')
    Sửa
@endsection

{{-- section: định nghĩa nội dung của section --}}
@section('content')
    <div class="card">
        <h4 class="card-header">Sửa sản phẩm</h4>
        <div class="card-body">
            <form action="{{ route('admin.brands.update', $brands->id) }}" method="POST" enctype="multipart/form-data">
                {{-- 1 cơ chế bảo mật của laravel --}}
                @method('put')
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">Nhãn hiệu:</label>
                    <input type="file" class="form-control" name="logo" >
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Tên thương hiệu:</label>
                    <input type="text" class="form-control" name="name" value="{{$brands->name}}" placeholder="">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Slug:</label>
                    <input type="text" class="form-control" name="slug" value="{{$brands->slug}} placeholder="">
                </div>
                <div class="mb-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-success">Sửa </button>
                </div>
            </form>
        </div>
    </div>
@endsection
