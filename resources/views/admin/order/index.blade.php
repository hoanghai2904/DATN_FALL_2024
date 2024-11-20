@extends('admin.layouts.master')

@section('title', 'Quản Lý Đơn Hàng')

@section('embed-css')
<link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('custom-css')
<style>
  #order-table td,
  #order-table th {
    vertical-align: middle !important;
  }
  #order-table span.status-label {
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
  <li class="active">Quản Lý Đơn Hàng</li>
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
                <a href="{{ route('admin.order.index') }}" class="btn btn-flat btn-primary" title="Refresh">
                  <i class="fa fa-refresh"></i><span class="hidden-xs"> Refresh</span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="box-body">
          <table id="order-table" class="table table-hover" style="width:100%; min-width: 1024px;">
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
              @foreach($orders as $order)
                <tr>
                  <td class="text-center">{{ $order->id }}</td>
                  <td>{{ '#'.$order->order_code }}</td>
                  <td>
                    @if ($order->user)
                      <a href="{{ route('admin.user_show', ['id' => $order->user->id]) }}" class="text-left" title="{{ $order->user->name }}">{{ $order->user->name }}</a>
                    @else
                      <span>---</span>
                    @endif
                  </td>
                  <td>{{ $order->name }}</td>
                  <td>{{ $order->email }}</td>
                  <td>{{ $order->phone }}</td>
                  <td>{{ $order->payment_method?->name }}</td>
                  <td>{{ $order?->is_paid ? 'Đã thanh toán' : 'Chưa thanh toán' }}</td>
                  <td> {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y')}}</td>
                  @php
                      $statusLabels = [
                          1 => ['label' => 'label-default', 'text' => 'Chờ xác nhận'],
                          2 => ['label' => 'label-info', 'text' => 'Đã xác nhận'],
                          3 => ['label' => 'label-info', 'text' => 'Đang Vận Chuyển'],
                          4 => ['label' => 'label-success', 'text' => 'Đã Giao Hàng'],
                          5 => ['label' => 'label-danger', 'text' => 'Hủy'],
                      ];
                  @endphp
                  <td>
                      @if(isset($statusLabels[$order->status]))
                          <span class="label {{ $statusLabels[$order->status]['label'] }}" style="font-size:13px; display: inline-block; width: 100%">
                              {{ $statusLabels[$order->status]['text'] }}
                          </span>
                      @endif
                  </td>
                  <td>
                    <a href="{{ route('admin.order.show', ['id' => $order->id]) }}" class="btn btn-icon btn-sm btn-primary tip" title="Chi Tiết">
                      <i class="fa fa-eye" aria-hidden="true"></i>
                    </a>
                    @if ($order->status === 1 || $order->status === 2 || $order->status === 3)
                      <div class="btn-group">
                        <button type="button" style="height: 30px;" class="btn btn-success btn-xs dropdown-toggle"
                        data-toggle="dropdown" aria-expanded='true'>
                          Thao tác
                          <span class="caret"></span>
                          <span class="sr-only">Toggle-dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                          @if ($order->status === 1 && $order->payment_method_id == 1 || 
                            $order->status === 1 && $order->payment_method_id == 2 && $order->is_paid)
                            <li>
                              <a href="{{route('admin.orderTransaction',['confirmed',$order->id])}}"></i>Đã xác nhận</a>
                            </li>
                          @endif
                          @if ($order->status === 2)
                            <li>
                              <a href="{{route('admin.orderTransaction',['delivering',$order->id])}}"></i>Đang Vận Chuyển</a>
                            </li>
                          @endif
                          @if ($order->status === 3)
                            <li>
                              <a href="{{route('admin.orderTransaction',['delivered',$order->id])}}" ></i>Đã Giao Hàng</a>
                            </li>
                          @endif
                          @if ($order->status === 1)
                            <li>
                              <a href="{{route('admin.orderTransaction',['cancel',$order->id])}}" ></i>Hủy</a>
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
  $(function () {
    var table = $('#order-table').DataTable({
      "language": {
        "zeroRecords":    "Không tìm thấy kết quả phù hợp",
        "info":           "Hiển thị trang <b>_PAGE_/_PAGES_</b> của <b>_TOTAL_</b> đơn hàng",
        "infoEmpty":      "Hiển thị trang <b>1/1</b> của <b>0</b> đơn hàng",
        "infoFiltered":   "(Tìm kiếm từ <b>_MAX_</b> đơn hàng)",
        "emptyTable": "Không có dữ liệu đơn hàng",
      },
      "lengthChange": false,
       "autoWidth": false,
       "order": [],
      "dom": '<"table-responsive"t><<"row"<"col-md-6 col-sm-6"i><"col-md-6 col-sm-6"p>>>',
      "drawCallback": function(settings) {
        var api = this.api();
        if (api.page.info().pages <= 1) {
          $('#'+ $(this).attr('id') + '_paginate').hide();
        }
      }
    });

    $('#search-input input').on('keyup', function() {
        table.search(this.value).draw();
    });
  });
</script>
@endsection
