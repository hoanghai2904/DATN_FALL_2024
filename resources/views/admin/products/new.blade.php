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

    <form id="productForm" action="{{ route('admin.product.save') }}" method="POST" accept-charset="utf-8"
        enctype="multipart/form-data">
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
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Thông Tin thuộcthuộc</h3>
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
                        tin </button>
                </div>
            </div>
        </div>
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
@section('custom-js')
<script>
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
</script>
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