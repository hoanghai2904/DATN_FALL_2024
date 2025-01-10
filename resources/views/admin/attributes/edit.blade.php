@extends('admin.layouts.master')

@section('title', 'Chỉnh sửa thuộc tính ')

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

        @media (max-width: 768px) {
            .col-md-6 {
                width: 100%;
            }
        }

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
        <li class="active">Chỉnh sửa thuộc tính </li>
    </ol>
@endsection

@section('content')
    <form id="productForm" action="{{ route('admin.attributes.update', $attribute->id) }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
                            <input type="text" name="name" class="form-control" id="name" placeholder="Tên thuộc tính" required autocomplete="off" value="{{ old('name', $attribute->name) }}">
                            <span class="error" id="name-error"></span>
                        </div>
                    </div>
                    <!-- Giới thiệu Thêm Giá trị Thuộc Tính - Cột 2 -->
                    <div class="col-md-6">
                        <div class="box-body">
                            <div id="product-attributes">
                                @foreach($attribute->values as $index => $value)
                                <div class="field-group">
                                    <div class="box box-solid box-default" style="margin-bottom: 5px;">
                                        <div class="box-header">
                                            <h3 class="box-title">Giá trị thuộc tính</h3>
                                            <div class="box-tools">
                                                <button class="btn btn-box-tool delete-attribute" title="Remove"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group" style="margin-bottom: 0;">
                                                        <label for="attribute_{{ $index }}">Giá trị thuộc tính <span class="text-red">*</span></label>
                                                        <input type="text" name="values[{{ $index }}][value]" class="form-control attribute" id="attribute_{{ $index }}" placeholder="Giá trị" required autocomplete="off" value="{{ old('values.' . $index . '.value', $value->value) }}" data-id="{{ $value->id }}">
                            
                                                        <span class="error" id="attribute_{{ $index }}-error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            </div>
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

    <!-- Template cho việc thêm giá trị -->
    <div id="product-attributes-template" style="display:none;">
        <div class="field-group">
            <div class="box box-solid box-default" style="margin-bottom: 5px;">
                <div class="box-header">
                    <h3 class="box-title">Giá trị thuộc tính</h3>
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
    </div>
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
<script>
    $(document).ready(function() {
        let attributeIndex = {{ count($attribute->values) }};

        function addAttributeField() {
            const template = $('#product-attributes-template').html();
            const newField = template.replace(/{\?}/g, attributeIndex);
            $('#product-attributes').append(newField);
            attributeIndex++;
        }

        $('.add-attribute').on('click', function(e) {
            e.preventDefault();
            addAttributeField();
        });

        $(document).on('click', '.delete-attribute', function() {
            $(this).closest('.field-group').remove();
        });

        $('#productForm').on('submit', function(e) {
            e.preventDefault();

            $('.error').text('');

            const formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin.attributes.update', $attribute->id) }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: response.message || 'Thuộc tính đã được cập nhật thành công.',
                    }).then(function() {
                        window.location.href = "{{ route('admin.attributes.index') }}";
                    });
                },
                error: function(xhr) {
                    let errorMessage = 'Đã xảy ra lỗi. Vui lòng thử lại!';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;

                        for (let key in errors) {
                            if (key === 'name') {
                                $('#name-error').text(errors[key].join(', '));
                            } else if (key === 'values') {
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

    //valiudate from edit 
    document.addEventListener('DOMContentLoaded', function () {
    const attributeInputs = document.getElementById('product-attributes');
    attributeInputs.addEventListener('blur', function (e) {
        if (e.target && e.target.classList.contains('attribute')) {
            const currentValue = e.target.value.trim();
            const inputs = document.querySelectorAll('.attribute');
            const errorSpan = document.getElementById(`${e.target.id}-error`);

            // Kiểm tra trường hợp rỗng
            if (currentValue === '') {
                errorSpan.textContent = 'Trường này không được để trống. Vui lòng nhập giá trị.';
                errorSpan.style.color = 'red';
                return; // Kết thúc nếu rỗng
            }

            // Kiểm tra giá trị trùng lặp
            let duplicate = false;
            inputs.forEach(input => {
                if (input !== e.target && input.value.trim() === currentValue) {
                    duplicate = true;
                }
            });

            // Hiển thị lỗi nếu trùng lặp
            if (duplicate) {
                const initialValue = currentValue; // Lưu giá trị ban đầu
                errorSpan.textContent = `Giá trị "${initialValue}" đã tồn tại. Vui lòng nhập giá trị khác.`;
                errorSpan.style.color = 'red';

                // Xóa giá trị của ô input
                e.target.value = '';
            } else {
                // Xóa thông báo lỗi nếu không có lỗi
                errorSpan.textContent = '';
            }
        }
    }, true);
});
 
   
</script>
@endsection
