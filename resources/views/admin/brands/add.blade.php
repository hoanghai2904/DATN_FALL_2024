{{-- extends: Chỉ định layout được sử dụng --}}
@extends('admin.layouts.master')

@section('title')
    Thêm 
@endsection

{{-- section: định nghĩa nội dung của section --}}
@section('content')
    <div class="card">
        <h4 class="card-header">Thêm </h4>
        <div class="card-body">
            <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                {{-- 1 cơ chế bảo mật của laravel --}}
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">Logo:</label>
                    <input type="file" class="form-control" name="logo">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Name:</label>
                    <input type="text" class="form-control" name="name" placeholder="">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Slug:</label>
                    <input type="text" class="form-control" name="slug" placeholder="">
                </div>
                <div class="mb-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-success">Thêm mới</button>
                </div>
            </form>
        </div>
    </div>
@endsection
