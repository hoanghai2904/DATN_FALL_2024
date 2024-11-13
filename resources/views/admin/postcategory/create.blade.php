@extends('admin.layouts.master')

@section('title')
    Thêm mới danh mục
@endsection

@section('content')
    <form class="needs-validation" action="{{ route('admin.postcategories.addPostPostCategory') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Tên danh mục</label>
                                    <input type="text" class="form-control" placeholder="Nhập tên danh mục"
                                        name="name" id="categoryName">
                                </div>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>

                <div class="text-end mb-3">
                    <a href="{{ route('admin.postcategories.listPostCategory') }}" type="button"
                        class="btn btn-danger w-sm">Quay lại</a>

                    <button type="submit" class="btn btn-success w-sm">Thêm mới</button>
                </div>
            </div>
        </div>
    </form>
@endsection
