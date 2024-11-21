@extends('admin.layouts.master')

@section('title', 'Tạo Mã Giảm Giá Mới')

@section('embed-css')
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
@endsection

@section('custom-css')

@endsection

@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('admin.coupon.index') }}"><i class="fa fa-sliders" aria-hidden="true"></i> Quản Lý mã giảm giá</a></li>
  <li class="active">Tạo mã giảm giá mới</li>
</ol>
@endsection

@section('content')

@if ($errors->any())
  <div class="callout callout-danger">
    <h4>Warning!</h4>
    <ul style="margin-bottom: 0;">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('admin.advertise.save') }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
  @csrf
  <div class="box box-primary">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="name">Tên<span class="text-red">*</span></label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Tên" value="{{ old('name') }}" autocomplete="off" required>
          </div>
          <div class="form-group">
            <label for="description">Mô tả<span class="text-red">*</span></label>
            <textarea type="textarea" name="description" class="form-control" id="description" placeholder="Mô tả" value="{{ old('description') }}" autocomplete="off" required></textarea>
          </div>
          <div class="form-group">
            <label for="discount_percentage">Giảm giá (%)<span class="text-red">*</span></label>
            <input type="text" name="discount_percentage" class="form-control" id="discount_percentage" placeholder="Giảm giá (%)" required value="{{ old('discount_percentage') }}" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="max_discount_amount">Giảm tối đa (đ)<span class="text-red">*</span></label>
            <input type="text" name="max_discount_amount" class="form-control" id="max_discount_amount" placeholder="Giảm tối đa (đ)" required value="{{ old('max_discount_amount') }}" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="max_discount_amount">Đơn hàng tối thiểu (đ)</label>
            <input type="text" name="min_order_amount" class="form-control" id="min_order_amount" placeholder="Đơn hàng tối thiểu (đ)" value="{{ old('min_order_amount') }}" autocomplete="off">
          </div>
            <div class="col-md-7">
              <!-- Date range -->
              <div class="form-group">
                <label for="start_end_date">Ngày Bắt Đầu - Ngày Kết Thúc</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="start_end_date" name="start_end_date" autocomplete="off" value="{{ old('start_end_date') }}">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-success btn-flat pull-right"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</button>
            <a href="{{ route('admin.advertise.index') }}" class="btn btn-danger btn-flat pull-right" style="margin-right: 5px;"><i class="fa fa-ban" aria-hidden="true"></i> Hủy</a>
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
<script src="{{ asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
@endsection

@section('custom-js')
<script>
  $(document).ready(function(){
    //Date range picker
    $('#reservation').daterangepicker({
      autoApply: true,
      minDate: moment(),
      "locale": {
        "format": "DD/MM/YYYY",
      }
    });

    $("#upload").change(function() {
      $('.upload-image .image-preview').css('background-image', 'url("' + getImageURL(this) + '")');
    });
  });

  function getImageURL(input) {
    return URL.createObjectURL(input.files[0]);
  };
</script>
@endsection
