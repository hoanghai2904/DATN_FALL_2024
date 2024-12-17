@extends('admin.layouts.master')

@section('title', 'Đơn Hàng Đang Xử Lý')

@section('embed-css')
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

@endsection

@section('custom-css')
    <style>
        #delivering td,
        #delivering th,
        #delivered td,
        #delivered th ,
        #completed td,
        #completed th,
        #failed td,
        #failed th ,
        #cancelled td,
        #cancelled th
        {
            vertical-align: middle !important;
        }

        #delivering span.status-label,
        #delivered span.status-label,
        #completed span.status-label,
        #failed span.status-label,
        #cancelled span.status-label
        {
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
            min-width: 80px; /* Đảm bảo menu không nhỏ hơn 50px */
            max-width: 100px; /* Giới hạn chiều rộng tối đa */
            overflow-wrap: break-word; /* Tự động xuống dòng nếu nội dung dài */
            white-space: normal; /* Cho phép xuống dòng */
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
                                <a href="{{ route('admin.order.completed') }}" class="btn btn-flat btn-primary" title="Refresh">
                                    <i class="fa fa-refresh"></i><span class="hidden-xs"> Refresh</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#delivering-orders" aria-controls="delivering-orders " role="tab" data-toggle="tab">Đang Giao</a>
                    </li>
                    {{-- <li role="presentation">
                        <a href="#delivered-orders" aria-controls="delivered-orders" role="tab" data-toggle="tab">Đã Giao</a>
                    </li> --}}
                    <li role="presentation">
                        <a href="#completed-orders" aria-controls="completed-orders" role="tab" data-toggle="tab">Thành Công</a>
                    </li>
                    <li role="presentation">
                        <a href="#failed-orders" aria-controls="failed-orders" role="tab" data-toggle="tab">Thất Bại</a>
                    </li>
                    <li role="presentation">
                        <a href="#cancelled-orders" aria-controls="cancelled-orders" role="tab" data-toggle="tab">Đã Hủy</a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- Đơn hàng xác nhận-->
                    <div role="tabpanel" class="tab-pane active" id="delivering-orders">
                        <div class="box-body">
                            <table id="delivering" class="table table-hover" style="width:100%; min-width: 1024px;">
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
                                    @foreach ($deliveringOrders as $order)
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
                                                            class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown"
                                                            aria-expanded='true'>
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
                                                                        href="{{ route('admin.orderTransaction', ['confirmed', $order->id]) }}">Xác nhận</a>
                                                                </li>
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['cancel', $order->id]) }}">Hủy</a>
                                                                </li>
                                                            @endif
        
                                                            @if ($order->status === 2)
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['preparing', $order->id]) }}">Chuẩn bị</a>
                                                                </li>
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['cancel', $order->id]) }}">Hủy</a>
                                                                </li>
                                                            @endif
        
                                                            @if ($order->status === 3)
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['delivering', $order->id]) }}">Giao Hàng</a>
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

                    {{-- <!-- Đơn Hàng chuẩn bị -->
                    <div role="tabpanel" class="tab-pane" id="delivered-orders">
                        <div class="box-body">
                            <table id="delivered" class="table table-hover" style="width:100%; min-width: 1024px;">
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
                                    @foreach ($deliveredOrders as $order)
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
                                                            class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown"
                                                            aria-expanded='true'>
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
                                                                        href="{{ route('admin.orderTransaction', ['confirmed', $order->id]) }}">Xác nhận</a>
                                                                </li>
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['cancel', $order->id]) }}">Hủy</a>
                                                                </li>
                                                            @endif
        
                                                            @if ($order->status === 2)
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['preparing', $order->id]) }}">Chuẩn bị</a>
                                                                </li>
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['cancel', $order->id]) }}">Hủy</a>
                                                                </li>
                                                            @endif
        
                                                            @if ($order->status === 3)
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['delivering', $order->id]) }}">Giao Hàng</a>
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
                    </div> --}}

                    <!-- Đơn Hàng chuẩn bị -->
                    <div role="tabpanel" class="tab-pane" id="completed-orders">
                        <div class="box-body">
                            <table id="completed" class="table table-hover" style="width:100%; min-width: 1024px;">
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
                                    @foreach ($completedOrders as $order)
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
                                                            class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown"
                                                            aria-expanded='true'>
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
                                                                        href="{{ route('admin.orderTransaction', ['confirmed', $order->id]) }}">Xác nhận</a>
                                                                </li>
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['cancel', $order->id]) }}">Hủy</a>
                                                                </li>
                                                            @endif
        
                                                            @if ($order->status === 2)
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['preparing', $order->id]) }}">Chuẩn bị</a>
                                                                </li>
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['cancel', $order->id]) }}">Hủy</a>
                                                                </li>
                                                            @endif
        
                                                            @if ($order->status === 3)
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['delivering', $order->id]) }}">Giao Hàng</a>
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
                    <div role="tabpanel" class="tab-pane" id="failed-orders">
                        <div class="box-body">
                            <table id="failed" class="table table-hover" style="width:100%; min-width: 1024px;">
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
                                    @foreach ($failedOrders as $order)
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
                                                            class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown"
                                                            aria-expanded='true'>
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
                                                                        href="{{ route('admin.orderTransaction', ['confirmed', $order->id]) }}">Xác nhận</a>
                                                                </li>
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['cancel', $order->id]) }}">Hủy</a>
                                                                </li>
                                                            @endif
        
                                                            @if ($order->status === 2)
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['preparing', $order->id]) }}">Chuẩn bị</a>
                                                                </li>
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['cancel', $order->id]) }}">Hủy</a>
                                                                </li>
                                                            @endif
        
                                                            @if ($order->status === 3)
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['delivering', $order->id]) }}">Giao Hàng</a>
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
                    <div role="tabpanel" class="tab-pane" id="cancelled-orders">
                        <div class="box-body">
                            <table id="cancelled" class="table table-hover" style="width:100%; min-width: 1024px;">
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
                                    @foreach ($cancelOrders as $order)
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
                                                            class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown"
                                                            aria-expanded='true'>
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
                                                                        href="{{ route('admin.orderTransaction', ['confirmed', $order->id]) }}">Xác nhận</a>
                                                                </li>
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['cancel', $order->id]) }}">Hủy</a>
                                                                </li>
                                                            @endif
        
                                                            @if ($order->status === 2)
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['preparing', $order->id]) }}">Chuẩn bị</a>
                                                                </li>
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['cancel', $order->id]) }}">Hủy</a>
                                                                </li>
                                                            @endif
        
                                                            @if ($order->status === 3)
                                                                <li>
                                                                    <a
                                                                        href="{{ route('admin.orderTransaction', ['delivering', $order->id]) }}">Giao Hàng</a>
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
        $(function() {
            var tableDelivering = $('#delivering').DataTable({
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

            var tableDelivered = $('#delivered').DataTable({
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

            var tableCompleted = $('#completed').DataTable({
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

            var tableFailed = $('#failed').DataTable({
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

            var tableCancelled = $('#cancelled').DataTable({
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
                tableDelivering.search(this.value).draw();
                tableDelivered.search(this.value).draw();
                tableCompleted.search(this.value).draw();
                tableFailed.search(this.value).draw();
                tableCancelled.search(this.value).draw();
            });
        });
    </script>

@endsection
