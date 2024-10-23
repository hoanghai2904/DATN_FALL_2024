@extends('admin.layouts.master')

@section('title')
    Cập nhật sản phẩm
@endsection

@section('style-libs')
    <link rel="stylesheet" href="{{ asset('assets/css/uploadFile.css') }}">
@endsection

@section('content')
    <form id="createproduct-form" action="{{ route('admin.products.update', $product->id) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
                                <input type="text" class="form-control" id="product-title-input"
                                    value="{{ $product->name }}" placeholder="Tên sản phẩm" name="name">
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
                                        <input type="text" class="form-control" value="{{ $product->sku }}"
                                            name="sku" id="sku" placeholder="ABC-XX">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="price">Giá bán thường</label>
                                        <div class="input-group has-validation mb-3">
                                            <input type="text" class="form-control" id="price numberInput" name="price"
                                                placeholder="Nhập giá"
                                                value="{{ number_format((float) $product->price, 0, ',', '.') }}">
                                            <span class="input-group-text">VNĐ</span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="price">Giá khuyến mại</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="price_sale"
                                                id="price numberInput" placeholder="Nhập giá khuyến mại"
                                                value="{{ number_format($product->price_sale) }}">
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
                                        <input type="number" class="form-control" value="{{ $product->qty }}"
                                            id="qty" name="qty" placeholder="">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="product_status">Trạng thái</label>
                                        <select name="status" id="product_status" class="form-select">
                                            <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Ẩn</option>
                                            <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Kích hoạt
                                            </option>
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

                @if ($product->variants->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h5>Danh sách phiên bản : {{ $product->name }}</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Hình ảnh</th>
                                        <th>Loại</th>
                                        <th>Số lượng</th>
                                        <th>Giá tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product->variants as $variant)
                                        <tr>
                                            <td>
                                                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="Thumbnail"
                                                    style="width: 50px; height: 50px;">
                                            </td>
                                            <td>{{ $variant->variantValue->value }}</td>
                                            <td>
                                                <input class="form-control" type="number" name="quantities[]"
                                                    value="{{ $variant->qty }}" min="0">
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" name="prices[]"
                                                    value="{{ number_format($variant->price) }}" min="0">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif


                <div class="card">
                    <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer" data-bs-target="#content"
                        aria-expanded="true" aria-controls="content">
                        <h5 class="card-title mb-0">Mô tả sản phẩm</h5>
                    </div>
                    <div class="collapse show" id="content">
                        <div class="card-body">
                            <div class="mb-3">
                                <textarea id="ckeditor-classic" name="content">{{ $product->content }}</textarea>
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
                                <textarea name="description" class="form-control" id="" rows="10">{{ $product->description }}</textarea>
                            </div>
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
                            <div id="addGalleryButton" class="text-center mt-3 d-none"
                                style="cursor: pointer; border: 2px dashed #007bff; padding: 20px; border-radius: 5px;">
                                <span class="text-primary">Nhấn vào đây để thêm album hình ảnh</span>
                            </div>
                            <input type="file" id="galleryInput" name="galleries[]" multiple accept="image/*"
                                class="d-none">
                            <div class="row" id="galleryPreviewContainer">
                                @foreach ($product->galleries as $gallery)
                                    <div class="col-6 col-md-4 col-lg-3 image-preview" data-id="{{ $gallery->id }}">
                                        <img src="{{ asset('storage/' . $gallery->image) }}" alt="Album Image"
                                            class="img-thumbnail">
                                        <button class="remove-image" onclick="removeGallery(this)">X</button>
                                    </div>
                                @endforeach
                            </div>
                            <button id="addGallery" class="btn btn-danger mt-3">Thêm ảnh</button>
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
                        data-bs-target="#thumbnails" aria-expanded="true" aria-controls="thumbnails">
                        <h5 class="card-title mb-0">Ảnh sản phẩm</h5>
                    </div>
                    <div class="collapse show" id="thumbnails">
                        <div class="card-body">
                            <div id="addImageButton" class="text-center mt-3 d-none"
                                style="cursor: pointer; border: 2px dashed #007bff; padding: 20px; border-radius: 5px;">
                                <span class="text-primary">Nhấn vào đây để thêm hình ảnh</span>
                            </div>
                            <input type="file" id="imageInput" name="thumbnail" accept="image/*" class="d-none">
                            <div class="row" id="imagePreviewContainer">
                                @if ($product->thumbnail)
                                    <!-- Kiểm tra nếu sản phẩm có ảnh -->
                                    <div class="col-6 col-md-4 col-lg-12 image-preview">
                                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="Ảnh sản phẩm"
                                            class="img-thumbnail">
                                        <button class="remove-image" onclick="removeImage(this)">X</button>
                                    </div>
                                @endif
                            </div>
                            {{-- <button id="addGallery" class="btn btn-danger mt-3 d-none">Thêm ảnh</button> --}}
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer"
                        data-bs-target="#categories" aria-expanded="true" aria-controls="categories">
                        <h5 class="card-title mb-0">Danh mục</h5>
                    </div>
                    <div class="collapse show" id="categories" data-select2-id="select2-data-2">
                        <div class="card-body">
                            <p class="text-muted mb-2">
                                <select name="categories" class="js-example-basic-multiple" style="width: 100%">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
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
                            <p class="text-muted mb-2">
                                <select name="brands" class="js-example-basic-multiple" style="width: 100%">
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ $brand->id == $product->brand_id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer"
                        data-bs-target="#product_type" aria-expanded="true" aria-controls="product_type">
                        <h5 class="card-title mb-0">Bộ sưu tập</h5>
                    </div>
                    <div class="collapse show" id="product_type">
                        <div class="card-body">
                            <p class="text-muted mb-2">
                                @foreach ($tags as $tag)
                                    <div class="form-check mb-3 justify-content-center">
                                        <input class="form-check-input" type="checkbox" name="tags[]"
                                            id="tag{{ $tag->id }}" value="{{ $tag->id }}"
                                            {{ $product->tags->contains($tag->id) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tag{{ $tag->id }}">
                                            {{ $tag->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </p>
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
    {{-- upload File  --}}
    <script src="{{ asset('assets/js/uploadFile.js') }}"></script>
    {{-- end upload File  --}}

    {{-- <script>
        // Khi người dùng nhập tên sản phẩm, tự động tạo SKU
        $('#product-title-input').on('input', function() {
            let productName = $(this).val().trim();

            if (productName.length > 0) {
                // Lấy 3 ký tự đầu của tên sản phẩm
                let skuPrefix = productName.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
                skuPrefix = skuPrefix.substring(0, 3).toUpperCase();
                // Tạo một chuỗi số ngẫu nhiên
                let randomNum = Math.floor(1000 + Math.random() * 9000);
                // Ghép lại để tạo SKU
                let sku = 'SKU-' + skuPrefix + '-' + randomNum;
                $('#sku').val(sku); // Gán giá trị cho ô nhập SKU
            } else {
                $('#sku').val(''); // Xóa SKU nếu không có tên sản phẩm
            }
        });
    </script> --}}

    {{-- <script>
        function removeGallery(button) {
            if (confirm('Bạn có chắc chắn muốn xóa ảnh này?')) {
                // Lấy ID của gallery từ phần tử liên quan
                const galleryElement = button.closest('.image-preview');
                const galleryId = galleryElement.getAttribute('data-id');
                console.log('ID:', galleryId);

                // Gửi yêu cầu xóa qua AJAX
                $.ajax({
                    url: `/galleries/${galleryId}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}', // Gửi token bảo mật CSRF
                    },
                    success: function(response) {
                        console.log('Server response:', response); // Log phản hồi từ server
                        if (response.success) {
                            // Xóa phần tử ảnh khỏi giao diện
                            galleryElement.remove();
                        } else {
                            alert('Xóa ảnh không thành công.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error details:', xhr.responseText); // Log chi tiết lỗi
                        alert('Đã xảy ra lỗi khi xóa ảnh.');
                    }
                });
            }
        }
    </script> --}}

    <script>
        $(document).ready(function() {
            $(".js-example-basic-single").select2(),
                $(".js-example-basic-multiple").select2();
        });
    </script>
@endpush
