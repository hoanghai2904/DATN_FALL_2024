{{-- extends: Chỉ định layout được sử dụng --}}
@extends('admin.layouts.master')

@section('title')
    Chỉnh sửa thương hiệu
@endsection

{{-- section: định nghĩa nội dung của section --}}
@section('content')
<form action="{{ route('admin.brands.update', $brands->id) }}" method="POST" enctype="multipart/form-data" id="createproduct-form" autocomplete="off" class="needs-validation" novalidate>
    @method('put')
    @csrf
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer" data-bs-target="#name"
                    aria-expanded="true" aria-controls="name">
                    <h5 class="card-title mb-0">Tên thương hiệu</h5>
                </div>
                <div class="collapse show" id="name">
                    <div class="card-body">
                        <div class="mb-0">
                            <input type="text" class="form-control" id="product-title-input" 
                            name="name" value="{{$brands->name}}" placeholder="Nhập tên thương hiệu">
                            <div class="invalid-feedback">Please Enter a product title.</div>
                        </div>
                    </div>
                </div>
                <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer" data-bs-target="#name"
                    aria-expanded="true" aria-controls="name">
                    <h5 class="card-title mb-0">Đại diện thương hiệu</h5>
                </div>
                <div class="collapse show" id="slug">
                    <div class="card-body">
                        <div class="mb-0">
                            <input type="text" class="form-control" id="product-title-input"
                            name="slug" value="{{$brands->slug}}" placeholder="Nhập đại diện thương hiệu">
                            <div class="invalid-feedback">Please Enter a product title.</div>
                        </div>
                    </div>
                </div>
                <div class="text-end mb-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-success w-sm">Cập nhật</button>
                </div>        
            </div>
        </div>
        <div class="col-lg-4">

            <div class="card">
                <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer"
                    data-bs-target="#thumbnails" aria-expanded="true" aria-controls="thumbnails">
                    <h5 class="card-title mb-0">Ảnh sản phẩm</h5>
                </div>
                <div class="collapse show" id="thumbnails">
                    <div class="card-body">
                        <div class="default-form-box mb-3 d-flex align-items-center">
                            <div>
                                <input type="file" id="logo" name="logo" class="form-control-file"
                                    onchange="previewAvatar(event)" />
                                @error('cover')
                                    <small
                                        style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                                @enderror
                            </div>
                            <img id="avatarPreview" src="" alt="Avatar Preview"
                                class="ml-3 rounded d-none float-left" width="70" height="70" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
</form>
<script>
    function previewAvatar(event) {
        const avatarPreview = document.getElementById('avatarPreview');
        const file = event.target.files[0];
        if (file) {
            avatarPreview.src = URL.createObjectURL(file);
            avatarPreview.classList.remove('d-none');
        } else {
            avatarPreview.src = '';
            avatarPreview.classList.add('d-none');
        }
    }
</script>
@endsection