@extends('layouts.master')

@section('title', 'Đơn Hàng')

@section('content')

    <section class="bread-crumb">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home_page') }}">{{ __('Trang Chủ') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Đơn Hàng</li>
            </ol>
        </nav>
    </section>

    <div class="site-orders">
        <section class="section-advertise">
            <div class="content-advertise">
                <div id="slide-advertise" class="owl-carousel">
                    @foreach ($data['advertises'] as $advertise)
                        <div class="slide-advertise-inner"
                            style="background-image: url('{{ Helper::get_image_advertise_url($advertise->image) }}');"
                            data-dot="<button>{{ $advertise->title }}</button>"></div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section-orders">
            <div class="section-header">
                <h2 class="section-title">Đơn Hàng <span>({{ $data['orders']->count() }} đơn hàng)</span></h2>
            </div>
            <div class="section-content">
                <div class="row">
                    <div class="col-md-10">
                        <div class="orders-table">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">STT</th>
                                            <th class="text-center">Mã<br>Đơn Hàng</th>
                                            <th class="text-center">Phương Thức<br>Thanh Toán</th>
                                            <th class="text-center">Đơn Giá tạm tính</th>
                                            <th class="text-center">Phí giao hàng</th>
                                            <th class="text-center">Giảm giá</th>
                                            <th class="text-center">Tổng tiền thanh toán</th>
                                            <th class="text-center">Trạng thái thanh toán</th>
                                            <th class="text-center">Trạng Thái đơn hàng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['orders'] as $key => $order)
                                            @php
                                                $qty = 0;
                                                $price = 0;
                                                foreach ($order->order_details as $order_detail) {
                                                    $qty = $qty + $order_detail->quantity;
                                                    $price = $price + $order_detail->price * $order_detail->quantity;
                                                }
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td class="text-center"><a
                                                        href="{{ route('order_page', ['id' => $order->id]) }}"
                                                        title="Chi tiết đơn hàng: {{ $order->order_code }}">{{ $order->order_code }}</a>
                                                </td>
                                                <td class="text-center">{{ $order->payment_method->name }}</td>
                                                <td class="text-center" style="color: #f30;">
                                                    {{ number_format($price, 0, ',', '.') }}₫</td>
                                                <td class="text-center">{{ number_format($order->fee, 0, ',', '.') }}₫</td>
                                                <td class="text-center">{{ number_format($order->discount, 0, ',', '.') }}₫
                                                </td>
                                                <td class="text-center" style="color: #f30;">
                                                    {{ number_format($price + $order->fee - $order->discount, 0, ',', '.') }}₫
                                                </td>
                                                <td>{{ $order?->is_paid ? 'Đã thanh toán' : 'Chưa thanh toán' }}</td>
                                                <td class="text-center">
                                                    @switch($order->status)
                                                        @case(1)
                                                            <div style="display:flex">
                                                                <span class="label label-warning" style="margin-right:10px">Chờ xác
                                                                    nhận</span>
                                                                <button class="btn btn-danger"
                                                                    onclick="handleCancelOrder({{ $order->id }})">Huỷ</button>
                                                            </div>
                                                        @break

                                                        @case(2)
                                                            <div style="display:flex">
                                                                <span class="label label-warning" style="margin-right:10px">Đã xác
                                                                    nhận</span>
                                                                <button class="btn btn-danger"
                                                                    onclick="handleCancelOrder({{ $order->id }})">Huỷ</button>
                                                            </div>
                                                        @break

                                                        @case(3)
                                                            <div style="display:flex">
                                                                <span class="label label-primary" style="margin-right:10px">Đang
                                                                    chuẩn bị</span>
                                                                <button class="btn btn-danger"
                                                                    onclick="handleCancelOrder({{ $order->id }})">Huỷ</button>
                                                            </div>
                                                        @break

                                                        @case(4)
                                                            <div style="display:flex">
                                                                <span class="label label-info" style="margin-right:10px">Đang
                                                                    giao</span>
                                                                <button class="btn btn-success"
                                                                    onclick="handleReceiveOrder({{ $order->id }})">Đã
                                                                    nhận</button>
                                                            </div>
                                                        @break

                                                        @case(6)
                                                            <span class="label label-success">Thành công</span>
                                                        @break

                                                        @case(8)
                                                            <span class="label label-danger">Đã hủy</span>
                                                        @break
                                                    @endswitch
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="online_support">
                            <h2 class="title">CHÚNG TÔI LUÔN SẴN SÀNG<br>ĐỂ GIÚP ĐỠ BẠN</h2>
                            <img src="{{ asset('images/support_online.jpg') }}">
                            <h3 class="sub_title">Để được hỗ trợ tốt nhất. Hãy gọi</h3>
                            <div class="phone">
                                <a href="tel:18006750" title="1800 6750" style="font-size: 20px;">0377887668</a>
                            </div>
                            <div class="or"><span>HOẶC</span></div>
                            <h3 class="title">Chat hỗ trợ trực tuyến</h3>
                            <h3 class="sub_title">Chúng tôi luôn trực tuyến 24/7.</h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('css')
    <style>
        .slide-advertise-inner {
            background-repeat: no-repeat;
            background-size: cover;
            padding-top: 21.25%;
        }

        #slide-advertise.owl-carousel .owl-item.active {
            -webkit-animation-name: zoomIn;
            animation-name: zoomIn;
            -webkit-animation-duration: .6s;
            animation-duration: .6s;
        }

        .swal2-popup {
            font-size: 16px;
            border-radius: 10px;
            background-color: #f9f9f9;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            padding: 20px;
            border: 1px solid #ddd;
        }

        .swal2-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .swal2-content {
            font-size: 16px;
            color: #555;
        }

        .swal2-confirm {
            background-color: #3085d6;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .swal2-confirm:hover {
            background-color: #256abc;
        }

        .swal2-cancel {
            background-color: #d33;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .swal2-cancel:hover {
            background-color: #b12c2c;
        }

        .swal2-icon.swal2-warning {
            border-color: #ffcc00;
            color: #ffcc00;
        }
    </style>
