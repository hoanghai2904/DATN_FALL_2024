@extends('admin.layouts.master')

@section('title')
    Tạo mới sản phẩm
@endsection

@section('style-libs')
    <link rel="stylesheet" href="{{ asset('assets/css/uploadFile.css') }}">
    <style>

    </style>
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
                                        <input type="text" class="form-control" value="" name="sku"
                                            id="sku" placeholder="">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="price">Giá bán thường</label>
                                        <div class="input-group has-validation mb-3">
                                            <input type="text" class="form-control" id="price numberInput" name="price"
                                                placeholder="Enter price">
                                            <span class="input-group-text">VNĐ</span>
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
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="product_status">Trạng thái</label>
                                        <select name="status" id="product_status" class="form-select">
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

                {{-- Biến thể sản phẩm --}}
                <div class="card mt-4">
                    <div class="card-header d-flex align-items-center justify-content-between" style="cursor:pointer">
                        <h5 class="card-title mb-0">Sản phẩm có nhiều phiên bản</h5>
                        <!-- Thêm id để dễ dàng xử lý -->
                        <a class="btn btn-info addVariant" id="toggleVariant">Thêm thuộc tính mới</a>
                    </div>

                    <div class="collapse show">
                        <div class="card-body">
                            <p class="card-text">Sản phẩm này có nhiều biến thể. Ví dụ như khác nhau về màu sắc, kích thước
                            </p>

                            <div class="variant-wrapper d-none" id="variantWrapper">


                                <div class="variant-body mt-3">
                                    <!-- Nội dung khác có thể thêm vào đây -->
                                </div>

                                <div class="mt-3">
                                    <button type="button" id="addNewVariant" class="btn btn-primary">Thêm phiên bản
                                        mới</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4 d-none" id="variantContainer">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Danh sách phiên bản</h5>
                    </div>

                    <div class="collapse show">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped variantTable">
                                    <thead>
                                    </thead>
                                    <tbody id="variantBody">
                                        <!-- Danh sách phiên bản sẽ được thêm vào đây -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div id="editCard" class="card d-none">
                    <div class="card-body ">
                        <h5 class="card-title">Chỉnh Sửa Phiên Bản</h5>
                        <div class="form-group">
                            <label for="editImage">Hình Ảnh</label>
                            <input type="file" id="editImage" accept="image/*" onchange="previewImage(event)">
                            <img id="previewEditImage" src="" alt="Thumbnail"
                                style="width: 50px; height: 50px; display: none;">
                        </div>
                        <div class="form-group">
                            <label for="editPrice">Giá:</label>
                            <input type="text" id="editPrice" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="editQuantity">Số Lượng:</label>
                            <input type="number" id="editQuantity" min="0" class="form-control">
                        </div>
                        <a id="saveChanges" class="btn btn-primary">Lưu Thay Đổi</a>
                        <a id="cancelEdit" class="btn btn-secondary">Hủy</a>
                    </div>
                </div> --}}


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

                <div class="card">
                    <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer"
                        data-bs-target="#galleries" aria-expanded="true" aria-controls="galleries">
                        <h5 class="card-title mb-0">Album hình ảnh sản phẩm</h5>
                    </div>
                    <div class="collapse show" id="galleries">
                        <div class="card-body">
                            <div id="addGalleryButton" class="text-center mt-3"
                                style="cursor: pointer; border: 2px dashed #007bff; padding: 20px; border-radius: 5px;">
                                <span class="text-primary">Nhấn vào đây để thêm album hình ảnh</span>
                            </div>
                            <input type="file" id="galleryInput" name="galleries[]" multiple accept="image/*"
                                class="d-none">
                            <div class="row" id="galleryPreviewContainer"></div>
                            <button id="addGallery" class="btn btn-danger mt-3 d-none">Thêm ảnh</button>
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
                            <div id="addImageButton" class="text-center mt-3"
                                style="cursor: pointer; border: 2px dashed #007bff; padding: 20px; border-radius: 5px;">
                                <span class="text-primary">Nhấn vào đây để thêm hình ảnh</span>
                            </div>
                            <input type="file" id="imageInput" name="thumbnail" accept="image/*" class="d-none">
                            <div class="row" id="imagePreviewContainer"></div>
                            {{-- <button id="addGallery" class="btn btn-danger mt-3 d-none">Thêm ảnh</button> --}}
                        </div>

                    </div>
                </div>

                {{-- <div class="card">
                    <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer"
                        data-bs-target="#galleries" aria-expanded="true" aria-controls="galleries">
                        <h5 class="card-title mb-0">Album hình ảnh sản phẩm</h5>
                    </div>
                    <div class="collapse show" id="galleries">
                        <div class="card-body">
                            <div id="addGalleryButton" class="text-center mt-3"
                                style="cursor: pointer; border: 2px dashed #007bff; padding: 20px; border-radius: 5px;">
                                <span class="text-primary">Nhấn vào đây để thêm album hình ảnh</span>
                            </div>
                            <input type="file" id="galleryInput" name="galleries[]" multiple accept="image/*" class="d-none">
                            <div class="row" id="galleryPreviewContainer"></div>
                            <button id="addGallery" class="btn btn-danger mt-3 d-none">Thêm ảnh</button>
                        </div>
                    </div>
                </div> --}}

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
                                            id="tag{{ $tag->id }}" value="{{ $tag->id }}">
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
    <script>
        document.getElementById('toggleVariant').addEventListener('click', function() {
            var variantWrapper = document.getElementById('variantWrapper');
            var toggleButton = document.getElementById('toggleVariant');

            // Toggle the visibility of the variant wrapper
            variantWrapper.classList.toggle('d-none');

            // Change the button text
            if (variantWrapper.classList.contains('d-none')) {
                toggleButton.textContent = 'Thêm thuộc tính mới'; // Khi ẩn đi
                toggleButton.classList.add('btn-info');
                toggleButton.classList.remove('btn-danger');
            } else {
                toggleButton.textContent = 'Hủy'; // Khi hiện lên
                toggleButton.classList.remove('btn-info');
                toggleButton.classList.add('btn-danger');
            }
        });
    </script>

