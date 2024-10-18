{{-- extends: Chỉ định layout được sử dụng --}}
@extends('admin.layouts.master')

@section('title')
    Tạo mới đánh giá
@endsection

{{-- section: định nghĩa nội dung của section --}}
@section('content')
<form action="{{ route('admin.review.store') }}" method="POST" enctype="multipart/form-data" id="createproduct-form" autocomplete="off" class="needs-validation" novalidate>
    @csrf
    {{-- <div class="row">

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
    </div> --}}
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer" data-bs-target="#name"
                    aria-expanded="true" aria-controls="name">
                    <h5 class="card-title mb-0">Đánh giá</h5>
                </div>
                <div class="collapse show" id="rating">
                    <div class="card-body">
                        <div class="mb-0">
                            <input type="text" class="form-control" id="product-title-input" value=""
                                placeholder="Đánh giá" name="rating">
                            @error('rating')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->

            <div class="card">
                <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer"
                    data-bs-target="#description" aria-expanded="true" aria-controls="description">
                    <h5 class="card-title mb-0">Nội dung đánh giá</h5>
                </div>
                <div class="collapse show" id="comment">
                    <div class="card-body">
                        <div class="mb-3">
                            <textarea name="comment" class="form-control" id="" rows="10"></textarea>
                        </div>
                        @error('comment')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- end card -->
            <div class="text-end mb-3">
                <button type="submit" class="btn btn-success w-sm">Lưu</button>
            </div>
        </div>
        <!-- end col -->

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer"
                    data-bs-target="#user" aria-expanded="true" aria-controls="user">
                    <h5 class="card-title mb-0">ID người dùng</h5>
                </div>
                <div class="collapse show" id="user" data-select2-id="select2-data-2">
                    <div class="card-body">
                        <p class="text-muted mb-2">
                            <select name="user" class="js-example-basic-multiple" style="width: 100%">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->full_name }}
                                    </option>
                                @endforeach
                            </select>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer" data-bs-target="#order"
                    aria-expanded="true" aria-controls="order">
                    <h5 class="card-title mb-0">ID Đơn hàng</h5>
                </div>
                <div class="collapse show" id="orders">
                    <div class="card-body">
                        <p class="text-muted mb-2">
                            <select name="order_statuses" class="js-example-basic-multiple" style="width: 100%">
                                @foreach ($order_statuses as $order_statuses)
                                    <option value="{{ $order_statuses->id }}">
                                        {{ $order_statuses->status}}
                                    </option>
                                @endforeach
                            </select>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer" data-bs-target="#product"
                    aria-expanded="true" aria-controls="product">
                    <h5 class="card-title mb-0">ID Sản phẩm</h5>
                </div>
                <div class="collapse show" id="products">
                    <div class="card-body">
                        <p class="text-muted mb-2">
                            <select name="products" class="js-example-basic-multiple" style="width: 100%">
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                    </div>
                </div>
            </div>

            

        </div>
        <!-- end col -->
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
