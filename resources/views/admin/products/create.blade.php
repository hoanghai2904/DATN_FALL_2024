@extends('admin.layouts.master')

@section('title')
    Tạo mới sản phẩm
@endsection

@section('style-libs')
        {{-- <!-- dropzone css -->
        <link rel="stylesheet" href="{{ asset('theme/admin/assets/libs/dropzone/dropzone.css') }}" type="text/css" />

        <!-- Filepond css -->
        <link rel="stylesheet" href="{{ asset('theme/admin/assets/libs/filepond/filepond.min.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('theme/admin/assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}"> --}}
@endsection

@section('content')
<form id="createproduct-form" autocomplete="off" class="needs-validation" novalidate enctype="multipart/form-data" >
    <div class="row">
        <div class="col-lg-8">

            <div class="card">
                <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer" data-bs-target="#name" aria-expanded="true" aria-controls="name">
                    <h5 class="card-title mb-0" >Tên sản phẩm</h5>
                </div>
                <div class="collapse show" id="name">
                    <div class="card-body">
                        <div class="mb-0">
                            <input type="text" class="form-control" id="product-title-input" value="" placeholder="Tên sản phẩm" required>
                            <div class="invalid-feedback">Please Enter a product title.</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->

            
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#addproduct-general-info" role="tab">
                                Thông tin chung
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#addproduct-metadata" role="tab">
                                Meta Data
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- end card header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="addproduct-general-info" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="manufacturer-name-input">Manufacturer Name</label>
                                        <input type="text" class="form-control" id="manufacturer-name-input" placeholder="Enter manufacturer name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="manufacturer-brand-input">Manufacturer Brand</label>
                                        <input type="text" class="form-control" id="manufacturer-brand-input" placeholder="Enter manufacturer brand">
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row">
                                <div class="col-lg-3 col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="stocks-input">Stocks</label>
                                        <input type="text" class="form-control" id="stocks-input" placeholder="Stocks" required>
                                        <div class="invalid-feedback">Please Enter a product stocks.</div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="product-price-input">Price</label>
                                        <div class="input-group has-validation mb-3">
                                            <span class="input-group-text" id="product-price-addon">$</span>
                                            <input type="text" class="form-control" id="product-price-input" placeholder="Enter price" aria-label="Price" aria-describedby="product-price-addon" required>
                                            <div class="invalid-feedback">Please Enter a product price.</div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="product-discount-input">Discount</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="product-discount-addon">%</span>
                                            <input type="text" class="form-control" id="product-discount-input" placeholder="Enter discount" aria-label="discount" aria-describedby="product-discount-addon">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="orders-input">Orders</label>
                                        <input type="text" class="form-control" id="orders-input" placeholder="Orders" required>
                                        <div class="invalid-feedback">Please Enter a product orders.</div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end tab-pane -->

                        <div class="tab-pane" id="addproduct-metadata" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="meta-title-input">Meta title</label>
                                        <input type="text" class="form-control" placeholder="Enter meta title" id="meta-title-input">
                                    </div>
                                </div>
                                <!-- end col -->

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="meta-keywords-input">Meta Keywords</label>
                                        <input type="text" class="form-control" placeholder="Enter meta keywords" id="meta-keywords-input">
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->

                            <div>
                                <label class="form-label" for="meta-description-input">Meta Description</label>
                                <textarea class="form-control" id="meta-description-input" placeholder="Enter meta description" rows="3"></textarea>
                            </div>
                        </div>
                        <!-- end tab pane -->
                    </div>
                    <!-- end tab content -->
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <div class="card">
                <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer" data-bs-target="#content" aria-expanded="true" aria-controls="content">
                    <h5 class="card-title mb-0" >Mô tả sản phẩm</h5>
                </div>
                <div class="collapse show" id="content">
                    <div class="card-body">
                        <div class="mb-3">
                            <div id="ckeditor-classic"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->

            <div class="card">
                <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer" data-bs-target="#description" aria-expanded="true" aria-controls="description">
                    <h5 class="card-title mb-0" >Mô tả ngắn của sản phẩm</h5>
                </div>
                <div class="collapse show" id="description">
                    <div class="card-body">
                        <div class="mb-3">
                            <textarea name="" class="form-control" id="" rows="10"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->
            <div class="text-end mb-3">
                <button type="submit" class="btn btn-success w-sm">Submit</button>
            </div>
        </div>
        <!-- end col -->

        <div class="col-lg-4">
            
            <div class="card">
                <div class="card-header"  data-bs-toggle="collapse" style="cursor:pointer" data-bs-target="#thumbnails" aria-expanded="true" aria-controls="thumbnails">
                    <h5 class="card-title mb-0" >Ảnh sản phẩm</h5>
                </div>
                <div class="collapse show" id="thumbnails">
                    <div class="card-body">
                        <input type="file" class="form-control">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"  data-bs-toggle="collapse" style="cursor:pointer" data-bs-target="#galleries" aria-expanded="true" aria-controls="galleries">
                    <h5 class="card-title mb-0" >Album hình ảnh sản phẩm</h5>
                </div>
                <div class="collapse show" id="galleries">
                    <div class="card-body">
                        <input type="file" class="form-control">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"  data-bs-toggle="collapse" style="cursor:pointer" data-bs-target="#categories" aria-expanded="true" aria-controls="categories">
                    <h5 class="card-title mb-0" >Danh mục</h5>
                </div>
                <div class="collapse show" id="categories">
                    <div class="card-body">
                        <p class="text-muted mb-2"> <a href="#" class="float-end text-decoration-underline">Thêm mới</a>Chọn danh mục </p>
                        <select class="form-select">
                            <option value="Appliances">Appliances</option>
                            <option value="Automotive Accessories">Automotive Accessories</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"  data-bs-toggle="collapse" style="cursor:pointer" data-bs-target="#brands" aria-expanded="true" aria-controls="brands">
                    <h5 class="card-title mb-0" >Thương hiệu</h5>
                </div>
                <div class="collapse show" id="brands">
                    <div class="card-body">
                        <p class="text-muted mb-2"> <a href="#" class="float-end text-decoration-underline">Thêm mới</a>Chọn danh mục </p>
                        <select class="form-select">
                            <option value="Appliances">Appliances</option>
                            <option value="Automotive Accessories">Automotive Accessories</option>
                        </select>
                    </div>
                </div>
            </div>

            


        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

</form>
@endsection

@push('script')
        <!-- ckeditor -->
        <script src="{{ asset('theme/admin/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

        <!-- dropzone js -->
        <script src="{{ asset('theme/admin/assets/libs/dropzone/dropzone-min.js') }}"></script>
    
        <script src="{{ asset('theme/admin/assets/js/pages/ecommerce-product-create.init.js') }}"></script>

            <!-- filepond js -->
        <script src="{{ asset('theme/admin/assets/libs/filepond/filepond.min.js') }}"></script>
        <script src="{{ asset('theme/admin/assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
        <script src="{{ asset('theme/admin/assets/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}"></script>
        <script src="{{ asset('theme/admin/assets/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}"></script>
        <script src="{{ asset('theme/admin/assets/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>
        
        <script src="{{ asset('theme/admin/assets/js/pages/form-file-upload.init.js') }}"></script>
@endpush