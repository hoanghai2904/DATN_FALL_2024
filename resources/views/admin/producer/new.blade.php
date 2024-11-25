@extends('admin.layouts.master')
@section('title', 'Tạo Danh Mục Mới')
@section('custom-css')
@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.producer.index') }}"><i class="fa fa-sliders" aria-hidden="true"></i> Quản Lý danh mục</a>
        </li>
        <li class="active">Tạo danh mục mới</li>
    </ol>
@endsection
@section('content')
    <form id="producer-form" action="{{ route('admin.producer.save') }}" method="POST" accept-charset="utf-8">
        @csrf
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Tên<span class="text-red">*</span></label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Tên"
                                value="{{ old('name') }}" autocomplete="off" required>
                            @error('name')
                                <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-flat pull-right"><i class="fa fa-floppy-o"
                                aria-hidden="true"></i> Lưu</button>
                        <a href="{{ route('admin.producer.index') }}" class="btn btn-danger btn-flat pull-right"
                            style="margin-right: 5px;"><i class="fa fa-ban" aria-hidden="true"></i> Hủy</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('embed-js')
    <script src="{{ asset('AdminLTE/bower_components/jquery-validate/jquery.validate.js') }}"></script>
@endsection
@section('custom-js')
    <script>
        $(document).ready(function() {
            $('#producer-form').validate({
                rules: {
                    name: {
                        required: true
                    },
                },
                messages: {
                    name: {
                        required: "Tên là bắt buộc."
                    },
                },
                errorPlacement: function(error, element) {
                    error.addClass('text-red');
                    error.insertAfter(element);
                }
            });
        });
    </script>
@endsection
