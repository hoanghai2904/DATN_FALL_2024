@extends('admin.layouts.master')

@section('title', 'Thêm thuộc tính ')

@section('embed-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.6/css/fileinput.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.6/themes/explorer-fa/theme.css" rel="stylesheet">
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

        /* Điều chỉnh để các cột không bị lệch khi hiển thị trên các màn hình nhỏ */
        @media (max-width: 768px) {
            .col-md-6 {
                width: 100%;
            }
        }

        /* Các phần tử form sẽ có khoảng cách hợp lý */
        .form-group {
            margin-bottom: 15px;
        }

        .box-body {
            padding: 15px;
        }
    </style>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.attributes.index') }}"><i class="fa fa-product-hunt" aria-hidden="true"></i> Quản Lý Thuộc Tính </a></li>
        <li class="active">Thêm thuộc tính </li>
    </ol>
@endsection

@section('content')
    <form id="productForm" action="{{ route('admin.attributes.store') }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
        @csrf
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Tên Thuộc Tính <span class="text-red">*</span></label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Tên thuộc tính " required autocomplete="off">
                            <span class="error" id="name-error"></span>
                        </div>
                    </div>
                    <!-- Giới thiệu Thêm Giá trị Thuộc Tính - Cột 2 -->
                    <div class="col-md-6">
                        <div class="box-body">
                            <div id="product-attributes"></div>
                            <div class="text-center">
                                <button class="add-attribute btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Thêm Giá Trị</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-solid">
            <div class="box-body">
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-flat pull-right"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</button>
                    <a href="{{ route('admin.attributes.index') }}" class="btn btn-danger btn-flat pull-right" style="margin-right: 5px;"><i class="fa fa-ban" aria-hidden="true"></i> Hủy</a>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('embed-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.0.15/tinymce.min.js"></script>
    <script src="{{ asset('AdminLTE/bower_components/jquery.repeatable.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.6/js/fileinput.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.6/themes/explorer-fa/theme.js"></script>
    <script src="{{ asset('AdminLTE/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('AdminLTE/bower_components/autoNumeric.js') }}"></script>
    <script src="{{ asset('AdminLTE/bower_components/jquery-validate/jquery.validate.js') }}"></script>
@endsection

@section('custom-js')
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
                            <input type="text" name="values[{?}][value]" class="form-control attribute" id="attribute_{?}" placeholder="Giá trị" required autocomplete="off">
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
        let attributeIndex = 0;

        function addAttributeField() {
            const template = $('#product-attributes-template').html();
            const newField = template.replace(/{\?}/g, attributeIndex);
            $('#product-attributes').append(newField);
            attributeIndex++;
        }

        addAttributeField();

        $('.add-attribute').on('click', function(e) {
            e.preventDefault();
            addAttributeField();
        });

        $(document).on('click', '.delete-attribute', function() {
            $(this).closest('.field-group').remove();
        });

        $('#productForm').on('submit', function(e) {
            e.preventDefault();

            // Reset lỗi cũ trước khi gửi form
            $('.error').text('');

            const formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin.attributes.store') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: response.message || 'Thuộc tính đã được thêm thành công.',
                    }).then(function() {
                        window.location.href = "{{ route('admin.attributes.index') }}";
                    });
                },
                error: function(xhr) {
                    let errorMessage = 'Đã xảy ra lỗi. Vui lòng thử lại!';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;

                        // Duyệt qua các lỗi và hiển thị vào các ô input tương ứng
                        for (let key in errors) {
                            if (key === 'name') {
                                // Hiển thị lỗi cho trường name
                                $('#name-error').text(errors[key].join(', '));
                            } else if (key === 'values') {
                                // Lặp qua các giá trị thuộc tính
                                errors[key].forEach((errorMessage, index) => {
                                    $('#attribute_' + index + '-error').text(errorMessage);
                                });
                            }
                        }
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        html: errorMessage,
                    });
                }
            });
        });
    });

    $(document).on('input', 'input[name^="values"][name$="[value]"]', function () {
    // Lấy giá trị người dùng nhập vào trong ô input
    var inputValue = $(this).val();
    
    // Cập nhật giá trị vào <h3 class="box-title"> trong phần tử box
    $(this).closest('.box').find('.box-title').text(inputValue);
});
</script>
@endsection
