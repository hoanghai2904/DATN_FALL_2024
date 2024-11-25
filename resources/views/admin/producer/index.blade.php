@extends('admin.layouts.master')
@section('title', 'Quản Lý Danh Mục')
@section('embed-css')
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection
@section('custom-css')

@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Quản Lý danh mục</li>
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
                                <a href="{{ route('admin.coupon.index') }}" class="btn btn-flat btn-primary" title="Refresh"
                                    style="margin-right: 5px;">
                                    <i class="fa fa-refresh"></i><span class="hidden-xs"> Refresh</span>
                                </a>
                                <a href="{{ route('admin.producer.new') }}" class="btn btn-success btn-flat"
                                    title="Thêm Mới">
                                    <i class="fa fa-plus" aria-hidden="true"></i><span class="hidden-xs"> Thêm Mới</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <table id="producer-table" class="table table-hover" style="width:100%; min-width: 768px;">
                        <thead>
                            <tr>
                                <th data-width="10px">ID</th>
                                <th data-orderable="false">Tên</th>
                                <th data-orderable="false" data-width="70px">Tác Vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($producers as $producer)
                                <tr>
                                    <td class="text-center">
                                        {{ $producer->id }}
                                    </td>
                                    <td>
                                        {{ $producer?->name }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.producer.edit', ['id' => $producer->id]) }}"
                                            class="btn btn-icon btn-sm btn-primary tip" title="Chỉnh Sửa">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                        <a href="javascript:void(0);" data-id="{{ $producer->id }}"
                                            class="btn btn-icon btn-sm btn-danger deleteDialog tip" title="Xóa"
                                            data-url="{{ route('admin.producer.delete') }}">
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
@endsection
@section('custom-js')

@endsection
