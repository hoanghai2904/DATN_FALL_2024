@extends('admin.layouts.master')

@section('title')
    Bảng điều khiển
@endsection

@section('content')
    <div class="row">
        <div class="col">

            <div class="h-100">

                <!--end row-->

                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Tổng thu nhập
                                            (vnđ)</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <h5 class="{{ $earningsChange >= 0 ? 'text-success' : 'text-danger' }} fs-14 mb-0">
                                            <i
                                                class="ri-arrow-{{ $earningsChange >= 0 ? 'right-up' : 'right-down' }}-line fs-13 align-middle"></i>
                                            {{ number_format($earningsChange, 2) }} %
                                        </h5>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            <span class="counter-value"
                                                data-target="{{ number_format($totalEarnings) }}"></span>k
                                        </h4>
                                        <a href="#" class="text-decoration-underline">Xem đơn hàng</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-success-subtle rounded fs-3">
                                            <i class="bx bx-dollar-circle text-success"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Đơn đặt hàng</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <h5 class="{{ $orderChange >= 0 ? 'text-success' : 'text-danger' }} fs-14 mb-0">
                                            <i
                                                class="ri-arrow-{{ $orderChange >= 0 ? 'right-up' : 'right-down' }}-line fs-13 align-middle"></i>
                                            {{ number_format($orderChange, 2) }} %
                                        </h5>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            <span class="counter-value"
                                                data-target="{{ number_format($totalOrders) }}">0</span>
                                        </h4>
                                        <a href="{{ route('admin.orders.index') }}" class="text-decoration-underline">Xem
                                            đơn hàng</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded fs-3">
                                            <i class="bx bx-shopping-bag text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Đơn hàng đã giao
                                        </p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <h5 class="text-muted fs-14 mb-0">

                                        </h5>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                data-target="{{ $totalOrdersDone }}">0</span> </h4>
                                        <a href="{{ route('admin.orders.index') }}" class="text-decoration-underline">Xem
                                            đơn hàng</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-primary-subtle rounded fs-3">
                                            <i class="las la-shipping-fast text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Khách hàng</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <h5 class="{{ $customerChange >= 0 ? 'text-success' : 'text-danger' }} fs-14 mb-0">
                                            <i
                                                class="ri-arrow-{{ $customerChange >= 0 ? 'right-up' : 'right-down' }}-line fs-13 align-middle"></i>
                                            {{ number_format($customerChange, 2) }} %
                                        </h5>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <!-- Thêm thuộc tính 'data-target' để JS lấy và tạo hiệu ứng -->
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            <span class="counter-value" data-target="{{ $totalCustomers }}">0</span>
                                        </h4>
                                        <a href="{{ route('admin.listCusstomer') }}" class="text-decoration-underline">Xem
                                            khách hàng</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-warning-subtle rounded fs-3">
                                            <i class="bx bx-user-circle text-warning"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->


                </div> <!-- end row-->

                <div class="row">

                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-header border-0 align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Doanh thu</h4>
                                <div>
                                    <button type="button" class="btn btn-soft-secondary btn-sm">
                                        ALL
                                    </button>
                                    <button type="button" class="btn btn-soft-secondary btn-sm">
                                        1M
                                    </button>
                                    <button type="button" class="btn btn-soft-secondary btn-sm">
                                        6M
                                    </button>
                                    <button type="button" class="btn btn-soft-primary btn-sm">
                                        1Y
                                    </button>
                                </div>
                            </div><!-- end card header -->

                            <div class="card-header p-0 border-0 bg-light-subtle">
                                <div class="row g-0 text-center">
                                    <div class="col-6 col-sm-3">
                                        <div class="p-3 border border-dashed border-start-0">
                                            <h5 class="mb-1"><span class="counter-value" data-target="{{ number_format($totalOrders) }}">0</span></h5>
                                            <p class="text-muted mb-0">Đơn hàng</p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-6 col-sm-3">
                                        <div class="p-3 border border-dashed border-start-0">
                                            <h5 class="mb-1"><span class="counter-value" data-target="{{ number_format($totalEarnings) }}">0</span>k
                                            </h5>
                                            <p class="text-muted mb-0">Thu nhập</p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-6 col-sm-3">
                                        <div class="p-3 border border-dashed border-start-0">
                                            <h5 class="mb-1"><span class="counter-value" data-target="{{$canceledOrderCount}}">0</span>
                                            </h5>
                                            <p class="text-muted mb-0">Đơn hủy</p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-6 col-sm-3">
                                        <div class="p-3 border border-dashed border-start-0 border-end-0">
                                            <h5 class="mb-1 text-success"><span class="counter-value"
                                                    data-target="{{ number_format($cancelPercentage,2)}}">0</span>%</h5>
                                            <p class="text-muted mb-0">Phần trăm hủy đơn</p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                            </div><!-- end card header -->

                            <div class="card-body p-0 pb-2">
                                <div class="w-100">
                                    <div id="customer_impression_charts"
                                        data-colors='["--vz-primary", "--vz-success", "--vz-danger"]' class="apex-charts"
                                        dir="ltr"></div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                    {{-- end doanh thu --}}

                    <div class="col-xl-4">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Sản phẩm theo danh mục</h4>
                                <div class="flex-shrink-0">
                                    <div class="dropdown card-header-dropdown">
                                      
                                    </div>
                                </div>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div id="store-visits-source"
                                    data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'
                                    class="apex-charts" dir="ltr"></div>
                            </div>
                        </div> <!-- .card-->
                    </div> <!-- .col-->

                    <!-- end col -->
                </div>

                <div class="row">
                    <div class="col-xl-5">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Sản phẩm bán chạy nhất</h4>
                                <div class="flex-shrink-0">
                                    <div class="dropdown card-header-dropdown">
                                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown"
                                           aria-haspopup="true" aria-expanded="false">
                                            <span class="fw-semibold text-uppercase fs-12">Lọc theo:</span>
                                            <span class="text-muted">Hôm nay<i class="mdi mdi-chevron-down ms-1"></i></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">Hôm nay</a>
                                            <a class="dropdown-item" href="#">Hôm qua</a>
                                            <a class="dropdown-item" href="#">7 Ngày qua</a>
                                            <a class="dropdown-item" href="#">30 Ngày qua</a>
                                            <a class="dropdown-item" href="#">Tháng này</a>
                                            <a class="dropdown-item" href="#">Tháng trước</a>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card header -->
                    
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table table-hover table-centered align-middle table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th>Giá</th>
                                                <th>Đã bán</th>
                                                <th>Số lượng</th>
                                                <th>Tổng tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($bestSellingProducts as $product)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm bg-light rounded p-1 me-2">
                                                                <img src="{{ $product->thumbnail }}" alt="" class="img-fluid d-block" />
                                                            </div>
                                                            <div>
                                                                <h5 class="fs-14 my-1">
                                                                    <a href="" class="text-reset">{{ $product->name }}</a>
                                                                </h5>
                                                                <span class="text-muted">{{ \Carbon\Carbon::parse($product->created_at)->format('d/m/Y') }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <h5 class="fs-14 my-1 fw-normal">{{ number_format($product->price) }}₫</h5>
                                                        <span class="text-muted">Giá</span>
                                                    </td>
                                                    <td>
                                                        <h5 class="fs-14 my-1 fw-normal">{{ $product->orderItems->sum('qty') }}</h5>
                                                        <span class="text-muted">Số lượng</span>
                                                    </td>
                                                    <td>
                                                        <h5 class="fs-14 my-1 fw-normal">{{ $product->qty }}</h5>
                                                        <span class="text-muted">Sản phẩm</span>
                                                    </td>
                                                    <td>
                                                        <h5 class="fs-14 my-1 fw-normal">{{ number_format($product->orderItems->sum('qty') * $product->price) }}₫</h5>
                                                        <span class="text-muted">Tổng tiền</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    
                                </div>
                    
                                <div class="align-items-center mt-4 pt-2 justify-content-between row text-center text-sm-start">
                                   
                                    <div class="">
                                        {{ $bestSellingProducts->appends(request()->except('bestSellingPage'))->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <div class="col-xl-7">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Đơn hàng gần đây</h4>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-soft-info btn-sm">
                                        <i class="ri-file-list-3-line align-middle"></i> Generate Report
                                    </button>
                                </div>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                        <thead class="text-muted table-light">
                                            <tr>
                                                <th scope="col">Mã đơn</th>
                                                <th scope="col">Khách hàng</th>
                                                <th scope="col">Tổng tiền</th>
                                                <th scope="col">Thanh toán</th>
                                                <th scope="col">Đơn hàng</th>
                                                <th scope="col">Ngày tạo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($ordersview as $order)
                                                <tr>
                                                    <td>
                                                        <a href="apps-ecommerce-order-details.html" class="fw-medium link-primary">#{{ $order->order_code }}</a>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 me-2">
                                                                <img src="{{ $order->user->cover ? asset('storage/' .$order->user->cover) : asset('theme/admin/assets/images/users/user-dummy-img.jpg') }}" alt="" class="avatar-xs rounded-circle" />
                                                            </div>
                                                            <div class="flex-grow-1">{{ $order->user->full_name }}</div> <!-- Tên khách hàng -->
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-success">{{ number_format($order->total_amount) }}₫</span> <!-- Tổng tiền -->
                                                    </td>
                                                    <td>
                                                        @if ($order->payment_status === 'Chưa thanh toán')
                                                        <span class="badge bg-warning">Chưa thanh toán</span>
                                                        @else
                                                            <span class="badge bg-success">{{ $order->payment_status }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($order->order_status === 'Đã giao')
                                                        <span class="badge bg-success">Đã giao</span>
                                                    @elseif ($order->order_status === 'Đang giao')
                                                        <span class="badge bg-info">Đang giao</span>
                                                    @elseif($order->order_status === 'Đã hủy')
                                                        <span class="badge bg-danger">Đã Hủy</span>
                                                    @else
                                                    <span class="badge bg-warning">Đang xử lý</span>
                                                    @endif <!-- Trạng thái đơn hàng -->
                                                    </td>
                                                    <td>
                                                        {{ $order->created_at->format('d/m/Y') }} <!-- Ngày tạo -->
                                                    </td>
                                                </tr><!-- end tr -->
                                            @endforeach
                                        </tbody><!-- end tbody -->
                                    </table><!-- end table -->
                                    
                                    
                                </div>
                            </div>
                        </div> <!-- .card-->
                    </div> <!-- .col-->
                    <!-- .col-->
                </div> <!-- end row-->

                <div class="row">


                </div> <!-- end row-->

            </div> <!-- end .h-100-->

        </div> <!-- end col -->

       
    </div>

    </div>
    <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>
                        document.write(new Date().getFullYear())
                    </script> © Velzon.
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        Design & Develop by Themesbrand
                    </div>
                </div>
            </div>
        </div>
    </footer>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const counters = document.querySelectorAll('.counter-value');

            counters.forEach(counter => {
                const target = parseFloat(counter.getAttribute('data-target').replace(/,/g,
                    '')); // Lấy giá trị target và loại bỏ dấu phẩy
                let count = 0; // Khởi tạo giá trị hiện tại

                const increment = target / 200; // Tốc độ tăng (có thể điều chỉnh)

                const updateCount = () => {
                    if (count < target) {
                        count += increment; // Tăng giá trị hiện tại
                        counter.innerText = Math.ceil(count)
                            .toLocaleString(); // Định dạng số và cập nhật
                        requestAnimationFrame(updateCount); // Gọi lại hàm để cập nhật liên tục
                    } else {
                        counter.innerText = target
                            .toLocaleString(); // Đảm bảo dừng đúng target và định dạng số
                    }
                };

                updateCount(); // Bắt đầu cập nhật
            });
        });


        // Truyền dữ liệu từ Laravel vào JavaScript
        function getChartColorsArray(e) {
            if (null !== document.getElementById(e)) {
                var t = document.getElementById(e).getAttribute("data-colors");
                if (t)
                    return (t = JSON.parse(t)).map(function(e) {
                        var t = e.replace(" ", "");
                        return -1 === t.indexOf(",") ?
                            getComputedStyle(
                                document.documentElement
                            ).getPropertyValue(t) || t :
                            2 == (e = e.split(",")).length ?
                            "rgba(" +
                            getComputedStyle(
                                document.documentElement
                            ).getPropertyValue(e[0]) +
                            "," +
                            e[1] +
                            ")" :
                            t;
                    });
                console.warn("data-colors atributes not found on", e);
            }
        }
        var ordersData = @json(array_values($orders));
        var incomeData = @json(array_values($income));
        var canceledData = @json(array_values($canceled));

        var linechartcustomerColors = getChartColorsArray("customer_impression_charts");

        var options = {
            series: [{
                    name: "Đơn hàng",
                    type: "area",
                    data: ordersData
                },
                {
                    name: "Thu nhập",
                    type: "bar",
                    data: incomeData
                },
                {
                    name: "Hủy đơn",
                    type: "line",
                    data: canceledData
                },
            ],
            chart: {
                height: 370,
                type: "line",
                toolbar: {
                    show: false
                }
            },
            stroke: {
                curve: "straight",
                dashArray: [0, 0, 8],
                width: [2, 0, 2.2]
            },
            fill: {
                opacity: [0.1, 0.9, 1]
            },
            markers: {
                size: [0, 0, 0],
                strokeWidth: 2,
                hover: {
                    size: 4
                }
            },
            xaxis: {
                categories: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
                axisTicks: {
                    show: false
                },
                axisBorder: {
                    show: false
                },
            },
            grid: {
                show: true,
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
                padding: {
                    top: 0,
                    right: -2,
                    bottom: 15,
                    left: 10
                },
            },
            legend: {
                show: true,
                horizontalAlign: "center",
                offsetX: 0,
                offsetY: -5,
                markers: {
                    width: 9,
                    height: 9,
                    radius: 6
                },
                itemMargin: {
                    horizontal: 10,
                    vertical: 0
                },
            },
            plotOptions: {
                bar: {
                    columnWidth: "30%",
                    barHeight: "70%"
                }
            },
            colors: linechartcustomerColors,
            tooltip: {
                shared: true,
                y: [{
                        formatter: function(e) {
                            return e !== undefined ? e.toFixed(0) : e;
                        },
                    },
                    {
                        formatter: function(e) {
                            return e !== undefined ? e.toFixed(0) + "k" : e;
                        },
                    },
                    {
                        formatter: function(e) {
                            return e !== undefined ? e.toFixed(0) : e;
                        },
                    },
                ],
            },
        };

        var chart = new ApexCharts(
            document.querySelector("#customer_impression_charts"),
            options
        );
        chart.render();
    </script>
@endsection
