@extends('layouts.master')

@section('title', 'Đánh giá')

@section('content')

    <section class="bread-crumb">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home_page') }}">{{ __('Trang Chủ') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Đánh Giá Sản Phẩm</li>
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
                <h2 class="section-title">Đánh Giá Sản Phẩm</h2>
            </div>
            <div class="section-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="orders-table">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">STT</th>
                                            <th class="text-center">Mã<br>Đơn Hàng</th>
                                            <th class="text-center">Tên Sản Phẩm</th>
                                            <th class="text-center">Giá Tiền</th>
                                            <th class="text-center">Số Lượng</th>
                                            <th class="text-center">Thành Tiền</th>
                                            <th class="text-center">Nội dung đánh giá</th>
                                            <th class="text-center">Trạng Thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['productVotes'] as $key => $order)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td class="text-center">
                                                    {{ $order->order->order_code }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('product_page', ['id' => $order->variants->product->id]) }}"
                                                        title="Chi tiết đơn hàng: 1">{{ $order->variants->product->name }}
                                                        <span>({{ explode('-', $order->variants->sku)[1] ?? $order->variants->sku }})
                                                        </span>
                                                    </a>
                                                </td>
                                                <td class="text-center" style="color: #f30;">
                                                    {{ number_format($order->price, 0, ',', '.') }}₫</td>
                                                </td>
                                                <td class="text-center" style="color: #f30;">
                                                    {{ $order->quantity }}</td>
                                                </td>
                                                <td class="text-center" style="color: #f30;">
                                                    {{ number_format(($order->quantity *$order->price), 0, ',', '.') }}₫</td>
                                                </td>
                                                <td class="text-center">
                                                    @if ($order->product_votes)
                                                        <div>
                                                            <div>
                                                                @php
                                                                    $rate = $order->product_votes->rate ?? 0; // Lấy giá trị rate hoặc mặc định là 0 nếu null
                                                                @endphp

                                                                {{-- Hiển thị sao vàng cho số sao tương ứng với rate --}}
                                                                @for ($i = 1; $i <= floor($rate); $i++)
                                                                    <i class="fa fa-star text-danger"></i>
                                                                @endfor

                                                                {{-- Hiển thị sao nửa nếu rate có phần thập phân --}}
                                                                @if ($rate - floor($rate) >= 0.5)
                                                                    <i class="fa fa-star-half-alt text-warning"></i>
                                                                @endif

                                                                {{-- Hiển thị sao xám cho các sao còn lại --}}
                                                                @for ($i = ceil($rate); $i < 5; $i++)
                                                                    <i class="fa fa-star text-secondary"></i>
                                                                @endfor
                                                            </div>

                                                            <div>{{ $order->product_votes->content }}</div>
                                                        </div>
                                                    @else
                                                        <span class="label label-warning">Chưa đánh giá</span>
                                                    @endif
                                                </td>
                                                <td
                                                    style="display:flex; justify-content:center; align-items:center;padding-top:10px">
                                                    @if ($order->product_votes)
                                                        <span class="label label-success">Đã đánh giá</span>
                                                    @else
                                                        <button class="btn btn-primary"
                                                            onclick="showRatingModal({{ $order->id }})">Đánh
                                                            giá</button>
                                                    @endif
                                                </td>

                                            </tr>

                                            <!-- Modal Đánh giá -->
                                            <div class="modal fade" id="ratingModal" tabindex="-1" role="dialog"
                                                aria-labelledby="ratingModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3 class="modal-title" id="ratingModalLabel">Đánh giá sản phẩm
                                                            </h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="ratingForm">
                                                                <input type="hidden" name="order_detail_id" id="order_detail_id"
                                                                    value="{{ $order->id }}">
                                                                <input type="hidden" name="user_id" id="user_id"
                                                                    value="{{ $order->order->user_id }}">
                                                                <div class="form-group">
                                                                    <label for="rate">Đánh giá:</label>
                                                                    <div id="rate-stars">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            <!-- Input radio ẩn -->
                                                                            <input type="radio" 
                                                                                id="star-{{ $i }}"
                                                                                name="rate" value="{{ $i }}"
                                                                                style="display: none">
                                                                            <!-- Label cho từng ngôi sao -->
                                                                            <label for="star-{{ $i }}"
                                                                                class="star-label">
                                                                                <i class="fa fa-star text-secondary"></i>
                                                                            </label>
                                                                        @endfor
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="content">Nội dung đánh giá:</label>
                                                                    <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Đóng</button>
                                                            <button type="button" class="btn btn-primary"
                                                                onclick="submitRating()">Gửi đánh giá</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="display: flex; justify-content:center">
                    {{ $data['productVotes']->links() }}
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

        .star-label {
            font-size: 30px;
            cursor: pointer;
            color: #ccc;
            /* Màu xám ban đầu */
            transition: color 0.3s ease;
        }

        /* Thay đổi màu của các ngôi sao khi đã chọn */
        input[type="radio"]:checked~.star-label {
            color: gold;
        }
    </style>
@endsection

@section('js')

    <script>
        function showRatingModal(orderId) {
            $('#order_detail_id').val(orderId); // Gán giá trị order_id vào input ẩn
            $('#ratingModal').modal('show'); // Hiển thị modal
            console.log(orderId);

        }

        function submitRating() {
            const userId = $('#user_id').val();
            const orderId = $('#order_detail_id').val();
            const rate = $('input[name="rate"]:checked').val();
            const content = $('#content').val();

            console.log(orderId, rate, content, userId);
            
            // Kiểm tra dữ liệu trước khi gửi
            if (!rate || !content) {
                Swal.fire('Lỗi!', 'Vui lòng điền đầy đủ thông tin đánh giá.', 'error');
                return;
            }

            $.ajax({
                url: "{{ route('review.store') }}", // Route xử lý
                method: 'POST',
                data: {
                    user_id: userId,
                    order_detail_id: orderId,
                    rate: rate,
                    content: content,
                    _token: `{{ csrf_token() }}`
                },
                success: function(response) {
                    if (response.status) {
                        Swal.fire('Thành công!', response.message, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Thất bại!', response.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Lỗi!', 'Đã xảy ra lỗi trong quá trình xử lý.', 'error');
                }
            });
        }
    </script>

    <script>
        // Thêm sự kiện thay đổi cho radio buttons khi người dùng chọn sao
        document.querySelectorAll('.star-label').forEach(function(label, index) {
            label.addEventListener('click', function() {
                // Đặt màu vàng cho tất cả các sao từ sao 1 đến sao được chọn
                document.querySelectorAll('.star-label').forEach(function(item, i) {
                    if (i <= index) {
                        item.style.color = 'gold'; // Đổi màu vàng cho các sao đã chọn
                    } else {
                        item.style.color = '#ccc'; // Đổi màu xám cho các sao chưa chọn
                    }
                });
            });
        });
    </script>

@endsection