@endsection

@section('js')
    <script>
        const handleCancelOrder = (id) => {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn huỷ đơn hàng này?',
                text: "Hành động này không thể hoàn tác!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Huỷ'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('cancelOrder', ['id' => ':id']) }}".replace(':id', id),
                        method: "POST",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire(
                                    'Đã huỷ!',
                                    response?.message,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Huỷ thất bại!',
                                    response?.message,
                                    'error'
                                );
                            }
                        }
                    });
                }
            });
        }
        $(document).ready(function() {
            $("#slide-advertise").owlCarousel({
                items: 2,
                autoplay: true,
                loop: true,
                margin: 10,
                autoplayHoverPause: true,
                nav: true,
                dots: false,
                responsive: {
                    0: {
                        items: 1,
                    },
                    992: {
                        items: 2,
                        animateOut: 'zoomInRight',
                        animateIn: 'zoomOutLeft',
                    }
                },
                navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>']
            });
        });
    </script>

    <script>
        const handleReceiveOrder = (id) => {
            Swal.fire({
                title: 'Bạn chắc chắn đã nhận đơn hàng này?',
                text: "Hành động này không thể hoàn tác!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Huỷ'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('receive_order', ['id' => ':id']) }}".replace(':id', id),
                        method: 'POST',
                        data: {
                            id: id,
                            _token: `{{ csrf_token() }}`
                        },
                        success: function(response) {
                            if (response.status) {
                                Swal.fire(
                                    'Thành công!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Thất bại!',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function() {
                            Swal.fire(
                                'Lỗi!',
                                'Đã xảy ra lỗi trong quá trình xử lý.',
                                'error'
                            );
                        }
                    });
                }
            });
        };
        $(document).ready(function() {

            $("#slide-advertise").owlCarousel({
                items: 2,
                autoplay: true,
                loop: true,
                margin: 10,
                autoplayHoverPause: true,
                nav: true,
                dots: false,
                responsive: {
                    0: {
                        items: 1,
                    },
                    992: {
                        items: 2,
                        animateOut: 'zoomInRight',
                        animateIn: 'zoomOutLeft',
                    }
                },
                navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>']
            });
        });
    </script>

    <script>
        const handleRequestReturn = (id) => {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn hoàn đơn hàng này?',
                text: "Hành động này không thể hoàn tác!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Huỷ',
                html: `
                        <div>
                            <label for="returnReasonInput">Lý do hoàn hàng:</label>
                            <textarea id="returnReasonInput" class="swal2-textarea" placeholder="Nhập lý do hoàn hàng..."></textarea>
                        </div>
                    `
            }).then((result) => {
                if (result.value) {
                    const returnReason = document.getElementById('returnReasonInput').value.trim();
                    console.log('Return reason:', returnReason); // Kiểm tra lý do đã nhập

                    if (!returnReason) {
                        Swal.fire(
                            'Lỗi!',
                            'Vui lòng nhập lý do hoàn hàng!',
                            'error'
                        );
                        return;
                    }
                    $.ajax({
                        url: "{{ route('returnOrder', ['id' => ':id']) }}".replace(':id', id),
                        method: "POST",
                        data: {
                            id: id,
                            return_reason: returnReason, // Lý do hoàn hàng
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            console.log('AJAX response:', response); // Kiểm tra phản hồi AJAX
                            if (response.status === 'success') {
                                Swal.fire(
                                    'Hoàn hàng thành công!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Hoàn hàng thất bại!',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log('AJAX error:', error); // Kiểm tra lỗi AJAX
                            Swal.fire(
                                'Lỗi!',
                                'Đã xảy ra lỗi trong quá trình xử lý.',
                                'error'
                            );
                        }
                    });
                }
            });

        };
    </script>
@endsection
