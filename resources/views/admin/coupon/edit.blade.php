@extends('admin.layouts.master')

@section('title', 'Chỉnh Sửa Mã Giảm Giá')

@section('embed-css')
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
@endsection

@section('custom-css')

@endsection

@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('admin.coupon.index') }}"><i class="fa fa-sliders" aria-hidden="true"></i> Quản Lý Mã Giảm Giá</a></li>
  <li class="active">Chỉnh Sửa Mã Giảm Giá</li>
</ol>
@endsection

@section('content')
<form id="coupon-form" action="{{ route('admin.coupon.update', ['id' => $coupon?->id]) }}" method="POST" accept-charset="utf-8">
  @csrf
  <div class="box box-primary">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="name">Tên <span class="text-red">*</span></label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Tên" value="{{ old('name') ?: $coupon?->name }}" autocomplete="off">
            @error('name')
              <span class="text-red">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="code">Mã<span class="text-red">*</span></label>
            <input type="text" name="code" class="form-control" id="code" placeholder="Mã" value="{{ old('code') ?: $coupon?->code }}" autocomplete="off" required>
            @error('code')
              <span class="text-red">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="description">Mô tả<span class="text-red">*</span></label>
            <textarea type="textarea" name="description" class="form-control" id="description" placeholder="Mô tả" value="{{ old('description') ?: $coupon?->description }}" autocomplete="off" required>{{ old('description') ?: $coupon?->description }}</textarea>
            @error('description')
              <span class="text-red">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="discount_percentage">Giảm giá (%)<span class="text-red">*</span></label>
            <input type="text" name="discount_percentage" class="form-control" id="discount_percentage" placeholder="Giảm giá (%)" required value="{{ old('discount_percentage') ?: $coupon?->discount_percentage }}" autocomplete="off">
            @error('discount_percentage')
              <span class="text-red">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="max_discount_amount">Giảm tối đa (đ)<span class="text-red">*</span></label>
            <input type="text" name="max_discount_amount" class="form-control" id="max_discount_amount" placeholder="Giảm tối đa (đ)" required value="{{ old('max_discount_amount') ?: $coupon?->max_discount_amount }}" autocomplete="off">
            @error('max_discount_amount')
              <span class="text-red">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="min_order_amount">Đơn hàng tối thiểu (đ)</label>
            <input type="text" name="min_order_amount" class="form-control" id="min_order_amount" placeholder="Đơn hàng tối thiểu (đ)" value="{{ old('min_order_amount') ?: $coupon?->min_order_amount }}" autocomplete="off">
            @error('min_order_amount')
              <span class="text-red">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
              <label for="start_end_date">Ngày Bắt Đầu - Ngày Kết Thúc</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="start_end_date" name="start_end_date" autocomplete="off" value="{{ old('start_end_date') ?: date_format(date_create($coupon?->start_date), 'd/m/Y').' - '.date_format(date_create($coupon?->end_date), 'd/m/Y') }}">
              </div>
              @error('start_end_date')
                <span class="text-red">{{ $message }}</span>
              @enderror
              <!-- /.input group -->
            </div>
          <div class="form-group">
            <button type="submit" class="btn btn-success btn-flat pull-right"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</button>
            <a href="{{ route('admin.coupon.index') }}" class="btn btn-danger btn-flat pull-right" style="margin-right: 5px;"><i class="fa fa-ban" aria-hidden="true"></i> Hủy</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@section('embed-js')

<!-- date-range-picker -->
<script src="{{ asset('AdminLTE/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('AdminLTE/bower_components/jquery-validate/jquery.validate.js') }}"></script>
<script src="{{ asset('AdminLTE/bower_components/autoNumeric.js') }}"></script>
<script src="{{ asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
@endsection

@section('custom-js')
<script>
  $(document).ready(function(){
    //Date range picker
    $('#start_end_date').daterangepicker({
      autoApply: true,
      minDate: "{{ date_format(date_create($coupon?->start_date), 'd/m/Y') }}",
      "locale": {
        "format": "DD/MM/YYYY",
      }
    });

    $('input#max_discount_amount').autoNumeric('init', {
      aSep: '.',
      aDec: ',',
      aPad: false,
      lZero: 'deny',
      vMin: '0'
    });

  // Initialize autoNumeric for min_order_amount
    $('input#min_order_amount').autoNumeric('init', {
      aSep: '.',
      aDec: ',',
      aPad: false,
      lZero: 'deny',
      vMin: '0'
    });

  // Initialize autoNumeric for discount_percentage
    $('input#discount_percentage').autoNumeric('init', {
      aSep: '.',
      aDec: ',',
      aPad: false,
      lZero: 'deny',
      vMin: '0',
      vMax: '100'
    });
    $('#coupon-form').validate({
      rules: {
        name: {
          required: true
        },
        code: {
          required: true
        },
        description: {
          required: true
        },
        discount_percentage: {
          required: true,
        },
        max_discount_amount: {
          required: true,
          min: 0
        },
        min_order_amount: {
          min: 0
        },
        start_end_date: {
          required: false
        }
      },
      messages: {
        name: {
          required: "Tên là bắt buộc."
        },
        code: {
          required: "Mã là bắt buộc."
        },
        description: {
          required: "Mô tả là bắt buộc."
        },
        discount_percentage: {
          required: "Giảm giá (%) là bắt buộc.",
          number: "Giảm giá (%) phải là số.",
          min: "Giảm giá (%) phải lớn hơn hoặc bằng 0.",
          max: "Giảm giá (%) phải nhỏ hơn hoặc bằng 100."
        },
        max_discount_amount: {
          required: "Giảm tối đa (đ) là bắt buộc.",
          number: "Giảm tối đa (đ) phải là số.",
          min: "Giảm tối đa (đ) phải lớn hơn hoặc bằng 0."
        },
        min_order_amount: {
          number: "Đơn hàng tối thiểu (đ) phải là số.",
          min: "Đơn hàng tối thiểu (đ) phải lớn hơn hoặc bằng 0."
        }
      },
      errorPlacement: function(error, element) {
        error.addClass('text-red');
        error.insertAfter(element);
      }
    });
  });
</script>
@endsection
