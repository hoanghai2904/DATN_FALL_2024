@extends('admin.layouts.master')

@section('title', 'Chỉnh Sửa Sản Phẩm')

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
        <li><a href="{{ route('admin.products.index') }}"><i class="fa fa-product-hunt" aria-hidden="true"></i> Quản Lý Sản
                Phẩm</a></li>
        <li class="active">Chỉnh Sửa Sản Phẩm</li>
    </ol>
@endsection

@section('content')

    <form id="productForm" action="{{ route('admin.products.update', ['id' => $product->id]) }}" method="POST"
        accept-charset="utf-8" enctype="multipart/form-data">
        @csrf
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
                                style="background-image: url('{{ Helper::get_image_product_url($product->image) }}'); padding-top: 100%; background-size: contain; background-repeat: no-repeat; background-position: center; margin-bottom: 5px; border: 1px solid #f4f4f4;">
                            </div>
                            <label for="upload" title="Upload Image" class="btn btn-primary btn-sm"><i
                                    class="fa fa-folder-open"></i>Chọn Hình Ảnh</label>
                            <input type="file" accept="image/*" id="upload" style="display:none" name="image">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Tên Sản Phẩm <span class="text-red">*</span></label>
                                    <input type="text" name="name_product" class="form-control" id="name_product"
                                        placeholder="Tên sản Phẩm" required autocomplete="off" value="{{ $product->name }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sku_code">Mã Sản Phẩm <span class="text-red">*</span></label>
                                    <input type="text" name="sku_code" class="form-control" id="sku_code"
                                        placeholder="Mã sản Phẩm" required autocomplete="off"
                                        value="{{ $product->sku_code }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Danh mục <span class="text-red">*</span></label>
                                    <select class="form-control" name="producer_id" required>
                                        <option value="">-- Chọn danh mục --</option>
                                        @foreach ($producers as $producer)
                                            <option value="{{ $producer->id }}"
                                                {{ $product->producer_id == $producer->id ? 'selected' : '' }}>
                                                {{ $producer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                <div id="product-promotions">
                    @if ($product->promotions->isNotEmpty())
                        @foreach ($product->promotions as $promotion)
                            <div class="box box-solid box-default collapsed-box" style="margin-bottom: 5px;">
                                <div class="box-header">
                                    <h3 class="box-title">{{ $promotion->content }}</h3>
                                    <div class="box-tools">
                                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                            title="Collapse"><i class="fa fa-plus"></i></button>
                                        <a href="javascript:void(0);" data-id="{{ $promotion->id }}"
                                            class="btn btn-box-tool remove-promotion" title="Xóa"
                                            data-url="{{ route('admin.products.delete_promotion') }}"
                                            style="color: #f30;">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="box-body" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group" style="margin-bottom: 0;">
                                                <label for="old_promotion_{{ $promotion->id }}">Khuyến Mãi <span
                                                        class="text-red">*</span></label>
                                                <input type="text"
                                                    name="old_product_promotions[{{ $promotion->id }}][content]"
                                                    class="form-control promotion"
                                                    id="old_promotion_{{ $promotion->id }}" placeholder="Khuyến Mãi"
                                                    required autocomplete="off" value="{{ $promotion->content }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Thời Gian Khuyến Mãi</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control pull-right promotion-reservation"
                                                        name="old_product_promotions[{{ $promotion->id }}][promotion_date]"
                                                        autocomplete="off" required
                                                        value="{{ date_format(date_create($promotion->start_date), 'd/m/Y') . ' - ' . date_format(date_create($promotion->end_date), 'd/m/Y') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="text-center">
                    <button class="add-promotion btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Thêm
                        Khuyến Mãi</button>
                </div>
            </div>
        </div>
        {{-- Start astribuse --}}
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Thông Tin Thuộc Tính</h3>
                <div class="box-tools">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i
                            class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <!-- Thông Tin Thuộc Tính - Cột 1 -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Tên Thuộc Tính <span class="text-red">*</span></label>
                            <select name="attributes[0][attribute][]" class="form-control select2" id="attributes_0"
                                multiple="multiple" required disabled>
                                @foreach ($attributes as $attribute)
                                    <option value="{{ $attribute->id }}"
                                        @if (in_array($attribute->id, $attributeIds->toArray())) selected @endif>
                                        {{ $attribute->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="error" id="name-error"></span>
                         <!-- Hidden input để gửi giá trị selected -->
                            <input type="hidden" name="attributes[0][attribute][]" value="{{ implode(',', $attributeIds->toArray()) }}">
                        </div>

                    </div>
                    <!-- Giới thiệu Thêm Giá trị Thuộc Tính - Cột 2 -->
                    <div class="col-md-8">
                        <div class="box-body">
                            <div id="product-attributes">

                                <div class="field-group">
                                    @foreach ($attributes_value as $attribute)
                                        <div class="box box-solid box-default" style="margin-bottom: 5px;">
                                            <div class="box-header">
                                                <h3 class="box-title">Thuộc tính: {{ $attribute->name }}</h3>
                                                <div class="box-tools">
                                                    {{-- <button class="btn btn-box-tool delete-attribute" title="Remove"><i class="fa fa-times"></i></button> --}}
                                                </div>
                                            </div>
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label
                                                                for="attribute_{{ $attribute->id }}">{{ $attribute->name }}</label>
                                                            <select name="values[{{ $attribute->id }}][value][]"
                                                                class="form-control select2"
                                                                id="values_{{ $attribute->id }}" multiple="multiple"
                                                                required>
                                                                @foreach ($attribute->values as $value)
                                                                    <option value="{{ $value->id }}"
                                                                        @php
// Loại bỏ khoảng trắng thừa và so sánh
                                                                    $isSelected = in_array(trim($value->value), array_map('trim', $skuList->toArray())) ? 'selected' : ''; @endphp
                                                                        {{ $isSelected }}>
                                                                        {{ $value->value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <span class="error"
                                                                id="attribute_{{ $attribute->id }}-error"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="button" class="add-variants btn btn-success"><i class="fa fa-plus"
                            aria-hidden="true"></i>Tạo Các Biến Thể </button>
                </div>
            </div>
        </div>
        {{-- End astribuse --}}
        {{-- Start variants --}}
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Thông Tin Loại Và Giá Sản Phẩm</h3>
                <div class="box-tools">
                    <!-- This will cause the box to collapse when clicked -->
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i
                            class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div id="product-details">
                    @if ($product->variants->isNotEmpty())
                        @foreach ($product->variants as $product_detail)
                            {{-- @dd($product->variants); --}}
                            <div class="field-group">
                                <div class="box  box-solid box-default" style="margin-bottom: 5px;">
                                    <div class="box-header">
                                        <h3 class="box-title">

                                            <span
                                                class="color">{{ preg_replace('/^[a-zA-Z0-9]+-/', '', $product_detail->sku) }}</span>
                                        </h3>
                                        <div class="box-tools">
                                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                                title="Collapse"><i class="fa fa-minus"></i>
                                            </button>
                                            <a href="javascript:void(0);" data-id="{{ $product_detail->id }}"
                                                class="btn btn-box-tool remove-product-detail" title="Xóa"
                                                data-url="{{ route('admin.products.delete_product_detail') }}"
                                                style="color: #f30;">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <div class="row">

                                            {{-- <input type="hidden" name="product_details[{?}][sku]" class="form-control"
                                                id="sku_{?}" placeholder="Mã Sku " required autocomplete="off"
                                                readonly> --}}

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="quantity_{?}">Số Lượng <span
                                                            class="text-red">*</span></label>
                                                    <input type="text"
                                                        name="old_product_details[{{ $product_detail->id }}][quantity]"
                                                        class="form-control currency"
                                                        id="quantity_{{ $product_detail->id }}" placeholder="Số lượng"
                                                        required autocomplete="off"
                                                        value="{{ $product_detail->stock_quantity }}">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="import_price_{?}">Giá Nhập (VNĐ) <span
                                                            class="text-red">*</span></label>
                                                    <input type="text"
                                                        name="old_product_details[{{ $product_detail->id }}][import_price]"
                                                        class="form-control currency"
                                                        id="import_price_{{ $product_detail->id }}"
                                                        placeholder="Giá nhập" required autocomplete="off"
                                                        value="{{ $product_detail->purchase_price }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="sale_price_{?}">Giá Bán (VNĐ) <span
                                                            class="text-red">*</span></label>
                                                    <input type="text"
                                                        name="old_product_details[{{ $product_detail->id }}][sale_price]"
                                                        class="form-control currency"
                                                        id="sale_price_{{ $product_detail->id }}" placeholder="Giá bán"
                                                        required autocomplete="off" value="{{ $product_detail->price }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="promotion_price_{?}">Giá Khuyến Mại (VNĐ)</label>
                                                    <input type="text"
                                                        name="old_product_details[{{ $product_detail->id }}][promotion_price]"
                                                        class="form-control currency"
                                                        id="promotion_price_{{ $product_detail->id }}"
                                                        placeholder="Giá khuyến mại" autocomplete="off"
                                                        value="{{ $product_detail->promotion_price }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4 ">
                                                <div class="form-group">
                                                    <label>Thời Gian Khuyến Mại</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control pull-right reservation"
                                                            name="old_product_details[{{ $product_detail->id }}][promotion_date]"
                                                            autocomplete="off"
                                                            value="{{ $product_detail->promotion_start_date != null && $product_detail->promotion_end_date != null ? date_format(date_create($product_detail->promotion_start_date), 'd/m/Y') . ' - ' . date_format(date_create($product_detail->promotion_end_date), 'd/m/Y') : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" style="margin-bottom: 0;">
                                            <label>Hình Ảnh Chi Tiết <span class="text-red">*</span></label>
                                            <input type="file"
                                                name="old_product_details[{{ $product_detail->id }}][images][]"
                                                class="product-detail-{{ $product_detail->id }}-images" multiple>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>
        {{-- end variants  --}}
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#product-information" data-toggle="tab" style="display: none">Mô tả sản
                        phẩm</a></li>
                <li><a href="#product-introduction" data-toggle="tab">Chi tiết Sản Phẩm</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="product-information">
                    <textarea name="information_details" rows="20">{{ $product->information_details }}</textarea>
                </div>
            </div>
        </div>
        <div class="box box-solid">
            <div class="box-body">
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-flat pull-right"><i class="fa fa-floppy-o"
                            aria-hidden="true"></i> Lưu</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-danger btn-flat pull-right"
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
                  <input type="text" name="product_details[{?}][quantity]" class="form-control" id="quantity_{?}" placeholder="Số lượng" required autocomplete="off">
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
    {{-- end detail --}}
    {{-- Start value  --}}
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
                            <select name="values[{?}][value][]" class="form-control attribute select2" id="values_{?}" multiple="multiple" required>
                                
                            </select>
                            <span class="error" id="attribute_{?}-error"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>
    {{-- end  value  --}}
    {{-- Start promotion --}}
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
    <script>
        $(document).ready(function() {
            @if ($product->variants->isNotEmpty())
                @foreach ($product->variants as $product_detail)
                    $(".product-detail-{{ $product_detail->id }}-images").fileinput({
                        theme: "explorer-fa",
                        required: false,
                        showUpload: false,
                        showCaption: false,
                        showClose: false,
                        maxFileCount: 8,
                        allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg', 'web', 'webp'],
                        initialPreviewAsData: true,
                        maxFileSize: 1000,
                        overwriteInitial: false,
                        removeFromPreviewOnError: true,
                        deleteUrl: "{{ route('admin.products.delete_image') }}",
                        ajaxDeleteSettings: {
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        },
                        @if ($product_detail->images->isNotEmpty())
                            initialPreview: [
                                @foreach ($product_detail->images as $image)
                                    '{{ Helper::get_image_product_url($image->image_name) }}',
                                @endforeach
                            ],
                            initialPreviewConfig: [
                                @foreach ($product_detail->images as $image)
                                    {
                                        caption: "{{ $image->image_name }}",
                                        key: {{ $image->id }}
                                    },
                                @endforeach
                            ],
                        @endif
                    });
                @endforeach
            @endif
            // Ẩn nút "Tạo Các Biến Thể" ban đầu
            var addVariantsButton = $('.add-variants');
            addVariantsButton.hide(); // Ẩn nút khi chưa có lựa chọn

            // Lắng nghe sự thay đổi của select thuộc tính
            $('[id^="values_"]').on('change', function() {
                var selectedValue = $(this).val(); // Lấy giá trị của thuộc tính được chọn

                // Nếu có giá trị được chọn, hiển thị nút "Tạo Các Biến Thể"
                if (selectedValue) {
                    addVariantsButton.show(); // Hiển thị nút
                } else {
                    addVariantsButton.hide(); // Ẩn nút nếu không có giá trị nào được chọn
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
                file_picker_callback: function(cb, value, meta) {
                    const input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.onchange = function() {
                        const file = this.files[0];
                        const reader = new FileReader();

                        reader.onload = function() {
                            const id = 'blobid' + new Date().getTime();
                            const blobCache = tinymce.activeEditor.editorUpload.blobCache;
                            const base64 = reader.result.split(',')[1];
                            const blobInfo = blobCache.create(id, file, base64);
                            blobCache.add(blobInfo);

                            // Gọi callback để thêm ảnh
                            cb(blobInfo.blobUri(), {
                                title: file.name
                            });
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
                    $('.upload-image .image-preview').css('background-image',
                        'url("{{ Helper::get_image_product_url() }}")');
                } else {
                    $('.upload-image .image-preview').css('background-image', 'url("' + getImageURL(this) +
                        '")');
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
                    if ($(element).parents('div#product-details').length || $(element).parents(
                            'div#product-promotions').length) {
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
                    allowClear: false, // Tắt nút "Clear"
                    minimumResultsForSearch: Infinity,
                });
            }

            // Hàm thêm trường thuộc tính mới
            function addAttributeField(index, attributeId, attributeName) {
                const template = $('#product-attributes-template').html();
                const newField = template.replace(/{\?}/g, index);
                const fieldHTML = $(newField);

                // Đặt tiêu đề cho box dựa trên giá trị thuộc tính
                fieldHTML.find('.box-title').text(`Thuộc tính: ${attributeName}`);

                // Gán data-attribute-id cho trường mới
                fieldHTML.attr('data-attribute-id', attributeId);

                $('#product-attributes').append(fieldHTML);

                // Gọi API để lấy giá trị của thuộc tính
                $.ajax({
                    url: `/admin/attributes/${attributeId}/values`, // API để lấy giá trị thuộc tính
                    type: 'GET',
                    success: function(response) {
                        const selectElement = fieldHTML.find('.attribute');

                        // Thêm các giá trị vào select
                        response.values.forEach(value => {
                            selectElement.append(
                                `<option value="${value.id}">${value.name}</option>`);
                        });

                        // Khởi tạo lại Select2 cho các phần tử mới
                        initializeSelect2();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        alert(`Không thể tải giá trị của thuộc tính: ${attributeName}`);
                    }
                });
            }

            // Khởi tạo Select2 lần đầu
            initializeSelect2();

            // Lưu trạng thái trước đó của trường
            let previousValues = {};

            // Khi thay đổi giá trị trong select, tự động thêm/xóa đoạn mã
            $(document).on('change', '[id^="attributes_"]', function() {
                const selectId = $(this).attr('id');
                const selectedValues = $(this).val() ||
            []; // Giá trị hiện tại (nếu không có trả về mảng rỗng)
                const prevSelectedValues = previousValues[selectId] || []; // Giá trị trước đó

                // Tìm các giá trị được thêm vào
                const addedValues = selectedValues.filter(value => !prevSelectedValues.includes(value));
                // Tìm các giá trị bị xóa
                const removedValues = prevSelectedValues.filter(value => !selectedValues.includes(value));

                // Thêm các giá trị mới
                addedValues.forEach(attributeId => {
                    // Kiểm tra xem thuộc tính đã được thêm vào chưa
                    if (!$(`#product-attributes .field-group[data-attribute-id="${attributeId}"]`)
                        .length) {
                        const attributeName = $(this).find(`option[value="${attributeId}"]`)
                            .text(); // Lấy tên thuộc tính
                        addAttributeField(attributeIndex, attributeId, attributeName);
                        attributeIndex++;
                    }
                });

                // Xóa các giá trị bị loại bỏ
                removedValues.forEach(value => {
                    // Sử dụng `data-attribute-id` để tìm đúng phần tử cần xóa
                    $(`#product-attributes .field-group[data-attribute-id="${value}"]`).remove();
                });

                // Cập nhật trạng thái trước đó
                previousValues[selectId] = selectedValues;
            });

            // Xóa trường thuộc tính
            $(document).on('click', '.delete-attribute', function() {
                $(this).closest('.field-group').remove();
            });


            // Lưu trữ các thuộc tính cũ khi trang tải
            let existingAttributes = {};

            // Lưu trữ các thuộc tính đã có
            $('select[name^="values"]').each(function() {
                const values = $(this).val();
                const attributeName = $(this).closest('.box').find('.box-title').text().trim().replace(
                    /^[^:]*: /, '');

                // Lấy tên thuộc tính
                console.log("aa:", attributeName);

                // Kiểm tra xem giá trị có phải là mảng hay không, nếu không thì chuyển thành mảng
                if (Array.isArray(values)) {
                    existingAttributes[attributeName] = values; // Lưu các giá trị thuộc tính
                } else {
                    existingAttributes[attributeName] = [values]; // Lưu giá trị đơn
                }
            });

            console.log("Existing attributes:", existingAttributes);


            // Xử lý khi nhấn nút "Tạo Các Biến Thể"
            $(document).on('click', '.add-variants', function() {
                let allAttributes = [];
                let newAttributes = [];

                // Lấy giá trị từ các select2 (thuộc tính)
                $('select[name^="values"]').each(function() {
                    const currentValue = $(this).val();
                    const attributeName = $(this).closest('.box').find('.box-title').text().trim()
                        .replace(/^[^:]*: /, '');
                    allAttributes.push(currentValue);

                    // Nếu currentValue là một mảng (nhiều giá trị), ta cần kiểm tra từng giá trị
                    if (Array.isArray(currentValue)) {
                        currentValue.forEach(function(value) {
                            let isValueExists = false;
                            // Kiểm tra tất cả thuộc tính trong existingAttributes
                            for (let key in existingAttributes) {
                                if (existingAttributes[key].includes(value)) {
                                    isValueExists = true;
                                    break;
                                }
                            }

                            // Nếu chưa có, thêm vào newAttributes với tên thuộc tính và giá trị
                            if (!isValueExists && !newAttributes.some(attr => attr
                                    .attributeName === attributeName && attr.value === value
                                    )) {
                                newAttributes.push({
                                    attributeName: attributeName,
                                    value: value
                                });
                            }
                        });
                    } else {
                        let isValueExists = false;
                        // Kiểm tra tất cả thuộc tính trong existingAttributes
                        for (let key in existingAttributes) {
                            if (existingAttributes[key].includes(currentValue)) {
                                isValueExists = true;
                                break;
                            }
                        }

                        // Nếu chưa có, thêm vào newAttributes với tên thuộc tính và giá trị
                        if (!isValueExists && !newAttributes.some(attr => attr.attributeName ===
                                attributeName && attr.value === currentValue)) {
                            newAttributes.push({
                                attributeName: attributeName,
                                value: currentValue
                            });
                        }
                    }
                });

                console.log("New attributes:", newAttributes);

                // Nếu có thuộc tính mới được thêm vào, tạo biến thể mới
                if (newAttributes.length > 0) {
                    let combinations = [];

                    // Kiểm tra số lượng thuộc tính trong existingAttributes
                    if (Object.keys(existingAttributes).length === 1) {
                        newAttributes = newAttributes.map(attr => attr.value);
                        combinations = generateCombinations([newAttributes]);
                        console.log(combinations);

                    } else if (Object.keys(existingAttributes).length === 2 && newAttributes.length === 2) {

                        let newCombinations = [];
                        newAttributes.forEach((attr, index) => {
                            for (let i = index + 1; i < newAttributes.length; i++) {
                                const otherAttr = newAttributes[i];
                                newCombinations.push([attr.value, otherAttr.value]);
                            }
                        });

                        // Sau khi tạo biến thể xong, tiếp tục logic với existingAttributes
                        newAttributes.forEach(attr => {
                            if (existingAttributes[attr.attributeName]) {
                                const otherAttributeName = Object.keys(existingAttributes).find(
                                    name => name !== attr.attributeName);
                                const otherValues = existingAttributes[otherAttributeName];

                                otherValues.forEach(otherValue => {
                                    combinations.push([attr.value, otherValue]);
                                });
                            }
                        });
                        combinations = [...newCombinations, ...combinations];

                    } else if (Object.keys(existingAttributes).length === 2) {
                        // Nếu có 2 thuộc tính trong existingAttributes
                        newAttributes.forEach(attr => {
                            if (existingAttributes[attr.attributeName]) {
                                const otherAttributeName = Object.keys(existingAttributes).find(
                                    name => name !== attr.attributeName);
                                const otherValues = existingAttributes[otherAttributeName];

                                otherValues.forEach(otherValue => {
                                    combinations.push([attr.value, otherValue]);
                                });
                            }
                        });
                    }

                    const productDetailTemplate = $('#product-detail').html();
                    const productDetailsContainer = $('#product-details');

                    // Chỉ tạo biến thể cho các kết hợp
                    combinations.forEach((combination, index) => {
                        const variantName = combination.map(attributeValue => {
                            const optionText = $(`option[value="${attributeValue}"]`)
                        .text(); // Tìm tên của thuộc tính dựa trên giá trị
                            return optionText;
                        }).join(' - ');

                        console.log('variantName:', variantName);

                        let newDetail = productDetailTemplate.replace(/{\?}/g, index);
                        newDetail = newDetail.replace('<span class="name"></span>',
                            `<span class="name">${variantName}</span>`);

                        newDetail = newDetail.replace(
                            '<input type="text" name="product_details[{?}][sku]" class="form-control" id="sku_{?}" placeholder="Mã Sku " required autocomplete="off">',
                            `<input type="text" name="product_details[${index}][sku]" class="form-control" id="sku_${index}" value="${variantName}" placeholder="Mã Sku " required autocomplete="off">`
                        );

                        productDetailsContainer.append(newDetail);

                        $(`#sku_${index}`).val(variantName);
                    });

                    // Cập nhật danh sách thuộc tính hiện tại (bao gồm cả thuộc tính mới)
                    existingAttributes = {};

                    allAttributes.forEach(attribute => {
                        if (!existingAttributes[attribute]) {
                            existingAttributes[attribute] = [];
                        }
                        existingAttributes[attribute] = [...existingAttributes[attribute], ...
                            newAttributes
                        ];
                    });

                    console.log("Updated existing attributes:", existingAttributes);
                } else {
                    console.log("No new attributes added, no variants created.");
                }

                // Sau khi thêm mục mới vào
                afterAdd();
            });

            // Hàm generateCombinations để tạo kết hợp
            function generateCombinations(attributes) {
                // Nếu chỉ có một thuộc tính
                if (attributes.length === 1) {
                    return attributes[0].map(value => [value]); // Trả về mảng với các giá trị trong thuộc tính đó
                }

                // Nếu có nhiều thuộc tính
                let result = [];
                let firstAttribute = attributes[0]; // Lấy thuộc tính đầu tiên
                let remainingAttributes = attributes.slice(1); // Lấy các thuộc tính còn lại

                // Tạo các kết hợp giữa thuộc tính đầu tiên và các kết hợp của các thuộc tính còn lại
                firstAttribute.forEach(value => {
                    let combinations = generateCombinations(remainingAttributes);
                    combinations.forEach(combination => {
                        result.push([value, ...combination]);
                    });
                });

                return result;
            }


            function generateCombinations(attributes) {
                if (attributes.length === 0) return [
                    []
                ];

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
                    $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                        'DD/MM/YYYY'));
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

            // Xử lý nút xóa khi nhấn vào "X"
            $(document).on('click', '.delete_detail', function() {
                $(this).closest('.field-group').remove(); // Xóa phần tử khi nhấn vào xóa
            });


            // Xử lý trước khi xóa
            // function beforeDelete(target) {
            //     $(target).find('.product-detail-images').fileinput('destroy');
            // }


        });
        // scrip new 
        // Thêm phương thức afterAdd
        $(document).ready(function() {

                    $(".remove-promotion").click(function() {

                        var promotion_id = $(this).attr('data-id');
                        var url = $(this).attr('data-url');

                        Swal.fire({
                            type: 'question',
                            title: 'Thông báo',
                            text: 'Bạn có chắc muốn xóa khuyến mãi này?',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            showLoaderOnConfirm: true,
                            preConfirm: () => {
                                return fetch(url, {
                                        method: 'POST',
                                        headers: {
                                            'Accept': 'application/json',
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                                'content')
                                        },
                                        body: JSON.stringify({
                                            'promotion_id': promotion_id
                                        }),
                                    })
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error(response.statusText);
                                        }
                                        return response.json();
                                    })
                                    .catch(error => {
                                        Swal.showValidationMessage(error);

                                        Swal.update({
                                            type: 'error',
                                            title: 'Lỗi!',
                                            text: '',
                                            showConfirmButton: false,
                                            cancelButtonText: 'Ok',
                                        });
                                    })
                            },
                        }).then((result) => {
                            if (result.value) {
                                Swal.fire({
                                    type: result.value.type,
                                    title: result.value.title,
                                    text: result.value.content,
                                }).then((result) => {
                                    if (result.value) {
                                        $(this).closest('.box').remove();
                                    }
                                });
                            }
                        })
                    });

                    $(".remove-product-detail").click(function() {
    var product_detail_id = $(this).attr('data-id');
    console.log("productdetail:", product_detail_id);

    var url = $(this).attr('data-url');
    var $currentButton = $(this);

    // Kiểm tra số lượng trước khi thực hiện xóa
    if ($('#product-details .field-group').length == 1) {
        Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: 'sản phẩm phải có ít nhất một biến thể thêm biến thể để xóa biến thể cũ !'
        });
        return;
    }

    Swal.fire({
        icon: 'question',
        title: 'Thông báo',
        text: 'Bạn có chắc muốn xóa chi tiết sản phẩm này?',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body: JSON.stringify({
                        'product_detail_id': product_detail_id
                    }),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.json();
                })
                .catch(error => {
                    Swal.showValidationMessage(error);
                    Swal.update({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: '',
                        showConfirmButton: false,
                        cancelButtonText: 'Ok',
                    });
                });
        },
    }).then((result) => {
        if (result.value) {
            Swal.fire({
                icon: result.value.type,
                title: result.value.title,
                text: result.value.content,
            }).then(() => {
                // Xóa phần tử hiện tại khỏi DOM
                $currentButton.closest('.field-group').remove();

                // Kiểm tra lại số lượng phần tử sau khi xóa
                console.log("length sau khi xóa:", $('#product-details .field-group').length);
                if ($('#product-details .field-group').length == 1) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Chú ý',
                        text: 'Đã đạt đến số lượng tối thiểu không thể xóa thêm!'
                    });
                }
            });
        }
    });
});



                    // xoa anh 
                    @if ($product->product_details->isNotEmpty())
                        @foreach ($product->product_details as $product_detail)
                            <
                            script >
                                $(document).ready(function() {
                                    $(".product-detail-{{ $product_detail->id }}-images").fileinput({
                                        theme: "explorer-fa",
                                        required: false,
                                        showUpload: false,
                                        showCaption: false,
                                        showClose: false,
                                        maxFileCount: 8,
                                        allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg', 'web', 'webp'],
                                        initialPreviewAsData: true,
                                        maxFileSize: 1000,
                                        overwriteInitial: false,
                                        removeFromPreviewOnError: true,
                                        deleteUrl: "{{ route('admin.products.delete_image') }}",
                                        ajaxDeleteSettings: {
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            }
                                        },
                                        @if ($product_detail->product_images->isNotEmpty())
                                            initialPreview: {!! json_encode(
                                                $product_detail->product_images->map(fn($image) => Helper::get_image_product_url($image->image_name)),
                                            ) !!},
                                            initialPreviewConfig: {!! json_encode(
                                                $product_detail->product_images->map(
                                                    fn($image) => [
                                                        'caption' => $image->image_name,
                                                        'key' => $image->id,
                                                    ],
                                                ),
                                            ) !!},
                                        @endif
                                    });
                                });
    </script>
    @endforeach
    @endif

    });

    </script>
@endsection
