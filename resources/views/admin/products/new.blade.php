@extends('admin.layouts.master')

@section('title', 'Thêm Sản Phẩm Mới')

@section('embed-css')
    <!-- include Bootstrap File Input -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.6/css/fileinput.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.6/themes/explorer-fa/theme.css"
        rel="stylesheet">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
@endsection

@section('custom-css')
    <style>
        span.error {
            display: block;
            margin-top: 5px;
            margin-bottom: 10px;
            color: #f30;
        }

        input.error,
        select.error {
            border-color: #f30;
            box-shadow: none;
        }
    </style>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.product.index') }}"><i class="fa fa-product-hunt" aria-hidden="true"></i> Quản Lý Sản
                Phẩm</a></li>
        <li class="active">Thêm Sản Phẩm Mới</li>
    </ol>
@endsection

@section('content')

    <form id="productForm" action="{{ route('admin.products.save') }}" method="POST" accept-charset="utf-8"
        enctype="multipart/form-data">
        @csrf
        {{-- End products --}}
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Thông Tin Sản Phẩm</h3>
                <div class="box-tools">
                    <!-- This will cause the box to collapse when clicked -->
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i
                            class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="title">Hình Ảnh Hiển Thị <span class="text-red">*</span></label>
                        <div class="upload-image text-center">
                            <div title="Image Preview" class="image-preview"
                                style="background-image: url('{{ Helper::get_image_product_url() }}'); padding-top: 100%; background-size: contain; background-repeat: no-repeat; background-position: center; margin-bottom: 5px; border: 1px solid #f4f4f4;">
                            </div>
                            <label for="upload" title="Upload Image" class="btn btn-primary btn-sm"><i
                                    class="fa fa-folder-open"></i>Chọn Hình Ảnh</label>
                            <input type="file" accept="image/*" id="upload" style="display:none" name="image"
                                required>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Tên Sản Phẩm <span class="text-red">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Tên sản Phẩm" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="stock">Số Lượng Sản Phẩm <span class="text-red">*</span></label>
                                    <input type="number" name="stock" class="form-control" id="stock"
                                        placeholder="Số lượng sản Phẩm" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sku_code">Mã Sản Phẩm <span class="text-red">*</span></label>
                                    <input type="text" name="sku_code" class="form-control" id="sku_code"
                                        placeholder="Mã sản Phẩm" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Danh mục <span class="text-red">*</span></label>
                                    <select class="form-control" name="producer_id" required>
                                        <option value="">-- Chọn danh mục --</option>
                                        @foreach ($producers as $producer)
                                            <option value="{{ $producer->id }}">{{ $producer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Start products --}}

         {{-- Start promotion --}}
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Thông Tin Khuyến Mãi</h3>
                <div class="box-tools">
                    <!-- This will cause the box to collapse when clicked -->
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i
                            class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div id="product-promotions"></div>
                <div class="text-center">
                    <button class="add-promotion btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Thêm Thông
                        Tin </button>
                </div>
            </div>
        </div>
        {{-- End promotion --}}

           {{-- Start astribuse --}}
           <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Thông Tin Thuộc Tính</h3>
                <div class="box-tools">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <!-- Thông Tin Thuộc Tính - Cột 1 -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Tên Thuộc Tính <span class="text-red">*</span></label>
                            <select name="attributes[{?}][attributes][]" class="form-control select2" id="attributes" multiple="multiple" required>
                                
                                <option value="option1">Thuộc tính 1</option>
                                <option value="option2">Thuộc tính 2</option>
                                <option value="option3">Thuộc tính 3</option>
                            </select>
                            <span class="error" id="name-error"></span>
                        </div>
                    </div>
                    <!-- Giới thiệu Thêm Giá trị Thuộc Tính - Cột 2 -->
                    <div class="col-md-8">
                        <div class="box-body">
                            <div id="product-attributes"></div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="button" class="add-variants btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Tạo Các Biến Thể </button>
                </div>
            </div>
        </div>
        {{-- End  astribuse --}}

         {{-- Start Detail --}}
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Thông Tin thể loại Và Giá Sản Phẩm</h3>
                <div class="box-tools">
                    <!-- This will cause the box to collapse when clicked -->
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i
                            class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div id="product-details"></div>
            </div>
            
        </div>
         {{-- End Detail --}}

         {{-- mo ta sp --}}
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#product-information" data-toggle="tab" style="display: none">Mô tả sản phẩm</a></li>
                <li><a href="#product-introduction" data-toggle="tab">Chi tiết sản phẩm </a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="product-information">
                    <textarea name="information_details" rows="20"></textarea>
                </div>
                <div class="tab-pane" id="product-introduction">
                    <textarea name="product_introduction" rows="20"></textarea>
                </div>
            </div>
        </div>
         {{-- end mo ta --}}
        <div class="box box-solid">
            <div class="box-body">
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-flat pull-right"><i class="fa fa-floppy-o"
                            aria-hidden="true"></i> Lưu</button>
                    <a href="{{ route('admin.product.index') }}" class="btn btn-danger btn-flat pull-right"
                        style="margin-right: 5px;"><i class="fa fa-ban" aria-hidden="true"></i> Hủy</a>
                </div>
            </div>
        </div>
    </form>
   
