@extends('admin.layouts.master')

@section('title', 'Đơn Hàng Đang Xử Lý')

@section('embed-css')
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

@endsection

@section('custom-css')
    <style>
        #confirmed td,
        #confirmed th,
        #preOrder td,
        #preOrder th,
        #returnOrders td,
        #returnOrders th,
        #cancelOrders td,
        #cancelOrders th {
            vertical-align: middle !important;
        }

        #confirmed span.status-label,
        #preOrder span.status-label,
        #returnOrders span.status-label,
        #cancelOrders span.status-label{
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

        .custom-dropdown-menu {
            min-width: 80px;
            max-width: 100px;
            overflow-wrap: break-word;
            white-space: normal;
        }
    </style>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Đơn Hàng Đang Xử Lý</li>
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
                                <a href="{{ route('admin.order.processing') }}" class="btn btn-flat btn-primary"
                                    title="Refresh">
                                    <i class="fa fa-refresh"></i><span class="hidden-xs"> Refresh</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#confirmed-orders" aria-controls="confirmed-orders " role="tab" data-toggle="tab">Đã
                            Xác Nhận</a>
                    </li>
                    <li role="presentation">
                        <a href="#pre-orders" aria-controls="pre-orders" role="tab" data-toggle="tab">Đang Chuẩn Bị</a>
                    </li>
                    <li role="presentation">
                        <a href="#return-orders" aria-controls="return-orders" role="tab" data-toggle="tab">Hoàn
                            Hàng</a>
                    </li>
                    <li role="presentation">
                        <a href="#cancel-orders" aria-controls="cancel-orders" role="tab" data-toggle="tab">Hủy
                            Hàng</a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- Đơn hàng xác nhận-->
                    <div role="tabpanel" class="tab-pane active" id="confirmed-orders">
                        <div class="box-body">
                            <table id="confirmed" class="table table-hover" style="width:100%; min-width: 1024px;">
                                <thead>
                                    <tr>
                                        <th data-width="10px">ID</th>
                                        <th data-orderable="false" data-width="85px">Mã Đơn Hàng</th>
                                        <th data-orderable="false" data-width="100px">Tài Khoản</th>
                                        <th data-orderable="false" data-width="100px">Tên</th>
                                        <th data-orderable="false">Email</th>
                                        <th data-orderable="false" data-width="70px">Điện Thoại</th>
                                        <th data-orderable="false">Phương Thức Thanh Toán</th>
                                        <th class="sort">Trạng thái thanh toán</th>
                                        <th data-width="60px" data-type="date-euro">Ngày đặt hàng</th>
                                        <th data-width="66px">Trạng thái đơn hàng</th>
                                        <th data-orderable="false" data-width="130px">Tác Vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="text-center">{{ $order->id }}</td>
                                            <td>{{ '#' . $order->order_code }}</td>
                                            <td>
                                                @if ($order->user)
                                                    <a href="{{ route('admin.user_show', ['id' => $order->user->id]) }}"
                                                        class="text-left"
                                                        title="{{ $order->user->name }}">{{ $order->user->name }}</a>
                                                @else
                                                    <span>---</span>
                                                @endif
                                            </td>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->email }}</td>
                                            <td>{{ $order->phone }}</td>
                                            <td>{{ $order->payment_method?->name }}</td>
                                            <td>
                                                @if ($order?->is_paid)
                                                    <span class="label label-success">Đã thanh toán</span>
                                                @else
                                                    <span class="label label-danger">Chưa thanh toán</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</td>
                                            <td>
                                                @php
                                                    $statusLabels = [
                                                        1 => ['label' => 'label-warning', 'text' => 'Chờ xác nhận'],
                                                        2 => ['label' => 'label-info', 'text' => 'Xác nhận'],
                                                        3 => ['label' => 'label-primary', 'text' => 'Đang chuẩn bị'],
                                                        4 => ['label' => 'label-info', 'text' => 'Đang Vận Chuyển'],
                                                        5 => ['label' => 'label-success', 'text' => 'Đã Giao Hàng'],
                                                        6 => [
                                                            'label' => 'label-success',
                                                            'text' => 'Đơn hàng thành công',
                                                        ],
                                                        7 => [
                                                            'label' => 'label-danger',
                                                            'text' => 'Giao hàng thất bại',
                                                        ],
                                                        8 => ['label' => 'label-danger', 'text' => 'Hủy'],
                                                    ];
                                                @endphp
                                                @if (isset($statusLabels[$order->status]))
                                                    <span class="label {{ $statusLabels[$order->status]['label'] }}"
                                                        style="font-size:13px; display: inline-block; width: 100%">
                                                        {{ $statusLabels[$order->status]['text'] }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.order.show', ['id' => $order->id]) }}"
                                                    class="btn btn-icon btn-sm btn-primary tip" title="Chi Tiết">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                                @if ($order->status === 1 || $order->status === 2 || $order->status === 3)
                                                    <div class="btn-group">
                                                        <button type="button" style="height: 30px;"
                                                            class="btn btn-success btn-xs dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded='true'>
                                                            Thao tác
                                                            <span class="caret"></span>
                                                            <span class="sr-only">Toggle-dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu custom-dropdown-menu" role="menu">
                                                            @if (
                                                                ($order->status === 1 && $order->payment_method_id == 1) ||
                                                                    ($order->status === 1 && $order->payment_method_id == 2 && $order->is_paid))
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['confirmed', $order->id]) }}">Xác
                                                                        nhận</a>
                                                                </li>
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['cancel', $order->id]) }}">Hủy</a>
                                                                </li>
                                                            @endif

                                                            @if ($order->status === 2)
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['preparing', $order->id]) }}">Chuẩn
                                                                        bị</a>
                                                                </li>
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['cancel', $order->id]) }}">Hủy</a>
                                                                </li>
                                                            @endif

                                                            @if ($order->status === 3)
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['delivering', $order->id]) }}">Giao
                                                                        Hàng</a>
                                                                </li>
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['cancel', $order->id]) }}">Hủy</a>
                                                                </li>
                                                            @endif

                                                            @if ($order->status === 4)
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['delivered', $order->id]) }}">Đã
                                                                        Giao Hàng</a>
                                                                </li>
                                                            @endif

                                                            @if ($order->status === 5)
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['completed', $order->id]) }}">Đơn
                                                                        hàng thành công</a>
                                                                </li>
                                                            @endif

                                                        </ul>

                                                    </div>
                                                @else
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Đơn Hàng chuẩn bị -->
                    <div role="tabpanel" class="tab-pane" id="pre-orders">
                        <div class="box-body">
                            <table id="preOrder" class="table table-hover" style="width:100%; min-width: 1024px;">
                                <thead>
                                    <tr>
                                        <th data-width="10px">ID</th>
                                        <th data-orderable="false" data-width="85px">Mã Đơn Hàng</th>
                                        <th data-orderable="false" data-width="100px">Tài Khoản</th>
                                        <th data-orderable="false" data-width="100px">Tên</th>
                                        <th data-orderable="false">Email</th>
                                        <th data-orderable="false" data-width="70px">Điện Thoại</th>
                                        <th data-orderable="false">Phương Thức Thanh Toán</th>
                                        <th class="sort">Trạng thái thanh toán</th>
                                        <th data-width="60px" data-type="date-euro">Ngày đặt hàng</th>
                                        <th data-width="66px">Trạng thái đơn hàng</th>
                                        <th data-orderable="false" data-width="130px">Tác Vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($preOrders as $order)
                                        <tr>
                                            <td class="text-center">{{ $order->id }}</td>
                                            <td>{{ '#' . $order->order_code }}</td>
                                            <td>
                                                @if ($order->user)
                                                    <a href="{{ route('admin.user_show', ['id' => $order->user->id]) }}"
                                                        class="text-left"
                                                        title="{{ $order->user->name }}">{{ $order->user->name }}</a>
                                                @else
                                                    <span>---</span>
                                                @endif
                                            </td>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->email }}</td>
                                            <td>{{ $order->phone }}</td>
                                            <td>{{ $order->payment_method?->name }}</td>
                                            <td>
                                                @if ($order?->is_paid)
                                                    <span class="label label-success">Đã thanh toán</span>
                                                @else
                                                    <span class="label label-danger">Chưa thanh toán</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</td>
                                            <td>
                                                @php
                                                    $statusLabels = [
                                                        1 => ['label' => 'label-warning', 'text' => 'Chờ xác nhận'],
                                                        2 => ['label' => 'label-info', 'text' => 'Xác nhận'],
                                                        3 => ['label' => 'label-primary', 'text' => 'Đang chuẩn bị'],
                                                        4 => ['label' => 'label-info', 'text' => 'Đang Vận Chuyển'],
                                                        5 => ['label' => 'label-success', 'text' => 'Đã Giao Hàng'],
                                                        6 => [
                                                            'label' => 'label-success',
                                                            'text' => 'Đơn hàng thành công',
                                                        ],
                                                        7 => [
                                                            'label' => 'label-danger',
                                                            'text' => 'Giao hàng thất bại',
                                                        ],
                                                        8 => ['label' => 'label-danger', 'text' => 'Hủy'],
                                                    ];
                                                @endphp
                                                @if (isset($statusLabels[$order->status]))
                                                    <span class="label {{ $statusLabels[$order->status]['label'] }}"
                                                        style="font-size:13px; display: inline-block; width: 100%">
                                                        {{ $statusLabels[$order->status]['text'] }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.order.show', ['id' => $order->id]) }}"
                                                    class="btn btn-icon btn-sm btn-primary tip" title="Chi Tiết">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                                @if ($order->status === 1 || $order->status === 2 || $order->status === 3)
                                                    <div class="btn-group">
                                                        <button type="button" style="height: 30px;"
                                                            class="btn btn-success btn-xs dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded='true'>
                                                            Thao tác
                                                            <span class="caret"></span>
                                                            <span class="sr-only">Toggle-dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu custom-dropdown-menu" role="menu">
                                                            @if ($order->status === 3)
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['delivering', $order->id]) }}">Giao
                                                                        Hàng</a>
                                                                </li>
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['cancel', $order->id]) }}">Hủy</a>
                                                                </li>
                                                            @endif

                                                        </ul>

                                                    </div>
                                                @else
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Đơn Hoàn Hàng -->
                    <div role="tabpanel" class="tab-pane" id="return-orders">
                        <div class="box-body">
                            <table id="returnOrders" class="table table-hover" style="width:100%; min-width: 1024px;">
                                <thead>
                                    <tr>
                                        <th data-width="10px">ID</th>
                                        <th data-orderable="false" data-width="85px">Mã Đơn Hàng</th>
                                        <th data-orderable="false">Tài Khoản</th>
                                        <th data-orderable="false">Tên</th>
                                        <th data-orderable="false">Email</th>
                                        <th data-orderable="false" data-width="70px">Điện Thoại</th>
                                        <th data-orderable="false">Phương Thức Thanh Toán</th>
                                        <th class="sort">Trạng thái thanh toán</th>
                                        <th data-width="100px" data-type="date-euro">Ngày đặt hàng</th>
                                        <th data-width="66px">Lý do hoàn hàng</th>
                                        <th data-width="66px">Trạng thái</th>
                                        <?php if ($order->status == 9): ?>
                                        <th data-orderable="false" data-width="130px">Tác Vụ</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($returnOrders as $order)
                                        <tr>
                                            <td class="text-center">{{ $order->id }}</td>
                                            <td><a
                                                    href="{{ route('admin.order.show', ['id' => $order->id]) }}">{{ '#' . $order->order_code }}</a>
                                            </td>
                                            <td>
                                                @if ($order->user)
                                                    <a href="{{ route('admin.user_show', ['id' => $order->user->id]) }}"
                                                        class="text-left"
                                                        title="{{ $order->user->name }}">{{ $order->user->name }}</a>
                                                @else
                                                    <span>---</span>
                                                @endif
                                            </td>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->email }}</td>
                                            <td>{{ $order->phone }}</td>
                                            <td>{{ $order->payment_method?->name }}</td>
                                            <td>
                                                @if ($order?->is_paid)
                                                    <span class="label label-success">Đã thanh toán</span>
                                                @else
                                                    <span class="label label-danger">Chưa thanh toán</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</td>
                                            
                                            <td style="display: flex; align-items: center;justify-content: space-between">
                                                <span class="truncated-text" title="{{ $order->return_reason }}">
                                                    {{ strlen($order->return_reason) > 20 ? substr($order->return_reason, 0, 7) . '...' : $order->return_reason }}
                                                </span>
                                                <a href="javascript:void(0);" class="btn btn-icon btn-sm tip" title="Chi Tiết" data-toggle="modal" data-target="#returnReasonModal" data-reason="{{ $order->return_reason }}">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                            
                                            <!-- Modal to show full reason -->
                                            <div class="modal fade" id="returnReasonModal" tabindex="-1" role="dialog" aria-labelledby="returnReasonModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title" id="returnReasonModalLabel">Lý Do Hoàn Hàng</h4>
                                                        </div>
                                                        <div class="modal-body" id="modalReturnReason">
                                                            <!-- Full return reason will be displayed here -->
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <td>
                                                @php
                                                    $statusLabels = [
                                                        9 => ['label' => 'label-info', 'text' => 'Đang xác nhận'],
                                                        10 => ['label' => 'label-primary', 'text' => 'Đã hoàn'],
                                                        11 => ['label' => 'label-danger', 'text' => 'Từ chối'],

                                                    ];
                                                @endphp
                                                @if (isset($statusLabels[$order->status]))
                                                    <span class="label {{ $statusLabels[$order->status]['label'] }}"
                                                        style="font-size:13px; display: inline-block; width: 100%">
                                                        {{ $statusLabels[$order->status]['text'] }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>

                                                @if ($order->status === 9)
                                                    <div class="btn-group">
                                                        <button type="button" style="height: 30px;"
                                                            class="btn btn-success btn-xs dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded='true'>
                                                            Thao tác
                                                            <span class="caret"></span>
                                                            <span class="sr-only">Toggle-dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu custom-dropdown-menu" role="menu">
                                                            @if ($order->status === 9)
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['returned', $order->id]) }}">Xác
                                                                        nhận</a>
                                                                </li>
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['cancelReturn', $order->id]) }}">Hủy</a>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Đơn Hủy Hàng -->
                    <div role="tabpanel" class="tab-pane" id="cancel-orders">
                        <div class="box-body">
                            <table id="cancelOrders" class="table table-hover" style="width:100%; min-width: 1024px;">
                                <thead>
                                    <tr>
                                        <th data-width="10px">ID</th>
                                        <th data-orderable="false" data-width="85px">Mã Đơn Hàng</th>
                                        <th data-orderable="false">Tài Khoản</th>
                                        <th data-orderable="false">Tên</th>
                                        <th data-orderable="false">Email</th>
                                        <th data-orderable="false" data-width="70px">Điện Thoại</th>
                                        <th data-orderable="false">Phương Thức Thanh Toán</th>
                                        <th class="sort">Trạng thái thanh toán</th>
                                        <th data-width="100px" data-type="date-euro">Ngày đặt hàng</th>
                                        <th data-width="66px">Lý do hoàn hàng</th>
                                        <th data-width="66px">Trạng thái</th>
                                        <?php if ($order->status == 12): ?>
                                        <th data-orderable="false" data-width="130px">Tác Vụ</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cancelOrders as $order)
                                        <tr>
                                            <td class="text-center">{{ $order->id }}</td>
                                            <td><a
                                                    href="{{ route('admin.order.show', ['id' => $order->id]) }}">{{ '#' . $order->order_code }}</a>
                                            </td>
                                            <td>
                                                @if ($order->user)
                                                    <a href="{{ route('admin.user_show', ['id' => $order->user->id]) }}"
                                                        class="text-left"
                                                        title="{{ $order->user->name }}">{{ $order->user->name }}</a>
                                                @else
                                                    <span>---</span>
                                                @endif
                                            </td>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->email }}</td>
                                            <td>{{ $order->phone }}</td>
                                            <td>{{ $order->payment_method?->name }}</td>
                                            <td>
                                                @if ($order?->is_paid)
                                                    <span class="label label-success">Đã thanh toán</span>
                                                @else
                                                    <span class="label label-danger">Chưa thanh toán</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</td>
                                            
                                            <td style="display: flex; align-items: center;justify-content: space-between">
                                                <span class="truncated-text" title="{{ $order->cancel_reason }}">
                                                    {{ strlen($order->cancel_reason) > 20 ? substr($order->cancel_reason, 0, 7) . '...' : $order->cancel_reason }}
                                                </span>
                                                <a href="javascript:void(0);" class="btn btn-icon btn-sm tip" title="Chi Tiết" data-toggle="modal" data-target="#cancelReasonModal" data-reason="{{ $order->cancel_reason }}">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                            
                                            <!-- Modal to show full reason -->
                                            <div class="modal fade" id="cancelReasonModal" tabindex="-1" role="dialog" aria-labelledby="cancelReasonModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title" id="cancelReasonModalLabel">Lý Do Hoàn Hàng</h4>
                                                        </div>
                                                        <div class="modal-body" id="modalCancelReason">
                                                            <!-- Full return reason will be displayed here -->
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <td>
                                                @php
                                                    $statusLabels = [
                                                        12 => ['label' => 'label-info', 'text' => 'Đang xác nhận'],
                                                        8 => ['label' => 'label-primary', 'text' => 'Đã hủy'],
                                                        13 => ['label' => 'label-danger', 'text' => 'Từ chối'],

                                                    ];
                                                @endphp
                                                @if (isset($statusLabels[$order->status]))
                                                    <span class="label {{ $statusLabels[$order->status]['label'] }}"
                                                        style="font-size:13px; display: inline-block; width: 100%">
                                                        {{ $statusLabels[$order->status]['text'] }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>

                                                @if ($order->status === 12)
                                                    <div class="btn-group">
                                                        <button type="button" style="height: 30px;"
                                                            class="btn btn-success btn-xs dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded='true'>
                                                            Thao tác
                                                            <span class="caret"></span>
                                                            <span class="sr-only">Toggle-dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu custom-dropdown-menu" role="menu">
                                                            @if ($order->status === 12)
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['cancel', $order->id]) }}">Xác
                                                                        nhận</a>
                                                                </li>
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['cancelReturn', $order->id]) }}">Hủy</a>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

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
    <script>
        // When the eye icon is clicked, load the full return reason into the modal
        $('#returnReasonModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var reason = button.data('reason'); // Extract the reason from the data-* attribute
            var modal = $(this);
            modal.find('#modalReturnReason').text(reason); // Display the full reason in the modal
        });
        $('#cancelReasonModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var reason = button.data('reason'); // Extract the reason from the data-* attribute
            var modal = $(this);
            modal.find('#modalCancelReason').text(reason); // Display the full reason in the modal
        });
    </script>
    <script>
        $(function() {
            var tableConfirmed = $('#confirmed').DataTable({
                "language": {
                    "zeroRecords": "Không tìm thấy kết quả phù hợp",
                    "info": "Hiển thị trang <b>_PAGE_/_PAGES_</b> của <b>_TOTAL_</b> đơn hàng",
                    "infoEmpty": "Hiển thị trang <b>1/1</b> của <b>0</b> đơn hàng",
                    "infoFiltered": "(Tìm kiếm từ <b>_MAX_</b> đơn hàng)",
                    "emptyTable": "Không có dữ liệu đơn hàng",
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

            var tablePreOrder = $('#preOrder').DataTable({
                "language": {
                    "zeroRecords": "Không tìm thấy kết quả phù hợp",
                    "info": "Hiển thị trang <b>_PAGE_/_PAGES_</b> của <b>_TOTAL_</b> đơn hàng",
                    "infoEmpty": "Hiển thị trang <b>1/1</b> của <b>0</b> đơn hàng",
                    "infoFiltered": "(Tìm kiếm từ <b>_MAX_</b> đơn hàng)",
                    "emptyTable": "Không có dữ liệu đơn hàng",
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
            var returnOrder = $('#returnOrders').DataTable({
                "language": {
                    "zeroRecords": "Không tìm thấy kết quả phù hợp",
                    "info": "Hiển thị trang <b>_PAGE_/_PAGES_</b> của <b>_TOTAL_</b> đơn hàng",
                    "infoEmpty": "Hiển thị trang <b>1/1</b> của <b>0</b> đơn hàng",
                    "infoFiltered": "(Tìm kiếm từ <b>_MAX_</b> đơn hàng)",
                    "emptyTable": "Không có dữ liệu đơn hàng",
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
                tableConfirmed.search(this.value).draw();
                tablePreOrder.search(this.value).draw();
                returnOrder.search(this.value).draw();
            });
        });
    </script>

@endsection
