@extends('layouts.master')

@section('title', 'Tra cứu đơn hàng')

@section('content')

    <section class="bread-crumb">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home_page') }}">{{ __('Trang Chủ') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tra cứu đơn hàng</li>
            </ol>
        </nav>
    </section>

    <div class="site-about">
        <section class="section-advertise">
            <div class="content-advertise">
                <div id="slide-advertise" class="owl-carousel">
                    @foreach ($advertises as $advertise)
                        <div class="slide-advertise-inner"
                            style="background-image: url('{{ Helper::get_image_advertise_url($advertise->image) }}');"
                            data-dot="<button>{{ $advertise->title }}</button>"></div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section-about" style="height: 400px">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Tra cứu đơn hàng</h2>
                    <div class="search-order text-center">
                        <div class="input-group" style="max-width: 400px; margin: 0 auto;">
                            <input type="text" class="form-control" placeholder="Nhập mã đơn hàng..." value="{{ request()->get('order_code') }}" id="order-id">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" onclick="searchOrder()">
                                    <i class="fas fa-search"></i> Tìm kiếm
                                </button>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Thanh tìm kiếm đơn hàng -->
                <div class="order-tracking text-center" style=" display: none; margin-top: 30px;">
                    <!-- Bước 1 -->
                    <div class="order-step completed">
                        <div class="step-icon"><i class="fas fa-spinner"></i></div>
                        <div class="step-text">Chờ xác nhận</div>
                    </div>
                    <!-- Bước 2 -->
                    <div class="order-step completed">
                        <div class="step-icon"><i class="fas fa-check-circle"></i></div>
                        <div class="step-text">Đã xác nhận</div>
                    </div>
                    <!-- Bước 3 -->
                    <div class="order-step completed">
                        <div class="step-icon"><i class="fas fa-truck"></i></div>
                        <div class="step-text">Đang vận chuyển</div>
                    </div>
                    <!-- Bước 4 -->
                    <div class="order-step completed">
                        <div class="step-icon"><i class="fas fa-box"></i></div>
                        <div class="step-text">Đã giao hàng</div>
                    </div>
                    <!-- Bước 5 -->
                    <div class="order-step completed">
                        <div class="step-icon"><i class="fas fa-flag-checkered"></i></div>
                        <div class="step-text">Hoàn tất</div>
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

        .search-order h3 {
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 24px;
        }

        /* Trạng thái đơn hàng */
        .order-tracking {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
        }

        .order-step {
            text-align: center;
            position: relative;
        }

        .order-step .step-icon {
            font-size: 30px;
            background: #ddd;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 10px;
            color: white;
        }

        .order-step.completed .step-icon {
            background-color: #5cb85c;
        }

        .order-step.current .step-icon {
            background-color: #0275d8;
        }

        .order-step .step-text {
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        /* Đường kết nối các bước */
        .order-step::after {
            content: '';
            position: absolute;
            top: 30px;
            left: 50%;
            height: 3px;
            width: 100%;
            background-color: #ddd;
            z-index: -1;
        }

        .order-step:last-child::after {
            display: none;
        }
    </style>
@endsection

@section('js')
    <script>
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
        function searchOrder() {
            var orderId = document.getElementById('order-id').value;

            // Gửi request tìm kiếm đơn hàng
            fetch("{{ route('search') }}", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        order_code: orderId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        alert(data.message); // Nếu không tìm thấy đơn hàng
                    } else {
                        // Hiển thị trạng thái đơn hàng
                        var orderTracking = document.querySelector('.order-tracking');
                        orderTracking.style.display = 'flex';

                        var steps = '';
                        var orderStatus = data.order_status; // Trạng thái đơn hàng (status)
                        var orderCode = data.order_code; // Mã đơn hàng đã nhập
                        console.log(data);
                        
                        var orderCodeDisplay = `<div class="order-code">
                            <strong>Mã đơn hàng:</strong> ${orderCode}
                         </div>`;

                        // Các bước trạng thái đơn hàng
                        var stepsArray = [{
                                icon: 'fas fa-spinner',
                                text: 'Chờ xác nhận'
                            },
                            {
                                icon: 'fas fa-check-circle',
                                text: 'Đã xác nhận'
                            },
                            {
                                icon: 'fas fa-truck',
                                text: 'Đang vận chuyển'
                            },
                            {
                                icon: 'fas fa-box',
                                text: 'Đã giao hàng'
                            },
                            {
                                icon: 'fas fa-flag-checkered',
                                text: 'Hoàn tất'
                            }
                        ];

                        // Duyệt qua các bước và thêm class "completed" nếu trạng thái của đơn hàng đã hoàn thành
                        stepsArray.forEach(function(step, index) {
                            var stepClass = (orderStatus >= (index + 1)) ? 'completed' :
                            ''; // Kiểm tra trạng thái và thêm class completed
                            steps += `<div class="order-step ${stepClass}">
                                      <div class="step-icon"><i class="${step.icon}"></i></div>
                                      <div class="step-text">${step.text}</div>
                                  </div>`;
                        });

                        // Cập nhật lại nội dung của order-tracking
                        orderTracking.innerHTML = orderCodeDisplay + steps;
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endsection
