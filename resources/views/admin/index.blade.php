@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('embed-css')
<link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('custom-css')
<style>
  .form-action select.form-control {
    position: static;
    width: 100%;
    font-size: 15px;
    line-height: 22px;
    padding: 5px;
    float: none;
    height: unset;
    border-color: #fbfbfb;
    box-shadow: none;
    background-color: #e8f0fe;
  }
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
</style>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Dashboard</li>
</ol>
@endsection

@section('content')
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3>{{ $count['user'] }}</h3>

          <p>Người Dùng</p>
        </div>
        <div class="icon">
          <i class="ion ion-person"></i>
        </div>
        <a href="{{ route('admin.users') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua-active">
        <div class="inner">
          <h3>{{ $count['post'] }}</h3>

          <p>Bài Viết</p>
        </div>
        <div class="icon">
          <i class="fa fa-newspaper-o"></i>
        </div>
        <a href="{{ route('admin.post.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-orange">
        <div class="inner">
          <h3>{{ $count['product'] }}</h3>

          <p>Sản Phẩm</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="{{ route('admin.product.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-purple">
        <div class="inner">
          <h3>{{ $count['order'] }}</h3>

          <p>Đơn Hàng</p>
        </div>
        <div class="icon">
          <i class="fa fa-list-alt"></i>
        </div>
        <a href="{{ route('admin.order.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
  
  
  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    {{-- dashboard --}}
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Thống kê doanh thu
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <div style="display: flex; align-items: center; justify-content: space-between;">
                    <h3 class="box-title">Thống Kê Doanh Thu Bán Hàng</h3>

                    <div class="form-action">
                      <form action="{{ route('admin.statistic.edit') }}" method="POST" accept-charset="utf-8">
                        @csrf
                        <div class="row" style="margin-right: -5px; margin-left: -5px;">
                          <div class="col-md-6 col-sm-6 col-xs-6" style="padding-right: 5px; padding-left: 5px;">
                            <select class="form-control change-statistic" name="month">
                              <option value="">-- Chọn Tháng --</option>
                              @for ($i = 0; $i < 12; $i++)
                                <option value="{{ $i + 1 }}">Tháng {{ $i + 1 }}</option>
                              @endfor
                            </select>
                          </div>
                          <div class="col-md-6 col-sm-6 col-xs-6" style="padding-right: 5px; padding-left: 5px;">
                            <select class="form-control change-statistic" name="year">
                              <option value="">-- Chọn Năm --</option>
                              @for ($i = 0; $i < 5; $i++)
                                <option value="{{ date('Y') - $i }}">Năm {{ date('Y') - $i }}</option>
                              @endfor
                            </select>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div id="print">
                    <div class="box box-default box-chart">
                      <div class="box-header with-border text-center">
                        <h3 class="box-title">Biểu Đồ Kinh Doanh Tháng {{ date('m').' Năm '.date('Y') }}</h3>
                      </div>
                      <div class="box-body">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="chart">
                              <!-- Sales Chart Canvas -->
                              <canvas id="salesChart" style="height: 300px;"></canvas>
                            </div>
                            <p class="text-center">
                              <i>Hình 1: Biểu đồ doanh số bán hàng</i>
                            </p>
                            <!-- /.chart-responsive -->
                          </div>
                          <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <div class="row">
                          <div class="col-md-4 col-sm-4 col-xs-4">
                            <div class="chart" style="margin-bottom: 10px;">
                              <!-- Sales Chart Canvas -->
                              <div id="quantityChart" style="width: 200px; height: 200px; margin: 0 auto;"></div>
                            </div>
                            <!-- /.chart-responsive -->
                            <p class="text-center">
                              <i>Hình 2: Thị phần sản phẩm bán được theo nhà sản xuất</i>
                            </p>
                          </div>
                          <!-- /.col -->
                          <div class="col-md-4 col-sm-4 col-xs-4">
                            <div class="chart" style="margin-bottom: 10px;">
                              <!-- Sales Chart Canvas -->
                              <div id="revenueChart" style="width: 200px; height: 200px; margin: 0 auto;"></div>
                            </div>
                            <!-- /.chart-responsive -->
                            <p class="text-center">
                              <i>Hình 3: Thị phần doanh thu theo nhà sản xuất</i>
                            </p>
                          </div>
                          <!-- /.col -->
                          <div class="col-md-4 col-sm-4 col-xs-4">
                            <div class="chart" style="margin-bottom: 10px;">
                              <!-- Sales Chart Canvas -->
                              <div id="profitChart" style="width: 200px; height: 200px; margin: 0 auto;"></div>
                            </div>
                            <!-- /.chart-responsive -->
                            <p class="text-center">
                              <i>Hình 4: Thị phần lợi nhuận theo nhà sản xuất</i>
                            </p>
                          </div>
                          <!-- /.col -->
                        </div>
                      </div>
                      <div class="box-footer" style="border-bottom: 1px solid #f4f4f4;">
                        <div class="row">
                          <!-- /.col -->
                          <div class="col-sm-3 col-xs-3">
                            <div class="description-block border-right description-order">
                              <h5 class="description-header">{{ $data['count_orders'] }}</h5>
                              <span class="description-text">ĐƠN HÀNG</span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <div class="col-sm-3 col-xs-3">
                            <div class="description-block border-right description-product">
                              <h5 class="description-header">{{ $data['count_products'] }}</h5>
                              <span class="description-text">SẢN PHẨM BÁN RA</span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-3 col-xs-3">
                            <div class="description-block border-right description-revenue">
                              <h5 class="description-header"><span style="color: #f30;">{{ number_format($data['total_revenue'],0,',','.').' VNĐ' }}</span></h5>
                              <span class="description-text">DOANH THU THÁNG</span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-3 col-xs-3">
                            <div class="description-block description-profit">
                              <h5 class="description-header"><span style="color: #f30;">{{ number_format($data['total_profit'],0,',','.').' VNĐ' }}</span></h5>
                              <span class="description-text">LỢI NHUẬN THÁNG</span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                        </div>
                      </div>
                    </div>
                    <div class="box box-default box-table">
                      <div class="box-header with-border text-center">
                        <h3 class="box-title">Danh Sách Sản Phẩm Xuất Kho Tháng {{ date('m').' Năm '.date('Y') }}</h3>
                      </div>
                      <div class="box-body">
                        <div class="table-responsive">
                          <table class="table table-striped">
                            <thead>
                              <tr>
                                <th style="text-align: center; vertical-align: middle;">STT</th>
                                <th style="vertical-align: middle;">Mã Sản Phẩm</th>
                                <th style="vertical-align: middle;">Tên Sản Phẩm</th>
                                <th style="vertical-align: middle;">Loại</th>
                                <th style="vertical-align: middle;">Đơn Hàng</th>
                                <th style="vertical-align: middle;">Ngày Xuất</th>
                                <th style="text-align: center; vertical-align: middle;">Số Lượng</th>
                                <th style="vertical-align: middle;">Giá Nhập</th>
                                <th style="vertical-align: middle;">Giá Xuất</th>
                                <th style="vertical-align: middle;">Doanh Thu</th>
                                <th style="vertical-align: middle;">Lợi Nhuận</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $price = 0; ?>
                              <?php $profit = 0; ?>
                              @foreach($data['order_details'] as $key => $order_detail)
                                <?php $price = $price + $order_detail->price * $order_detail->quantity- $order_detail->order->discount; ?>
                                <?php $profit = $profit + ($order_detail->quantity * ($order_detail->price - $order_detail->product_detail->import_price))-($order_detail->order->discount); ?>
                                <tr>
                                  <td style="text-align: center; vertical-align: middle;">{{ $key + 1 }}</td>
                                  <td style="vertical-align: middle;">{{ '#'.$order_detail->product_detail->product->sku_code }}</td>
                                  <td style="vertical-align: middle;">{{ $order_detail->product_detail->product->name }}</td>
                                  <td style="vertical-align: middle;">{{ $order_detail->product_detail->color }}</td>
                                  <td style="vertical-align: middle;">{{ '#'.$order_detail->order->order_code }}</td>
                                  <td style="vertical-align: middle;">{{ date_format($order_detail->created_at, 'd/m/Y') }}</td>
                                  <td style="text-align: center; vertical-align: middle;">{{ $order_detail->quantity }}</td>
                                  <td style="vertical-align: middle;"><span style="color: #f30;">{{ number_format($order_detail->product_detail->import_price,0,',','.') }} VNĐ</span></td>
                                  <td style="vertical-align: middle;"><span style="color: #f30;">{{ number_format($order_detail->price,0,',','.') }} VNĐ</span></td>
                                  <td style="vertical-align: middle;"><span style="color: #f30;">{{ number_format($order_detail->price * $order_detail->quantity - $order_detail->order->discount,0,',','.') }} VNĐ</span></td>
                                  <td style="vertical-align: middle;"><span style="color: #f30;">{{ number_format(($order_detail->quantity * ($order_detail->price - $order_detail->product_detail->import_price))-($order_detail->order->discount) ,0,',','.') }} VNĐ</span></td>
                                </tr>
                              @endforeach
                              <tr>
                                <td colspan="11" style="text-align: right;">
                                  <i style="margin-right: 10px;">*Tổng Doanh Thu = <span style="color: #f30;">{{ number_format($price,0,',','.') }} VNĐ</span></i>
                                  <i>*Tổng Lợi Nhuận = <span style="color: #f30;">{{ number_format($profit,0,',','.') }} VNĐ</span></i>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- ./box-body -->
                <div class="box-footer">
                  <div class="row">
                    <div class="col-xs-12">
                      <button class="btn btn-success btn-print pull-right"><i class="fa fa-print"></i> In Báo Cáo</button>
                    </div>
                  </div>
                </div>
                <!-- /.box-footer -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
      </div>
    </div>
  </div>
  {{-- order status --}}
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Thống kê trạng thái đơn hàng
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
         <div class="row">
            @foreach ($orderStatuses as $orderStatus)
              <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                  <div class="inner">
                    <h4>{{ $orderStatus['status'] }}</h3>
  
                    <h2>{{$orderStatus['count']}}</h2>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
      </div>
    </div>
  </div>
  {{-- lastest order --}}
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingThree">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Đơn Hàng Mới Nhất
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
      <div class="panel-body">
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
                    {{-- @if ($order->status === 1 || $order->status === 2 || $order->status === 3)
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
                    @endif --}}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
      </div>
    </div>
  </div>
