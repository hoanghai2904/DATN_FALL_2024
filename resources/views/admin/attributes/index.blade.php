@extends('admin.layouts.master')

@section('title', 'Quản Lý Thuộc Tính ')

@section('embed-css')
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('custom-css')
    <style>
        #post-table td,
        #post-table th {
            vertical-align: middle !important;
        }

        #post-table span.status-label {
            display: block;
            width: 85px;
            text-align: center;
            padding: 2px 0px;
        }

        #search-input span.input-group-addon {
            padding: 0;
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 34px;
            border: none;
            background: none;
        }

        #search-input span.input-group-addon i {
            font-size: 18px;
            line-height: 34px;
            width: 34px;
            color: #f30;
        }

        #search-input input {
            position: static;
            width: 100%;
            font-size: 15px;
            line-height: 22px;
            padding: 5px 5px 5px 34px;
            float: none;
            height: unset;
            border-color: #fbfbfb;
            box-shadow: none;
            background-color: #e8f0fe;
            border-radius: 5px;
        }
    </style>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Quản Lý Thuộc Tính </li>
    </ol>
@endsection

@section('content')

    <!-- Main row -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-5 col-sm-6 col-xs-6">
                            <div id="search-input" class="input-group">
                                <span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" placeholder="search...">
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-6 col-xs-6">
                            <div class="btn-group pull-right">
                                <a href="{{ route('admin.attributes.index') }}" class="btn btn-flat btn-primary"
                                    title="Refresh" style="margin-right: 5px;">
                                    <i class="fa fa-refresh"></i><span class="hidden-xs"> Refresh</span>
                                </a>
                                <a href="{{ route('admin.attributes.create') }}" class="btn btn-success btn-flat"
                                    title="New">
                                    <i class="fa fa-plus" aria-hidden="true"></i><span class="hidden-xs">Thêm thuộc tính
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <table id="post-table" class="table table-hover" style="width:100%; min-width: 768px;">
                        <thead>
                            <tr>
                                <th data-width="10px">ID</th>
                                <th data-orderable="false" data-width="100px">Tên thuộc tính</th>

                                <th data-width="60px" data-type="date-euro">Ngày Tạo</th>
                                <th data-orderable="false" data-width="70px" class="text-center">Tác Vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attributes as $attribute)
                                <tr>
                                    <td >
                                        {{ $attribute->id }}
                                    </td>
                                    <td>
                                        <a class="text-left" href="{{ route('post_page', ['id' => $attribute->id]) }}"
                                            title="{{ $attribute->title }}">{{ $attribute->name }}</a>
                                    </td>

                                    <td> {{ \Carbon\Carbon::parse($attribute->created_at)->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.attributes.edit', $attribute->id) }}"
                                            class="btn btn-icon btn-sm btn-primary tip" title="Chỉnh Sửa">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                        <a href="javascript:void(0);" data-id="{{ $attribute->id }}"
                                            class="btn btn-icon btn-sm btn-danger deleteDialog tip" title="Xóa"
                                            data-url="{{ route('admin.attributes.destroy', $attribute->id) }}">
                                            <i class="fa fa-trash"></i>
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection

@section('embed-js')
    <!-- DataTables -->
    <script src="{{ asset('AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('AdminLTE/bower_components/fastclick/lib/fastclick.js') }}"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.20/sorting/date-euro.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('custom-js')
    <script>
        $(function() {
            var table = $('#post-table').DataTable({
                "language": {
                    "zeroRecords": "Không tìm thấy kết quả phù hợp",
                    "info": "Hiển thị trang <b>_PAGE_/_PAGES_</b> của <b>_TOTAL_</b> bài viết",
                    "infoEmpty": "Hiển thị trang <b>1/1</b> của <b>0</b> bài viết",
                    "infoFiltered": "(Tìm kiếm từ <b>_MAX_</b> bài viết)",
                    "emptyTable": "Không có dữ liệu bài viết",
                },
                "lengthChange": false,
                "autoWidth": false,
                "order": [],
                "dom": '<"table-responsive"t><<"row"<"col-md-6 col-sm-6"i><"col-md-6 col-sm-6"p>>>',
                "drawCallback": function(settings) {
                    var api = this.api();
                    if (api.page.info().pages <= 1) {
                        $('#' + $(this).attr('id') + '_paginate').hide();
                    }
                }
            });

            $('#search-input input').on('keyup', function() {
                table.search(this.value).draw();
            });
        });


        //delete attributes
        $(document).on('click', '.deleteDialog', function () {
    var attributeId = $(this).data('id');
    var url = $(this).data('url');

    // Hiển thị hộp thoại xác nhận bằng SweetAlert
    Swal.fire({
        title: 'Bạn có chắc chắn muốn xóa thuộc tính này?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,  // Sử dụng URL từ thuộc tính data-url
                type: 'DELETE',  // Phương thức DELETE
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),  // CSRF Token
                },
                success: function (response) {
                    if (response.status === 'success') {
                        // Thông báo thành công bằng SweetAlert
                        Swal.fire(
                            'Thành công!',
                            response.message,
                            'success'
                        ).then(() => {
                            // Reload lại trang sau khi xóa
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Lỗi!',
                            response.message || 'Có lỗi xảy ra khi xóa thuộc tính.',
                            'error'
                        );
                    }
                },
                error: function (xhr) {
                    Swal.fire(
                        'Lỗi!',
                        'Có lỗi xảy ra! Vui lòng thử lại.',
                        'error'
                    );
                }
            });
        }
    });
});


    </script>
@endsection