@endsection

@section('embed-js')
    <!-- include tinymce js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.0.15/tinymce.min.js"></script>
    <!-- include jquery.repeater -->
    <script src="{{ asset('AdminLTE/bower_components/jquery.repeatable.js') }}"></script>
    <!-- include Bootstrap File Input -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.6/js/fileinput.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.6/themes/explorer-fa/theme.js"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('AdminLTE/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- autoNumeric -->
    <script src="{{ asset('AdminLTE/bower_components/autoNumeric.js') }}"></script>
    <!-- Jquery Validate -->
    <script src="{{ asset('AdminLTE/bower_components/jquery-validate/jquery.validate.js') }}"></script>
@endsection

@section('custom-js')


{{-- detail products --}}
<script type="text/template" id="product-detail">
    <div class="field-group">
        <div class="box box-solid box-default" style="margin-bottom: 5px;">
          <div class="box-header">
            <h3 class="box-title"><span class="name"></span></h3>
            <div class="box-tools">
              <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
              <button class="btn btn-box-tool delete_detail" title="Remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
            
          <div class="box-body">
            <div class="row">

                <input type="hidden" name="product_details[{?}][sku]" class="form-control" id="sku_{?}" placeholder="Mã Sku " required autocomplete="off" readonly>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="quantity_{?}">Số Lượng <span class="text-red">*</span></label>
                  <input type="number" min="1" name="product_details[{?}][quantity]" class="form-control" id="quantity_{?}" placeholder="Số lượng" required autocomplete="off">
                </div>
              </div>
              
              <div class="col-md-2">
                <div class="form-group">
                  <label for="import_price_{?}">Giá Nhập (VNĐ) <span class="text-red">*</span></label>
                  <input type="text" name="product_details[{?}][import_price]" class="form-control currency" id="import_price_{?}" placeholder="Giá nhập" required autocomplete="off">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="sale_price_{?}">Giá Bán (VNĐ) <span class="text-red">*</span></label>
                  <input type="text" name="product_details[{?}][sale_price]" class="form-control currency" id="sale_price_{?}" placeholder="Giá bán" required autocomplete="off">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="promotion_price_{?}">Giá Khuyến Mại (VNĐ)</label>
                  <input type="text" name="product_details[{?}][promotion_price]" class="form-control currency" id="promotion_price_{?}" placeholder="Giá khuyến mại" autocomplete="off">
                </div>
              </div>
              <div class="col-md-4 ">
                <div class="form-group">
                  <label>Thời Gian Khuyến Mại</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right reservation" name="product_details[{?}][promotion_date]" autocomplete="off">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
              <label>Hình Ảnh Chi Tiết <span class="text-red">*</span></label>
              <input type="file" name="product_details[{?}][images][]" class="product-detail-images" multiple>
            </div>
          </div>
        </div>
      </div>
</script>
{{--End detail--}}

{{-- promotion --}}
<script type="text/template" id="product-promotion">
<div class="field-group">
  <div class="box box-solid box-default" style="margin-bottom: 5px;">
    <div class="box-header">
      <h3 class="box-title"></h3>
      <div class="box-tools">
        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-box-tool delete-promotion" title="Remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group" style="margin-bottom: 0;">
            <label for="promotion_{?}">Khuyến Mãi <span class="text-red">*</span></label>
            <input type="text" name="product_promotions[{?}][content]" class="form-control promotion" id="promotion_{?}" placeholder="Khuyến Mãi" required autocomplete="off">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Thời Gian Khuyến Mãi</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right promotion-reservation" name="product_promotions[{?}][promotion_date]" autocomplete="off" required>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</script>
{{-- End promotion --}}

