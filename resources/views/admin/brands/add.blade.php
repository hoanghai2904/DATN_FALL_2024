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

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer" data-bs-target="#name"
                    aria-expanded="true" aria-controls="name">
                    <h5 class="card-title mb-0">Tên thương hiệu</h5>
                </div>
                <div class="collapse show" id="name">
                    <div class="card-body">
                        <div class="mb-0">
                            <input type="text" class="form-control" id="product-title-input" value=""
                            name="name" placeholder="Nhập tên thương hiệu">
                            <div class="invalid-feedback">Please Enter a product title.</div>
                        </div>
                    </div>
                </div>
                <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer" data-bs-target="#name"
                    aria-expanded="true" aria-controls="name">
                    <h5 class="card-title mb-0">Đại diện thương hiệu</h5>
                </div>
                <div class="collapse show" id="name">
                    <div class="card-body">
                        <div class="mb-0">
                            <input type="text" class="form-control" id="product-title-input" value=""
                            name="slug" placeholder="Nhập đại diện thương hiệu">
                            <div class="invalid-feedback">Please Enter a product title.</div>
                        </div>
                    </div>
                </div>
                <div class="text-end mb-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-success w-sm">Thêm mới</button>
                </div>
            </div>
            
            {{-- <div class="card">
                <div class="card-body">
                    <div class="row"> --}}
                        {{-- <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="meta-title-input">Hình ảnh:</label>
                                <input type="file" class="form-control" name="logo">
                            </div>
                        </div> --}}
                        
                        {{-- <div class="col-lg-6">
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
                    </div> --}}
                    {{-- <div class="col-md-6">
                        <div class="default-form-box mb-3 d-flex align-items-center">
                            <div>
                                <label for="cover">Ảnh đại diện</label>
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
                    </div> --}}
                    {{-- <div>
                        <label class="form-label" for="meta-description-input">Meta Description</label>
                        <textarea class="form-control" id="meta-description-input" placeholder="Enter meta description" rows="3"></textarea>
                    </div> --}}
                {{-- </div>
                <div class="text-end mb-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-success w-sm">Thêm mới</button>
                </div>
            </div> --}}
           
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

            <div class="card">
                <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer"
                    data-bs-target="#categories" aria-expanded="true" aria-controls="categories">
                    <h5 class="card-title mb-0">Danh mục</h5>
                </div>
                <div class="collapse show" id="categories">
                    <div class="card-body">
                        <p class="text-muted mb-2"> <a href="#"
                                class="float-end text-decoration-underline">Thêm mới</a>Chọn danh mục </p>
                        <select class="form-select" name="category_id">
                            <option value="0">Appliances</option>
                            <option value="1">Automotive Accessories</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer" data-bs-target="#brands"
                    aria-expanded="true" aria-controls="brands">
                    <h5 class="card-title mb-0">Thương hiệu</h5>
                </div>
                <div class="collapse show" id="brands">
                    <div class="card-body">
                        <p class="text-muted mb-2"> <a href="#"
                                class="float-end text-decoration-underline">Thêm mới</a>Chọn danh mục </p>
                        <select class="form-select" name="brand_id">
                            <option value="0">Appliances</option>
                            <option value="1">Automotive Accessories</option>
                        </select>
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