</div>
@endsection

@section('embed-js')
  <!-- ChartJS -->
  <script src="{{ asset('AdminLTE/bower_components/chart.js/Chart.js') }}"></script>
  <!-- FLOT CHARTS -->
  <script src="{{ asset('AdminLTE/bower_components/Flot/jquery.flot.js') }}"></script>
  <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
  <script src="{{ asset('AdminLTE/bower_components/Flot/jquery.flot.resize.js') }}"></script>
  <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
  <script src="{{ asset('AdminLTE/bower_components/Flot/jquery.flot.pie.js') }}"></script>
  <!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
  <script src="{{ asset('AdminLTE/bower_components/Flot/jquery.flot.categories.js') }}"></script>
  <!-- Print JS -->
  <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
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
  $(document).ready(function(){
    // -----------------------
    // - MONTHLY SALES CHART -
    // -----------------------

    // Get context with jQuery - using jQuery's .get() method.
    var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
    // This will get the first returned node in the jQuery collection.
    var salesChart       = new Chart(salesChartCanvas);

    var salesChartData = {
      labels  : {!! json_encode($data['labels'] ) !!},
      datasets: [
        {
          label               : 'Doanh Số Bán Hàng',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : {!! json_encode($data['revenues'] ) !!}
        }
      ]
    };

    var salesChartOptions = {
      // Boolean - If we should show the scale at all
      showScale               : true,
      scaleLabel              : function(label) {
        return formatMoney(label.value);
      },
      tooltipTemplate        : function(label) {
        return label.label.toString() + " : " + formatMoney(label.value);
      },
      tooltipFontSize: 12,
      // Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : false,
      // String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      // Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      // Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      // Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      // Boolean - Whether the line is curved between points
      bezierCurve             : true,
      // Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      // Boolean - Whether to show a dot for each point
      pointDot                : false,
      // Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      // Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      // Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      // Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      // Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 2,
      // Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
      // String - A legend template
      legendTemplate          : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<datasets.length; i++){%><li><span style=\'background-color:<%=datasets[i].lineColor%>\'></span><%=datasets[i].label%></li><%}%></ul>',
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      // Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    };

    // Create the line chart
    var myChart = salesChart.Line(salesChartData, salesChartOptions);

    // ---------------------------
    // - END MONTHLY SALES CHART -
    // ---------------------------

    /* DONUT CHART */
    var options = {
      series: {
        pie: { show: true, radius: 1, innerRadius: 0.5,
          label: {
            show: true, radius: 2 / 3, formatter: labelFormatter, threshold: 0.1
          }
        }
      },
      colors: ['#3498db', '#2ecc71', '#e67e22', '#e74c3c', '#f1c40f', '#9b59b6', '#34495e'],
      legend: { show: false }
    };

    var quantityData = [
      @foreach($data['producer'] as $key => $producer)
        { label: '{{ $key }}', data: {{ $producer['quantity'] }} },
      @endforeach
    ];

    var quantityChart = $.plot('#quantityChart', quantityData, options);

    var revenueData = [
      @foreach($data['producer'] as $key => $producer)
        { label: '{{ $key }}', data: {{ $producer['quantity'] }} },
      @endforeach
    ];

    var revenueChart = $.plot('#revenueChart', revenueData, options);

    var profitData = [
      @foreach($data['producer'] as $key => $producer)
        { label: '{{ $key }}', data: {{ $producer['profit'] }} },
      @endforeach
    ];

    var profitChart = $.plot('#profitChart', profitData, options);
    /* END DONUT CHART */

    $('select.change-statistic').on('change', function() {
      $(this).closest('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
      var url = $(this).closest('form').attr('action');
      var data = $(this).closest('form').serialize();
      $.ajax({
        url: url,
        type: 'POST',
        data: data,
        dataType: 'JSON',
        success: function(data) {
          console.log(data)
          $('div.overlay').remove();
          $('#print .box-chart .box-title').text(data.text.title1);
          $('#print .box-table .box-title').text(data.text.title2);
          $('#print .box-chart .description-order .description-header').text(data.count_orders);
          $('#print .box-chart .description-product .description-header').text(data.count_products);
          $('#print .box-chart .description-revenue .description-header span').text(formatMoney(data.total_revenue));
          $('#print .box-chart .description-revenue .description-text').text(data.text.revenue);
          $('#print .box-chart .description-profit .description-header span').text(formatMoney(data.total_profit));
          $('#print .box-chart .description-profit .description-text').text(data.text.profit);

          myChart.destroy();

          var salesChartData = {
            labels  : data.labels,
            datasets: [
              {
                label               : 'Doanh Số Bán Hàng',
                fillColor           : 'rgba(60,141,188,0.9)',
                strokeColor         : 'rgba(60,141,188,0.8)',
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                : data.revenues
              }
            ]
          };

          myChart = salesChart.Line(salesChartData, salesChartOptions);

          quantityData = [];
          revenueData = [];
          profitData = [];

          $.each(data.producer, function(key,value){
            quantityData.push({ label: key, data: value.quantity });
            revenueData.push({ label: key, data: value.revenue });
            profitData.push({ label: key, data: value.profit });
          });

          quantityChart.destroy();
          revenueChart.destroy();
          profitChart.destroy();

          quantityChart = $.plot('#quantityChart', quantityData, options);
          revenueChart = $.plot('#revenueChart', revenueData, options);
          profitChart = $.plot('#profitChart', profitData, options);

          $('.box-table table tbody').empty();

          var price = 0;
          var profit = 0;

          $.each(data.order_details, function(key,value){

            price = price + value.price * value.quantity;
            profit = profit + value.quantity * (value.price - value.product_detail.import_price);

            $('.box-table table tbody').append(
              '<tr>' +
                '<td style="text-align: center; vertical-align: middle;">' + (key + 1) +'</td>' +
                '<td style="vertical-align: middle;"> #' + value.product_detail.product.sku_code + '</td>' +
                '<td style="vertical-align: middle;">' + value.product_detail.product.name + '</td>' +
                '<td style="vertical-align: middle;">' + value.product_detail.color + '</td>' +
                '<td style="vertical-align: middle;"> #' + value.order.order_code + '</td>' +
                '<td style="vertical-align: middle;">' + formatDate(value.created_at) + '</td>' +
                '<td style="text-align: center; vertical-align: middle;">' + value.quantity + '</td>' +
                '<td style="vertical-align: middle;">' +
                  '<span style="color: #f30;">' +
                    formatMoney(value.product_detail.import_price) +
                  '</span>' +
                '</td>' +
                '<td style="vertical-align: middle;">' +
                  '<span style="color: #f30;">' +
                    formatMoney(value.price) +
                  '</span>' +
                '</td>' +
                '<td style="vertical-align: middle;">' +
                  '<span style="color: #f30;">' +
                    formatMoney(value.price * value.quantity) +
                  '</span>' +
                '</td>' +
                '<td style="vertical-align: middle;">' +
                  '<span style="color: #f30;">' +
                    formatMoney(value.quantity * (value.price - value.product_detail.import_price)) +
                  '</span>' +
                '</td>' +
              '</tr>'
            );
          });

          $('.box-table table tbody').append(
            '<tr>' +
              '<td colspan="11" style="text-align: right;">' +
                '<i style="margin-right: 10px;">*Tổng Doanh Thu = <span style="color: #f30;">' + formatMoney(price) + '</span></i>' +
                '<i>*Tổng Lợi Nhuận = <span style="color: #f30;">' + formatMoney(profit) + '</span></i>' +
              '</td>' +
            '</tr>'
          );
        },
        error: function(data) {
          var errors = data.responseJSON;
          Swal.fire({
            title: 'Thất bại',
            text: errors.msg,
            type: 'error'
          })
        }
      });
    });
  });
</script>

<!-- Page script -->
<script>
  function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
      + label + '<br>' + Math.round(series.percent) + '%</div>'
  }
  function formatMoney(argument) {
    return argument.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ' VNĐ';
  }
  function formatDate(argument) {
    var date = new Date(argument);
    return date.getDate().toString() + '/' + (date.getMonth() + 1).toString() + '/' + date.getFullYear().toString();
  }
</script>
<script>
  $(document).ready(function() {
    $('.btn-print').click(function(){
      printJS({
        printable: 'print',
        type: 'html',
        documentTitle: ' ',
        header: 'Báo Cáo Tình Hình Kinh Doanh Website PhoneStore',
        headerStyle: 'font-size: 14px; margin-bottom: 10px;',
        style: '.box { margin-top: 10px; border-top: none; box-shadow: none; } ' +
                '@media print { .box-footer { page-break-after: always; } } ' +
                'table { page-break-inside:auto } ' +
                'tr { page-break-inside:avoid; page-break-after:auto }',
        css: [
          '{{ asset('AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css') }}',
          '{{ asset('AdminLTE/dist/css/AdminLTE.min.css') }}'
        ]
      });
    });
  });
</script>
{{-- table lastest order --}}
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
