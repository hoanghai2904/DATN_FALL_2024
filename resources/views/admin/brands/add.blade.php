{{-- extends: Chỉ định layout được sử dụng --}}
@extends('admin.layouts.master')

@section('title')
    Tạo mới thương hiệu
@endsection

{{-- section: định nghĩa nội dung của section --}}
@section('content')
<form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data" id="createproduct-form" autocomplete="off" class="needs-validation" novalidate>
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="meta-title-input">Hình ảnh:</label>
                                <input type="file" class="form-control" name="logo">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="meta-keywords-input">Tên thương hiệu</label>
                                <input type="text" class="form-control" name="name" placeholder="Nhập tên thương hiệu" >
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="meta-keywords-input">Đại diện thương hiệu</label>
                                <input type="text" class="form-control" name="slug" placeholder="Nhập đại diện thương hiệu"  >
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="form-label" for="meta-description-input">Meta Description</label>
                        <textarea class="form-control" id="meta-description-input" placeholder="Enter meta description" rows="3"></textarea>
                    </div>
                </div>
                <div class="text-end mb-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-success w-sm">Thêm mới</button>
                </div>
            </div>
           
        </div>
    </div>
</form>
@endsection