{{-- new script--}}
<!-- Template đoạn HTML cần thêm -->
<script type="text/template" id="product-attributes-template">
    <div class="field-group">
        <div class="box box-solid box-default" style="margin-bottom: 5px;">
            <div class="box-header">
                <h3 class="box-title"></h3>
                <div class="box-tools">
                    <button class="btn btn-box-tool delete-attribute" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="attribute_{?}">Giá trị thuộc tính <span class="text-red">*</span></label>
                            <select name="values[{?}][value][]" class="form-control attribute select2" id="attribute_{?}" multiple="multiple" required>
                                <option value="value1">Giá trị 1</option>
                                <option value="value2">Giá trị 2</option>
                                <option value="value3">Giá trị 3</option>
                            </select>
                            <span class="error" id="attribute_{?}-error"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>
<script>
    $(document).ready(function() {
         // Ẩn nút "Tạo Các Biến Thể" ban đầu
    var addVariantsButton = $('.add-variants');
    addVariantsButton.hide();  // Ẩn nút khi chưa có lựa chọn

    // Lắng nghe sự thay đổi của select thuộc tính
    $('#attributes').on('change', function() {
        var selectedValue = $(this).val(); // Lấy giá trị của thuộc tính được chọn

        // Nếu có giá trị được chọn, hiển thị nút "Tạo Các Biến Thể"
        if (selectedValue) {
            addVariantsButton.show();  // Hiển thị nút
        } else {
            addVariantsButton.hide();  // Ẩn nút nếu không có giá trị nào được chọn
        }
    });
        // Tạo cấu hình chung cho TinyMCE
        const tinyMceConfig = {
            plugins: 'media image code table link lists preview fullscreen',
            toolbar: 'undo redo | formatselect | fontsizeselect | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | numlist bullist | outdent indent | link image media table | code preview fullscreen',
            toolbar_drawer: 'sliding',
            entity_encoding: "raw",
            branding: false,
            image_title: true,
            height: 400,
            min_height: 300,
            link_assume_external_targets: 'http',
            media_alt_source: false,
            media_poster: false,
            automatic_uploads: true,
            file_picker_types: 'image',
            file_picker_callback: function (cb, value, meta) {
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
    
                input.onchange = function () {
                    const file = this.files[0];
                    const reader = new FileReader();
                    
                    reader.onload = function () {
                        const id = 'blobid' + new Date().getTime();
                        const blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        const base64 = reader.result.split(',')[1];
                        const blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);
    
                        // Gọi callback để thêm ảnh
                        cb(blobInfo.blobUri(), { title: file.name });
                    };
    
                    reader.readAsDataURL(file);
                };
    
                input.click();
            }
        };
    
        // Khởi tạo TinyMCE cho các textarea cụ thể
        tinymce.init({
            ...tinyMceConfig,
            selector: '#product-information>textarea'
        });
    
        tinymce.init({
            ...tinyMceConfig,
            selector: '#product-introduction>textarea'
        });
    
        // Quản lý sự kiện upload ảnh
        $("#upload").change(function(event) {
            var target = event.target || event.srcElement;
            if (target.value.length == 0) {
                $('.upload-image .image-preview').css('background-image', 'url("{{ Helper::get_image_product_url() }}")');
            } else {
                $('.upload-image .image-preview').css('background-image', 'url("' + getImageURL(this) + '")');
            }
        });
    
        function getImageURL(input) {
            return URL.createObjectURL(input.files[0]);
        };
    
        // Quản lý các promotion
        $("#product-promotions").repeatable({
            addTrigger: 'button.add-promotion',
            deleteTrigger: 'button.delete-promotion',
            template: "#product-promotion",
            afterAdd: function() {
                $('.promotion-reservation').daterangepicker({
                    autoApply: true,
                    minDate: moment(),
                    "locale": {
                        "format": "DD/MM/YYYY",
                    }
                });
                $('#product-promotions .box').boxWidget();
                $('#product-promotions .field-group:not(:last-child) .box').boxWidget('collapse');
                $('#product-promotions .field-group:last-child .box').boxWidget('expand');
                $('input.promotion').on('keyup', function() {
                    var val = $(this).val().trim();
                    $(this).closest('.box').find('.box-header .box-title').text(val);
                });
            }
        });
    
        // Xác thực form
        $("#productForm").validate({
            normalizer: function(value) {
                return $.trim(value);
            },
            errorElement: "span",
            ignore: "",
            highlight: function(element, errorClass, validClass) {
                $(element).addClass(errorClass).removeClass(validClass);
                if ($(element).parents('div#product-details').length || $(element).parents('div#product-promotions').length) {
                    $(element).parents('.box').boxWidget('expand');
                }
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass(errorClass).addClass(validClass);
            }
        });
    
        let attributeIndex = 0;
    
        // Hàm khởi tạo Select2
        function initializeSelect2() {
            $('.select2').select2({
                placeholder: "Chọn giá trị thuộc tính",
                allowClear: true
            });
        }
    
        // Hàm thêm trường thuộc tính mới
        function addAttributeField() {
            const template = $('#product-attributes-template').html();
            const newField = template.replace(/{\?}/g, attributeIndex);
            $('#product-attributes').append(newField);
            attributeIndex++;
    
            // Khởi tạo Select2 cho các phần tử mới thêm
            initializeSelect2();
        }
    
        // Khởi tạo Select2 lần đầu
        initializeSelect2();
    
        // Khi thay đổi giá trị trong select, tự động thêm đoạn mã
        $('#attributes').on('change', function() {
            const selectedValue = $(this).val();
            if (selectedValue) {
                addAttributeField();
            }
        });
    
        // Xóa trường thuộc tính
        $(document).on('click', '.delete-attribute', function() {
            $(this).closest('.field-group').remove();
        });
    
     // Xử lý khi nhấn nút "Tạo Các Biến Thể"
$(document).on('click', '.add-variants', function() {
    let allAttributes = [];
    
    // Lấy giá trị từ các select2 (thuộc tính)
    $('select[name^="values"]').each(function() {
        allAttributes.push($(this).val());
    });

    // Tạo tất cả các kết hợp giá trị từ các thuộc tính
    let combinations = generateCombinations(allAttributes);

    const productDetailTemplate = $('#product-detail').html();
    const productDetailsContainer = $('#product-details');

    // Reset lại container để không bị trùng lặp
    productDetailsContainer.empty();

    // Tạo các biến thể mới
    combinations.forEach((combination, index) => {
        const variantName = combination.filter(val => val).join(' - ');
        // In ra giá trị variantName để kiểm tra
    console.log('variantName:', variantName);
        let newDetail = productDetailTemplate.replace(/{\?}/g, index);
        
        newDetail = newDetail.replace('<span class="name"></span>', `<span class="name">${combination.filter(val => val).join(' - ')}</span>`);

        newDetail = newDetail.replace(
        '<input type="text" name="product_details[{?}][sku]" class="form-control" id="sku_{?}" placeholder="Mã Sku " required autocomplete="off">',
        `<input type="text" name="product_details[${index}][sku]" class="form-control" id="sku_${index}" value="${variantName}" placeholder="Mã Sku " required autocomplete="off">`
    );
        // Thêm các biến thể mới vào container
        productDetailsContainer.append(newDetail);

          // Đảm bảo giá trị SKU được điền vào đúng ô input
    $(`#sku_${index}`).val(variantName);

    });

    // Sau khi thêm mục mới vào
    afterAdd();
});

    
        function generateCombinations(attributes) {
            if (attributes.length === 0) return [[]];
    
            let first = attributes[0];
            let rest = generateCombinations(attributes.slice(1));
    
            let combinations = [];
            if (Array.isArray(first)) {
                first.forEach(function(f) {
                    rest.forEach(function(r) {
                        combinations.push([f, ...r]);
                    });
                });
            } else {
                rest.forEach(function(r) {
                    combinations.push([first, ...r]);
                });
            }
    
            return combinations;
        }
    
        // Xử lý nút xóa khi nhấn vào "X"
        $(document).on('click', '.delete_detail', function() {
            $(this).closest('.field-group').remove(); // Xóa phần tử khi nhấn vào xóa
        });
    
        // Thêm phương thức afterAdd
        function afterAdd() {
            $(".product-detail-images").fileinput({
                theme: "explorer-fa",
                required: true,
                showUpload: false,
                showCaption: false,
                showClose: false,
                maxFileCount: 8,
                allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg', 'web', 'webp'],
                initialPreviewAsData: true,
                maxFileSize: 1000,
                overwriteInitial: false,
                removeFromPreviewOnError: true,
            });
    
            $('.reservation').daterangepicker({
                autoApply: true,
                autoUpdateInput: false,
                minDate: moment(),
                "locale": {
                    "format": "DD/MM/YYYY",
                }
            });
    
            $('.reservation').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });
    
            $('.reservation').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
    
            $('input.currency').autoNumeric('init', {
                aSep: '.',
                aDec: ',',
                aPad: false,
                lZero: 'deny',
                vMin: '0'
            });
    
            $('#product-details .box').boxWidget();
            $('#product-details .field-group:not(:last-child) .box').boxWidget('collapse');
            $('#product-details .field-group:last-child .box').boxWidget('expand');
        }
    
        // Xử lý trước khi xóa
        function beforeDelete(target) {
            $(target).find('.product-detail-images').fileinput('destroy');
        }
    });
    </script>
    
@endsection
