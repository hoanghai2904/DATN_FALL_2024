@extends('admin.layouts.master')

@section('title')
    Tạo mới sản phẩm
@endsection

@section('style-libs')
  
@endsection

@section('content')
    <form id="createproduct-form" action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer" data-bs-target="#name"
                        aria-expanded="true" aria-controls="name">
                        <h5 class="card-title mb-0">Tên sản phẩm</h5>
                    </div>
                    <div class="collapse show" id="name">
                        <div class="card-body">
                            <div class="mb-0">
                                <input type="text" class="form-control" id="product-title-input" value=""
                                    placeholder="Tên sản phẩm" name="name">
                                <div class="invalid-feedback">Please Enter a product title.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->


                <div class="card">
                    <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer" data-bs-target="#general-info"
                    aria-expanded="true" aria-controls="general-info">
                        <h5 class="card-title mb-0">Thông tin chung</h5>
                    </div>
                    <!-- end card header -->
                    <div class="collapse show" id="general-info">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="sku">Mã sản phẩm</label>
                                        <input type="text" class="form-control" name="sku" id="sku" placeholder="">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="price">Giá bán thường</label>
                                        <div class="input-group has-validation mb-3">
                                            <input type="text" class="form-control" id="price" name="price" placeholder="Enter price">
                                            <span class="input-group-text">VNĐ</span>
                                            <div class="invalid-feedback">Please Enter a product price.</div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="price">Giá khuyến mại</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="price_sale" id="price" placeholder="Enter price">
                                            <span class="input-group-text">VNĐ</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row">

                                <div class="col-lg-6 col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="qty">Số lượng</label>
                                        <input type="text" class="form-control" id="qty" name="qty" placeholder="">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="product_status">Trạng thái</label>
                                        <select name="status" id="product_status"  class="form-select">
                                            <option value="0">Ẩn</option>
                                            <option value="1" selected>Kích hoạt</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-header align-items-center justify-content-between d-flex" >
                        <h5 class="card-title mb-0" data-bs-toggle="collapse" style="cursor:pointer" data-bs-target="#variants"
                        aria-expanded="true" aria-controls="variants">Thuộc tính</h5>
                        <a class="btn btn-info">Thêm thuộc tính mới </a>
                    </div> 
                    <div class="collapse show" id="variants">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-lg-10 d-flex ">
                                    
                                    <div class="w-75">
                                        <select name="status" id="product_status" class="form-select">
                                            <option value="" selected disabled>Thêm hiện có</option>
                                            <option value="0">Kích thước</option>
                                            <option value="1" >Trọng lượng</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                            {{-- <div>
                                <label class="form-label" for="meta-description-input">Meta Description</label>
                                <textarea class="form-control" id="meta-description-input" placeholder="Enter meta description" rows="3"></textarea>
                            </div> --}}
                            
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer" data-bs-target="#content"
                        aria-expanded="true" aria-controls="content">
                        <h5 class="card-title mb-0">Mô tả sản phẩm</h5>
                    </div>
                    <div class="collapse show" id="content">
                        <div class="card-body">
                            <div class="mb-3">
                                <textarea id="ckeditor-classic" name="content"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer"
                        data-bs-target="#description" aria-expanded="true" aria-controls="description">
                        <h5 class="card-title mb-0">Mô tả ngắn của sản phẩm</h5>
                    </div>
                    <div class="collapse show" id="description">
                        <div class="card-body">
                            <div class="mb-3">
                                <textarea name="description" class="form-control" id="" rows="10"></textarea>
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
                    <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer"
                        data-bs-target="#thumbnails" aria-expanded="true" aria-controls="thumbnails">
                        <h5 class="card-title mb-0">Ảnh sản phẩm</h5>
                    </div>
                    <div class="collapse show" id="thumbnails">
                        <div class="card-body">
                            <input type="file" name="thumbnail" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer"
                        data-bs-target="#galleries" aria-expanded="true" aria-controls="galleries">
                        <h5 class="card-title mb-0">Album hình ảnh sản phẩm</h5>
                    </div>
                    <div class="collapse show" id="galleries">
                        <div class="card-body">
                            <input type="file" name="galleries[]" multiple class="form-control">
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
            <!-- end col -->
        </div>
        <!-- end row -->

    </form>
@endsection

@push('script')
    <!-- ckeditor -->
    <script src="{{ asset('theme/admin/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

    <script src="{{ asset('theme/admin/assets/js/pages/ecommerce-product-create.init.js') }}"></script>

@endpush