<script>
    $(document).ready(function() {
        // Khởi tạo Select2 cho các phần tử có sẵn
        $(".js-example-basic-multiple").select2();

        // Xử lý thay đổi nhóm thuộc tính
        $(document).on('change', '.select-variant-type', function() {
            var $this = $(this);
            var variantTypeId = $this.val(); // Lấy giá trị của nhóm thuộc tính

            var $attributeValueSelect = $this.closest('.row').find('.select-variant-value');

            if (variantTypeId == "0") {
                $attributeValueSelect.prop('disabled', true).empty(); // Xóa giá trị và disable
            } else {
                $attributeValueSelect.prop('disabled', false);

                // AJAX lấy giá trị của thuộc tính dựa trên nhóm thuộc tính đã chọn
                $.ajax({
                    url: "/admin/products/get-variant-value", // Đường dẫn tới route
                    type: "GET",
                    data: {
                        id: variantTypeId
                    },
                    success: function(response) {
                        console.log(response);
                        $attributeValueSelect.empty(); // Xóa option cũ

                        // Thêm các giá trị mới vào select
                        $.each(response, function(index, value) {
                            $attributeValueSelect.append('<option value="' + value.id + '">' + value.value + '</option>');
                        });

                        // Khởi tạo lại Select2 cho ô select giá trị thuộc tính
                        $attributeValueSelect.select2();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText); // Hiển thị lỗi nếu có
                    }
                });
            }
        });

        // Thêm phiên bản mới khi nhấn vào nút
        $('#addNewVariant').click(function() {
            // Tạo phần tử dòng mới chứa thuộc tính và giá trị đã chọn
            var imageUrl = $('#imagePreviewContainer').find('img').first().attr('src'); // Lấy URL của hình ảnh đầu tiên
            var newRow = `
            <div class="row mt-3">
                <div class="col-md-4">
                    <select class="js-example-basic-multiple select-variant-type" name="variant_types[]">
                        <option value="0">Chọn Nhóm thuộc tính</option>
                       
                    </select>
                </div>

                <div class="col-md-7">
                    <select class="js-example-basic-multiple form-select select-variant-value" name="variant_values[]" multiple disabled>
                        <!-- Giá trị sẽ được thêm thông qua Ajax -->
                    </select>
                </div>

                <div class="col-md-1">
                    <a class="btn btn-danger removeVariant"><i class="las la-trash-alt"></i></a>
                </div>
            </div>`;

            // Thêm dòng mới vào .variant-body
            $('.variant-body').append(newRow);

            // Khởi tạo Select2 chỉ cho các phần tử mới
            $('.variant-body .row:last .select-variant-type').select2();
            $('.variant-body .row:last .select-variant-value').select2();

            // Sự kiện xóa dòng
            $('.removeVariant').last().click(function() {
                $(this).closest('.row').remove();
                updateVariantList(); // Cập nhật danh sách phiên bản khi xóa
            });
        });

        // Cập nhật danh sách phiên bản
        function updateVariantList() {
            let $variantBody = $('#variantBody');
            $variantBody.empty(); // Xóa dữ liệu cũ

            // Khởi tạo biến lưu trữ các thuộc tính
            let variantGroups = {};

            // Lặp qua tất cả các dòng trong variant-body
            $('.variant-body .row').each(function() {
                const $row = $(this);
                const variantType = $row.find('.select-variant-type').find(':selected').text(); // Lấy tên nhóm thuộc tính
                const variantValue = $row.find('.select-variant-value').find(':selected').map(function() {
                    return $(this).text(); // Lấy giá trị đã chọn
                }).get(); // Lấy mảng giá trị

                // Nếu có giá trị cho thuộc tính, thêm vào mảng
                if (variantType && variantValue.length > 0) {
                    if (!variantGroups[variantType]) {
                        variantGroups[variantType] = [];
                    }
                    variantGroups[variantType] = variantGroups[variantType].concat(variantValue);
                }
            });

            const variantKeys = Object.keys(variantGroups);
            if (variantKeys.length > 0) {
                $('#variantContainer').removeClass('d-none'); // Hiện phần tử danh sách phiên bản

                let headerRow = '<tr><th>Hình ảnh</th>';
                variantKeys.forEach(key => {
                    headerRow += `<th>${key}</th>`;
                });
                headerRow += '<th>Số lượng</th><th>Giá tiền</th></tr>';
                $variantBody.append(headerRow);

                let allCombinations = [];
                const createCombinations = (index, currentCombination) => {
                    if (index === variantKeys.length) {
                        allCombinations.push(currentCombination);
                        return;
                    }

                    const key = variantKeys[index];
                    variantGroups[key].forEach(value => {
                        createCombinations(index + 1, {
                            ...currentCombination,
                            [key]: value
                        });
                    });
                };
                createCombinations(0, {});

                var imageUrl = $('#imagePreviewContainer').find('img').first().attr('src');

                allCombinations.forEach((combination, index) => {
                    let row = `<tr class="variant-row">`;
                    row += `<td><img src="${imageUrl}" alt="Thumbnail" style="width: 50px; height: 50px;" class="thumbnail"></td>`;

                    variantKeys.forEach(key => {
                        row += `<td class="variant-value">${combination[key]}</td>`;
                    });

                    // Thêm tên cho các trường input để xử lý trong controller
                    row += `<td><input class="form-control" type="number" name="quantities[${index}]" value="10" class="quantity-input" min="0"></td>`; // Số lượng
                    row += `<td><input class="form-control" type="number" name="prices[${index}]" value="10000" class="price-input"></td>`; // Giá
                    row += '</tr>';

                    $variantBody.append(row);
                });

            } else {
                $('#variantContainer').addClass('d-none'); // Ẩn container nếu không có giá trị
            }
        }

        // Cập nhật danh sách khi thay đổi thuộc tính hoặc giá trị
        $(document).on('change', '.select-variant-type, .select-variant-value', function() {
            updateVariantList();
        });
    });
</script>






    <script>
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
    </script>

    <script>
        $(document).ready(function() {
            $(".js-example-basic-single").select2(),
                $(".js-example-basic-multiple").select2();
        });
    </script>
@endpush
