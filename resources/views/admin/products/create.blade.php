@extends('admin.layouts.master')

@section('title')
    Tạo mới sản phẩm
@endsection

@section('style-libs')
@endsection

@section('content')
    <form id="createproduct-form" action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('POST')
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
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
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
                                        <input type="text" class="form-control" name="sku" id="sku"
                                            placeholder="">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="price">Giá bán thường</label>
                                        <div class="input-group has-validation mb-3">
                                            <input type="text" class="form-control" id="price numberInput" name="price"
                                                placeholder="Enter price">
                                            <span class="input-group-text">VNĐ</span>
                                            @error('price')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="price">Giá khuyến mại</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="price_sale"
                                                id="price numberInput" placeholder="Enter price">
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
                                        <input type="text" class="form-control" id="qty" name="qty"
                                            placeholder="">
                                        @error('qty')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="product_status">Trạng thái</label>
                                        <select name="status" id="product_status" class="form-select">
                                            <option value="0">Ẩn</option>
                                            <option value="1" selected>Kích hoạt</option>
                                        </select>
                                        @error('status')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
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

                {{-- Biến thể sản phẩm --}}
                <div class="card mt-4">
                    <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer"
                        data-bs-target="#variantsSection" aria-expanded="true" aria-controls="variantsSection">
                        <h5 class="card-title mb-0">Biến thể sản phẩm</h5>
                    </div>

                    <div class="collapse show" id="variantsSection">
                        <div class="card-body">
                            <div class="form-group row">
                                <button type="button" class="col-md-3 btn btn-primary mb-3 mx-3" id="addVariant">Thêm
                                    biến thể</button>
                                <div class="col-md-7">
                                    <select class="js-example-basic-multiple select2-hidden-accessible" name="states[]"
                                        multiple="" id="attributeSelect">
                                        <option value="type">Loại</option>
                                        <option value="weight">Trọng lượng</option>
                                    </select>
                                </div>
                            </div>

                            <div id="variants"></div> <!-- Khởi tạo là rỗng, sẽ thêm vào khi người dùng nhấn nút -->
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
                            @error('content')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
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
                            @error('description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
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
                        @error('thumbnail')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
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
                    <div class="collapse show" id="categories" data-select2-id="select2-data-2">
                        <div class="card-body">
                            <p class="text-muted mb-2"> 
                            <select name="categories" class="js-example-basic-multiple" style="width: 100%">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">
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
                                    <option value="{{ $brand->id }}">
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer" data-bs-target="#product_type"
                        aria-expanded="true" aria-controls="product_type">
                        <h5 class="card-title mb-0">Nhãn</h5>
                    </div>
                    <div class="collapse show" id="product_type">
                        <div class="card-body">
                            <p class="text-muted mb-2"> 
                                @foreach ($brands as $brand)
                                    <div class="form-check mb-3" style="font-size: large">
                                        <input class="form-check-input" type="checkbox" name="brands[]" id="brand{{ $brand->id }}" value="{{ $brand->id }}">
                                        <label class="form-check-label" for="brand{{ $brand->id }}">
                                            {{ $brand->name }}
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

    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({});
        });
    </script>

    <script>
        let variantIndex = 0;
        let variantCombinations = []; // Danh sách chứa các tổ hợp type - weight đã chọn cho từng biến thể

        document.getElementById('addVariant').addEventListener('click', function() {
            const selectedOptions = $('#attributeSelect').val(); // Lấy giá trị các thuộc tính đã chọn
            if (selectedOptions.length > 0) {
                variantIndex++; // Tăng chỉ số biến thể mỗi khi nhấn nút "Thêm biến thể"

                let variantHTML = `<div class="variant-group card mb-3" id="variant-${variantIndex}">
                <div class="card-body">
                    <div class="row">`;

                // Kiểm tra loại sản phẩm đã tồn tại
                let existingProductTypes = document.querySelectorAll(
                    '[name^="variants"][name$="[product_type_id]"]');
                let existingProductTypeValues = Array.from(existingProductTypes).map(select => select.value);

                // Nếu chọn 'type', thêm trường Loại sản phẩm
                if (selectedOptions.includes('type')) {
                    variantHTML += `
                <div class="form-group col-md-4">
                    <label for="type">Loại sản phẩm:</label>
                    <select id="typeSelect-${variantIndex}" name="variants[${variantIndex}][product_type_id]" class="form-control">
                        <option value="">Chọn loại sản phẩm</option>`;

                    @foreach ($types as $type)
                        variantHTML += `
                <option value="{{ $type->id }}">
                    {{ $type->name }}
                </option>`;
                    @endforeach

                    variantHTML += `</select>
                </div>`;
                }

                // Nếu chọn 'weight', thêm trường Trọng lượng
                if (selectedOptions.includes('weight')) {
                    variantHTML += `
                <div class="form-group col-md-4">
                    <label for="weight">Trọng lượng:</label>
                    <select id="weightSelect-${variantIndex}" name="variants[${variantIndex}][product_weight_id]" class="form-control">
                        <option value="">Chọn trọng lượng</option>`;

                    @foreach ($weights as $weight)
                        variantHTML += `
                <option value="{{ $weight->id }}">
                    {{ $weight->name }}
                </option>`;
                    @endforeach

                    variantHTML += `</select>
                </div>`;
                }

                // Các trường khác: Số lượng, Giá biến thể, Hình ảnh biến thể
                variantHTML += `
                        <div class="form-group col-md-4">
                            <label for="qty">Số lượng:</label>
                            <input type="number" name="variants[${variantIndex}][qty]" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="form-group col-md-4">
                            <label class="form-label" for="price_variant">Giá biến thể:</label>
                            <div class="input-group">
                                <input type="text" name="variants[${variantIndex}][price_variant]" class="form-control" required>
                                <span class="input-group-text">VNĐ</span>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="image">Hình ảnh biến thể:</label>
                            <input type="file" name="variants[${variantIndex}][image]" class="form-control">
                        </div>

                        <div class="form-group col-md-4 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove-variant" data-variant-id="variant-${variantIndex}">Xóa biến thể</button>
                        </div>
                    </div>
                </div>
            </div>`;

                // Chèn nội dung mới vào div #variants
                document.getElementById('variants').insertAdjacentHTML('beforeend', variantHTML);

                // Gán sự kiện xóa cho nút "Xóa biến thể"
                document.querySelectorAll('.remove-variant').forEach(button => {
                    button.addEventListener('click', function() {
                        let variantId = this.getAttribute('data-variant-id');
                        document.getElementById(variantId).remove();
                        // Xóa tổ hợp khỏi danh sách
                        let combinationToRemove = `${selectedType}-${selectedWeight}`;
                        variantCombinations = variantCombinations.filter(combination =>
                            combination !== combinationToRemove);
                    });
                });

                let selectedType = '';
                let selectedWeight = '';

                // Khi các select box (type và weight) thay đổi, kiểm tra và lưu tổ hợp
                document.getElementById(`typeSelect-${variantIndex}`).addEventListener('change', function() {
                    selectedType = this.value;
                    checkCombination();
                });

                document.getElementById(`weightSelect-${variantIndex}`).addEventListener('change', function() {
                    selectedWeight = this.value;
                    checkCombination();
                });

                // Kiểm tra tổ hợp type - weight có hợp lệ không
                function checkCombination() {
                    if (selectedType && selectedWeight) {
                        let combination = `${selectedType}-${selectedWeight}`;
                        if (variantCombinations.includes(combination)) {
                            alert('Giá trị đã tồn tại! Vui lòng chọn loại hoặc trọng lượng khác.');
                            document.getElementById(`variant-${variantIndex}`).remove();
                            return; // Dừng không thêm biến thể
                        }
                        // Nếu tổ hợp chưa tồn tại, thêm vào danh sách
                        variantCombinations.push(combination);
                    }
                }
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".js-example-basic-single").select2(),
                $(".js-example-basic-multiple").select2();
        });
    </script>
@endpush
