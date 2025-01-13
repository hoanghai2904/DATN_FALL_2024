@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('embed-css')
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('custom-css')
    <style>
      /* Đặt cho đoạn văn tổng doanh thu và tổng lợi nhuận */
p {
    font-size: 18px; /* Tăng kích thước chữ */
    font-weight: normal; /* Đặt mặc định font-weight cho text */
    margin: 10px 0; /* Thêm khoảng cách giữa các đoạn */
}

/* Đặt cho các span chứa tổng doanh thu và tổng lợi nhuận */
#totalRevenue, #totalProfit {
    font-weight: bold; /* Làm chữ đậm */
    font-size: 20px; /* Làm chữ to lên một chút */
    color: #1a73e8; /* Chỉnh màu cho tiền (ví dụ màu xanh) */
}

/* Tùy chọn: Để chữ trong các đoạn <p> có thể đậm lên */
p span {
    font-size: 22px; /* Tăng thêm kích thước chữ nếu cần */
}

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
                <a href="{{ route('admin.users') }}" class="small-box-footer">More info <i
                        class="fa fa-arrow-circle-right"></i></a>
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
                <a href="{{ route('admin.post.index') }}" class="small-box-footer">More info <i
                        class="fa fa-arrow-circle-right"></i></a>
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
                <a href="{{ route('admin.products.index') }}" class="small-box-footer">More info <i
                        class="fa fa-arrow-circle-right"></i></a>
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
                <a href="{{ route('admin.order.index') }}" class="small-box-footer">More info <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>


    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                        aria-expanded="true" aria-controls="collapseOne">
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
                                            <form action="{{ route('admin.statistic.edit') }}" method="POST"
                                                accept-charset="utf-8">
                                                @csrf
                                                <div class="row" style="margin-right: -5px; margin-left: -5px;">
                                                    <!-- Dropdown chọn ngày -->
                                                    <div class="col-md-3 col-sm-4 col-xs-12" style="padding-right: 5px; padding-left: 5px;">
                                                      <label for="select-day">Chọn Ngày</label>
                                                      <input type="text" id="select-day" class="form-control change-statistic" placeholder="Chọn ngày" />
                                                  </div>
                                                  
                                                  <div class="col-md-3 col-sm-4 col-xs-12" style="padding-right: 5px; padding-left: 5px;">
                                                      <label for="select-month">Chọn Tháng</label>
                                                      <input type="text" id="select-month" class="form-control change-statistic" placeholder="Chọn tháng" />
                                                  </div>
                                                  
                                                  <div class="col-md-3 col-sm-4 col-xs-12" style="padding-right: 5px; padding-left: 5px;">
                                                      <label for="select-year">Chọn Năm</label>
                                                      <input type="text" id="select-year" class="form-control change-statistic" placeholder="Chọn năm" />
                                                  </div>
                                                  

                                                    {{-- <div class="col-md-3 col-sm-4 col-xs-12"
                                                        style="padding-right: 5px; padding-left: 5px;">
                                                        <button type="submit" class="btn btn-primary"
                                                            style="margin-top: 26px;">Lọc</button>
                                                    </div> --}}
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Biểu đồ doanh thu bán hàng, các biểu đồ tròn sẽ được gộp gọn trong cùng một hàng -->
                                <div class="row">
                                    <div class="col-md-12 col-sm-12" style="padding: 10px;">
                                        <div id="salesChart" style="width: 100%; height: 300px;"></div>
                                    </div>
                                   
                                </div>

                                {{-- <div class="row">
                                   
                                    <div class="col-md-5 col-sm-12" style="padding: 10px;">
                                      <div id="productPieChart" style="width: 100%; height: 300px;"></div>
                                  </div>
                                    <div class="col-md-7 col-sm-12" style="padding: 10px;">
                                        <div id="profitChart" style="width: 100%; height: 300px;"></div>
                                    </div>
                                </div> --}}

                                <!-- Thông tin tổng doanh thu, lợi nhuận -->
                                <div>
                                    <p>Tổng Doanh Thu: <span id="totalRevenue"> </span></p>
                                    <p>Tổng Lợi Nhuận: <span id="totalProfit"> </span></p>
                                    
                                </div>
                            </div>
                        </div>
                  </div>
                </div>
            </div>
         
          
          
          
        </div>


        
    </div>





    {{-- lastest order --}}
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingThree">
            <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                    href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Đơn Hàng Mới Nhất
                </a>
            </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
            <div class="panel-body">
              <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Danh Sách Đơn Hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="order-table" class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px;">ID</th>
                                            <th>Mã Đơn Hàng</th>
                                            
                                            <th>Tên</th>
                                            <th>Email</th>
                                            <th>Điện Thoại</th>
                                            <th>Phương Thức Thanh Toán</th>
                                            <th>Ngày đặt hàng</th>
                                        </tr>
                                    </thead>
            
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td class="text-center">{{ $order->id }}</td>
                                                <td>{{ '#' . $order->order_code }}</td>
                                              
                                                <td>{{ $order->name }}</td>
                                                <td>{{ $order->email }}</td>
                                                <td>{{ $order->phone }}</td>
                                                <td>{{ $order->payment_method?->name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</td>
                                                @php
                                                    $statusLabels = [
                                                        1 => ['label' => 'label-default', 'text' => 'Chờ xác nhận'],
                                                        2 => ['label' => 'label-info', 'text' => 'Đã xác nhận'],
                                                        3 => ['label' => 'label-info', 'text' => 'Chuẩn bị '],
                                                        4 => ['label' => 'label-warning', 'text' => 'Đang giao'],
                                                        6 => ['label' => 'label-success', 'text' => 'Thành công'],
                                                        8 => ['label' => 'label-danger', 'text' => 'Hủy'],
                                                    ];
                                                @endphp
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
@endsection

@section('custom-js')
    <script>
    $(document).ready(function() {
    const formatMoney = (value) => {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(value);
    };

    // Dữ liệu từ backend
    const chartData = {
        labels: {!! json_encode($data['labels']) !!},
        revenues: {!! json_encode($data['revenues']) !!},
        profits: {!! json_encode($data['profits']) !!}, // Dữ liệu lợi nhuận
        producers: {!! json_encode($data['producer']) !!},
        weeklyRevenues: {!! json_encode($data['weekly_revenues']) !!},
        monthlyRevenues: {!! json_encode($data['monthly_revenues']) !!},
        yearlyRevenues: {!! json_encode($data['yearly_revenues']) !!},
        totalRevenue: {!! json_encode($data['total_revenue']) !!},
        totalProfit: {!! json_encode($data['total_profit']) !!},
        countProducts: {!! json_encode($data['count_products']) !!},
        countOrders: {!! json_encode($data['count_orders']) !!},
    };

    // Biểu đồ doanh thu hàng tháng
    const salesChartDom = document.getElementById('salesChart');
    const salesChart = echarts.init(salesChartDom);
console.log("char:",chartData);

    const salesChartOption = {
        title: {
            text: '',
        },
        tooltip: {
            trigger: 'axis',
            formatter: (params) => {
    const values = params.reduce((acc, param) => {
        if (param.seriesName === 'Doanh thu') acc.revenue = param.value || 0;
        if (param.seriesName === 'Lợi nhuận') acc.profit = param.value || 0;
        return acc;
    }, { revenue: 0, profit: 0 });

    const axisValue = params[0]?.axisValue || 'Không có dữ liệu';

    return `${axisValue}: Doanh thu ${formatMoney(values.revenue)}, Lợi nhuận ${formatMoney(values.profit)}`;
}
        },
        legend: {
            data: ['Doanh thu', 'Lợi nhuận']
        },
        xAxis: {
            type: 'category',
            data: chartData.labels
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                name: 'Doanh thu',
                data: chartData.revenues,
                type: 'bar', // Cột doanh thu
                smooth: true,
                color: '#42a5f5' // Màu cho cột doanh thu
            },
            {
                name: 'Lợi nhuận',
                data: chartData.profits,
                type: 'bar', // Cột lợi nhuận
                smooth: true,
                color: '#66bb6a' // Màu cho cột lợi nhuận
            }
        ]
    };

    salesChart.setOption(salesChartOption);
// Cập nhật giá trị vào các phần tử HTML
  document.getElementById('totalRevenue').innerText = formatMoney(chartData.totalRevenue).toLocaleString();
  document.getElementById('totalProfit').innerText = formatMoney(chartData.totalProfit).toLocaleString();
    // Hàm tạo biểu đồ cột (bar chart)
    const generateBarChart = (elementId, title, dataKey) => {
        const chartDom = document.getElementById(elementId);
        if (!chartDom) {
            console.error(`Không tìm thấy element với id: ${elementId}`);
            return;
        }

        const chart = echarts.init(chartDom);

        // Xử lý dữ liệu
        const data = Object.keys(chartData.producers).map(key => ({
            value: chartData.producers[key]?.[dataKey] ?? 0,
            name: key
        }));
        console.log(data);
        // Cấu hình biểu đồ
        const option = {
            title: {
                text: title,
                left: 'center'
            },
            tooltip: {
                trigger: 'item',
                formatter: '{b}: {c}' // Hiển thị tên và giá trị khi hover
            },
            xAxis: {
                type: 'category',
                data: data.map(item => item.name) // Tên các mục
            },
            yAxis: {
                type: 'value',
                min: 0, // Bắt đầu từ 0
                axisLabel: {
                    formatter: (value) => formatMoney(value) // Định dạng giá trị trục Y
                }
            },
            series: [{
                name: title,
                type: 'bar',
                data: data.map(item => ({
                    value: item.value,
                    name: item.name
                })),
                label: {
                    show: true,
                    position: 'top',
                    formatter: '{c}' // Hiển thị giá trị
                }
            }]
        };

        // Vẽ biểu đồ
        chart.setOption(option);
    };

    // Tạo các biểu đồ cột
    // generateBarChart('quantityChart', 'Số Lượng Sản Phẩm', 'quantity');
    // generateBarChart('revenueChart', 'Doanh Thu', 'revenue');
    // generateBarChart('profitChart', 'Lợi Nhuận', 'profit');

    // Biểu đồ sản phẩm theo nhà sản xuất
    // const generateProducerChart = () => {
    //     const chartDom = document.getElementById('productPieChart');
    //     const chart = echarts.init(chartDom);

    //     const data = Object.keys(chartData.producers).map(key => ({
    //         value: chartData.producers[key].quantity,
    //         name: key
    //     }));

    //     const option = {
    //         title: {
    //             text: 'Sản Phẩm Theo Danh Mục',
    //             left: 'center'
    //         },
    //         tooltip: {
    //             trigger: 'item',
    //             formatter: '{b}: {c} ({d}%)'
    //         },
    //         legend: {
    //             orient: 'vertical',
    //             left: 'left',
    //             data: Object.keys(chartData.producers)
    //         },
    //         series: [{
    //             name: 'Nhà sản xuất',
    //             type: 'pie',
    //             radius: ['40%', '70%'],
    //             data
    //         }]
    //     };

    //     chart.setOption(option);
    // };

    // generateProducerChart();

    // Xử lý thay đổi dữ liệu
    $('input.change-statistic').on('change', function() {
    const day = $('#select-day').length ? $('#select-day').val() : null;
    const month = $('#select-month').length ? $('#select-month').val() : null;
    const year = $('#select-year').length ? $('#select-year').val() : null;

    // Kiểm tra sự tồn tại của CSRF token
    const csrfToken = $('meta[name="csrf-token"]').length ? $('meta[name="csrf-token"]').attr('content') : null;

    if (!csrfToken) {
        console.error('CSRF token không tồn tại!');
        return;
    }

    const overlay = $('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $(this).closest('.box').append(overlay);

    // Lấy dữ liệu từ form và chỉ gửi tham số có giá trị
    const data = {};
    if (day) data.day = day;
    if (month) data.month = month;
    if (year) data.year = year;

    // Gửi yêu cầu AJAX tới backend
    $.ajax({
        url: '{{ route('admin.statistic.edit') }}', // Đảm bảo URL đúng
        type: 'GET', // Hoặc POST nếu cần
        data: data, // Gửi dữ liệu lọc
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': csrfToken  // Thêm CSRF token vào header
        },
        beforeSend: function() {
            // Hiển thị overlay khi đang gửi yêu cầu
            overlay.show();
        },
        success: function(chartData) {
            overlay.remove(); // Xóa overlay khi dữ liệu đã được tải xong
            console.log("data:",chartData);
            
            // Cập nhật biểu đồ doanh thu
            salesChart.setOption({
                xAxis: {
                    data: chartData.labels
                },
                series: [{
                    data: chartData.revenues
                }, {
                    data: chartData.profits
                }]
            });

            // Hàm cập nhật biểu đồ cột
            const updateBarChart = (chart, key) => {
                const updatedData = Object.keys(chartData.producer).map(k => ({
                    value: chartData.producer[k][key],
                    name: k
                }));
                chart.setOption({
                    series: [{
                        data: updatedData
                    }]
                });
            };

            // Cập nhật các biểu đồ cột
            // const profitChart = echarts.getInstanceByDom(document.getElementById('profitChart'));
            // updateBarChart(profitChart, 'profit');

            // Cập nhật tổng doanh thu và lợi nhuận
            
            $('#totalRevenue').text(formatMoney(chartData.total_revenue));
            $('#totalProfit').text(formatMoney(chartData.total_profit));
         

            // Cập nhật biểu đồ nhà sản xuất
            // generateProducerChart(); // Cập nhật lại biểu đồ nhà sản xuất
        },
        error: function(xhr, status, error) {
            overlay.remove(); // Xóa overlay nếu có lỗi

            Swal.fire({
                title: 'Thất bại',
                text: xhr.responseJSON?.msg || 'Có lỗi xảy ra',
                icon: 'error'
            });
        }
    });
});


});

    </script>
{{-- Bộ lọc filter --}}
 {{-- <script>
$(document).ready(function() {
    // Hàm định dạng tiền
    const formatMoney = (value) => {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(value);
    };

    // Dữ liệu từ backend
    const chartData = {
        labels: {!! json_encode($data['labels']) !!},
        revenues: {!! json_encode($data['revenues']) !!},
        profits: {!! json_encode($data['profits']) !!},
        producers: {!! json_encode($data['producer']) !!},
        weeklyRevenues: {!! json_encode($data['weekly_revenues']) !!},
        monthlyRevenues: {!! json_encode($data['monthly_revenues']) !!},
        yearlyRevenues: {!! json_encode($data['yearly_revenues']) !!},
        totalRevenue: {!! json_encode($data['total_revenue']) !!},
        totalProfit: {!! json_encode($data['total_profit']) !!},
        countProducts: {!! json_encode($data['count_products']) !!},
        countOrders: {!! json_encode($data['count_orders']) !!},
    };

    // Xử lý khi người dùng chọn bộ lọc
  
}); --}}


 </script>
{{-- end  --}}
{{-- start datepiker --}}
    <script>
   $(document).ready(function() {
    // Kích hoạt datepicker cho ngày
    $('#select-day').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true,
    });

    // Kích hoạt datepicker cho tháng
    $('#select-month').datepicker({
        format: 'mm',
        minViewMode: 1,
        autoclose: true,
    });

    // Kích hoạt datepicker cho năm
    $('#select-year').datepicker({
        format: 'yyyy',
        minViewMode: 2,
        autoclose: true,
    });
});

    </script>
@endsection
