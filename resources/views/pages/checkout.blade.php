@extends('layouts.master')

@section('title', 'Thông tin thanh toán')

@section('content')
    <!-- Site Content -->
    <div style="padding: 20px 0">
        <div class="container">
            <div class="row py-5">
                <div class="col-lg-8 col-md-7 col-sm-6 col-xs-12">
                    <div class="checkout-info">
                        <div>
                            <div class="col-title">
                                <h3>Thông Tin Mua Hàng</h3>
                            </div>
                            <div class="form-checkout">
                                <form action="{{ route('payment') }}" method="POST" accept-charset="utf-8"
                                    buy-method="{{ $buy_method ?? null }}">

                                    <div class="form-group">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input name="email" type="email" class="form-control"
                                            @error('email') is-invalid @enderror" id="email" autocomplete="email"
                                            value="{{ old('email') ?: Auth::user()->email ?? null }}" required>
                                        <div class="messages"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Họ Và Tên <span class="text-danger">*</span></label>
                                        <input name="name" type="text" class="form-control" id="name"
                                            autocomplete="name" value="{{ Auth::user()->name ?? null }}" required>
                                        <div class="messages"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Số Điện Thoại <span class="text-danger">*</span></label>
                                        <input name="phone" type="tel" class="form-control" id="phone"
                                            autocomplete="phone" value="{{ Auth::user()->phone ?? null }}" required>
                                        <div class="messages"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="address">Địa Chỉ <span class="text-danger">*</span></label>
                                        <input name="address" type="text" class="form-control" id="address"
                                            autocomplete="address" value="{{ Auth::user()->address ?? null }}"
                                            required>
                                        <div class="messages"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="note">Ghi Chú</label>
                                        <textarea name="note" type="text" class="form-control" id="note" rows="3"></textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div>
                            <div class="col-title margin-bottom34 margin-top20">
                                <h3>Phương Thức Giao hàng</h3>
                            </div>
                            <div class="col-content">
                                <div class="shipping-methods">
                                    <ul class="list-content">
                                        @php
                                            $shipping_methods = Helper::get_shipping_methods();
                                        @endphp
                                        @foreach ($shipping_methods as $key => $shipping_method)
                                            <li class="active">
                                                <label>
                                                    <input type="radio" value="{{ $shipping_method['price'] }}"
                                                        name="shipping_method"
                                                        data-route-update-fee="{{route('update_fee')}}"
                                                        @if ($key == 0) checked @endif>
                                                    {{ $shipping_method['name'] }}
                                                </label>
                                                <div class="box-content">
                                                    <p>{{ number_format($shipping_method["price"], 0, ',', '.') }}₫</p>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="col-title margin-bottom34 margin-top20">
                                <h3>Phương Thức Thanh Toán</h3>
                            </div>
                            <div class="col-content">
                                <div class="payment-methods">
                                    <ul class="list-content">
                                        @foreach ($payment_methods as $key => $payment_method)
                                            <li class="active">
                                                <label>
                                                    <input type="radio" value="{{ $payment_method->id }}"
                                                        name="payment_method"
                                                        @if ($key == 0) checked @endif>
                                                    {{ $payment_method->name }}
                                                </label>
                                                <div class="box-content">
                                                    <p>{{ $payment_method->describe }}</p>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                    <div class="col-order">
                        <div class="col-header">
                            <h2>Đơn Hàng <span data-qty="{{ $cart->totalQty }}">( {{ $cart->totalQty }} Sản Phẩm
                                    )</span>
                            </h2>
                        </div>
                        <div class="col-content">
                            <div class="section-items">
                                @foreach ($cart->items as $item)
                                    <div class="item" data-product="{{ $item['item']->id }}"
                                        data-price="{{ $item['price'] }}">
                                        <div class="image-item">
                                            <img
                                                src="{{ Helper::get_image_product_url($item['item']->product->image) }}"
                                                onError="this.onerror=null; this.src='{{ asset('images/no_image.png') }}';" />
                                            <span>{{ $item['qty'] }}</span>
                                        </div>
                                        <div class="info">
                                            <div class="name">{{ $item['item']->product->name }}</div>
                                            <div class="color">{{ $item['item']->color }}</div>
                                        </div>
                                        <div class="price">{{ number_format($item['price'], 0, ',', '.') }}₫</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="section-price">
                                <div class="temp-total-price">
                                    <div class="title">Tạm Tính</div>
                                    <div class="price" data-temp-total-price="{{$cart->totalPrice}}">{{ number_format($cart->totalPrice, 0, ',', '.') }}₫</div>
                                </div>
                                <div class="ship-price">
                                    <div class="title">Phí Vận Chuyển</div>
                                    <div class="price">0₫</div>
                                </div>
                                @if (Auth::check())
                                    <div class="apply-coupon">
                                        <button type="button" class="btn btn-primary" id="apply-coupon-btn" data-url="{{ route('user_coupons') }}">Áp Dụng Mã Giảm Giá</button>
                                    </div>
                                @endif
                                <div class="discount-info" style="display: none;">
                                    <div class="title">Giảm Giá</div>
                                    <div class="applied-coupon"></div>
                                    <div class="discount-amount" data-discount-amount="0"></div>
                                </div>
                                <div class="total-price">
                                    <div class="title">Tổng Cộng</div>
                                    <div class="price" data-price="{{ $cart->totalPrice }}">
                                        {{ number_format($cart->totalPrice, 0, ',', '.') }}₫</div>
                                </div>
                            </div>
                            <div class="btn-order">
                                <button type="submit" class="btn btn-default">Đặt Hàng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Coupon Modal -->
            <div class="modal fade" id="couponModal" tabindex="-1" role="dialog" aria-labelledby="couponModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div style="display: flex; justify-content: space-between;">
                                <h5 class="modal-title" id="couponModalLabel" style="font-weight: bold;">Chọn Mã Giảm Giá</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        <div class="modal-body">
                            <form id="coupon-form" class="coupon-list">
                                <!-- Coupons will be loaded here via AJAX -->
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="button" class="btn btn-primary" id="apply-coupon" data-validate-url="{{ route('validate_coupon') }}">Áp Dụng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endsection
@section('js')
    <script src="{{ asset('common/js/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('common/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('common/js/sweetalert2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
    <script src="{{ asset('js/checkout.js') }}"></script>
@endsection
