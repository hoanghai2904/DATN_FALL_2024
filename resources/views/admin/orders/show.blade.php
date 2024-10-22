@extends('admin.layouts.master')

@section('title', 'Chi tiết đơn hàng')

@section('content')

<div class="row">
    <div class="col-xl-9">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h5 class="card-title flex-grow-1 mb-0">Danh sách đơn hàng #{{ $order->order_code }}
                    </h5>
                    <div class="flex-shrink-0">
                        <a href="{{ route('admin.orders.invoice', $order->id) }}" class="btn btn-success btn-sm"><i
                                class="ri-download-2-fill align-middle me-1"></i> In hóa đơn</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table table-nowrap align-middle table-borderless mb-0">
                        <thead class="table-light text-muted">
                            <tr>
                                <th scope="col" style="width:400px">Sản phẩm</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Số Lượng</th>
                                <th scope="col">Đánh giá</th>
                                <th scope="col">Tổng (VND)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($orderItems && $orderItems->count() > 0)
                            @foreach($orderItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                            <img src="{{ asset('storage/' . $item->product_thumbnail) }}" alt="{{ $item->product_name }}" class="img-fluid d-block">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="fs-15"><a href="" class="link-primary">{{
                                                    $item->product_name }}</a>
                                            </h5>
                                            <p class="text-muted mb-0">Color: <span class="fw-medium">{{
                                                    $item->variant_color_name }}</span></p>
                                            <p class="text-muted mb-0">Size: <span class="fw-medium">{{
                                                    $item->variant_size_name }}</span></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($item->product_price_sale)
                                    <span class="text-decoration-line-through">{{
                                        number_format($item->product_price, 0,
                                        ',', '.') }}₫</span>
                                    <span class="text-danger">{{ number_format($item->product_price_sale, 0,
                                        ',', '.')
                                        }}₫</span>
                                    @else
                                    {{ number_format($item->product_price, 0, ',', '.') }}₫
                                    @endif
                                </td>
                                <td>{{ $item->qty }}</td>
                                <td>
                                    <div class="text-warning fs-15">
                                        <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i
                                            class="ri-star-half-fill"></i><i class="ri-star-line"></i><i
                                            class="ri-star-line"></i>
                                    </div>
                                </td>
                                <td class="fw-medium text-end">
                                    @if($item->product_price_sale)
                                    {{ number_format($item->product_price_sale * $item->qty, 0, ',', '.')
                                    }}₫
                                    @else
                                    {{ number_format($item->product_price * $item->qty, 0, ',', '.') }}₫
                                    @endif
                                </td>
                            </tr>

                            <tr class="border-top border-top-dashed">
                                <td colspan="3"></td>
                                <td colspan="2" class="fw-medium p-0">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <td>Tổng tiền :</td>
                                                <td class="text-end">
                                                    {{ number_format($orderItems->sum(function($item) {
                                                    return $item->product_price_sale ?
                                                    $item->product_price_sale * $item->qty :
                                                    $item->product_price * $item->qty;
                                                    }), 0, ',', '.') }}₫
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Giảm giá: <span class="text-muted"></span>
                                                </td>
                                                <td class="text-end">{{
                                                    number_format($order->discount_price ?? 0, 0, ',', '.')
                                                    }}₫</td>
                                            </tr>
                                            <tr>
                                                <td>Phí vận chuyển:</td>
                                                <td class="text-end">{{
                                                    number_format($order->shipping_fee, 0, ',', '.') }}₫
                                                </td>
                                            </tr>

                                            <tr class="border-top border-top-dashed">
                                                <th scope="row">Tổng tiền:</th>
                                                <th class="text-end"> {{ number_format($order->total_price -
                                                    ($order->discount_price ?? 0) +
                                                    $order->shipping_fee, 0, ',', '.') }}₫</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="7" class="text-center">Không có sản phẩm nào trong đơn hàng.
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end card-->

    </div>
    <!--end col-->
    <div class="col-xl-3">
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <h5 class="card-title flex-grow-1 mb-0">Thông tin khách hàng</h5>
                    <div class="flex-shrink-0">
                        <a href="javascript:void(0);" class="link-secondary">Thông tin</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0 vstack gap-3">
                    <li>
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('storage/' . auth()->user()->cover) }}" alt=""
                                class="avatar-sm rounded me-3">
                            <div>
                                <h6 class="fs-14 mb-1">{{ $order->user_name }}</h6>
                                <p class="text-muted mb-0">Khách hàng</p>
                            </div>
                        </div>
                    </li>
                    <li><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i>{{ $order->user_email
                        }}</li>
                    <li><i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>{{
                        $order->user_phone }}
                    </li>
                </ul>
            </div>
        </div>
        <!--end card-->
        <div class="card mb-4">
            <div class="card-header" style="padding: 10px 15px;">
                <h5 class="mb-0">Thông tin giao hàng</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0 vstack gap-3">
                    <li>
                        <div class="d-flex align-items-center mb-3">
                            <i class="ri-user-line me-2 align-middle text-muted fs-16"></i>
                            <strong>Tên người nhận:</strong> {{ $order->user_name }}
                        </div>
                    </li>
                    <li>
                        <div class="d-flex align-items-center mb-3">
                            <i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>
                            <strong>Số điện thoại người nhận:</strong> {{ $order->user_phone }}
                        </div>
                    </li>
                    <li>
                        <div class="d-flex align-items-center mb-3">
                            <i class="ri-map-pin-line me-2 align-middle text-muted fs-16"></i>
                            <strong>Địa chỉ:</strong> {{ $order->user_address }}
                        </div>
                    </li>
                    <li>
                        <div class="d-flex align-items-center mb-3">
                            <i class="ri-money-dollar-circle-line me-2 align-middle text-muted fs-16"></i>
                            <strong>Phương thức:</strong> {{ $order->payment_method }}
                        </div>
                    </li>
                    <li>
                        <div class="d-flex align-items-center mb-3">
                            <i class="ri-notes-line me-2 align-middle text-muted fs-16"></i>
                            <strong>Ghi chú:</strong> {{ $order->shipping_note ?? 'Không có ghi chú' }}
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!--end row-->




<!-- Nút quay lại -->
<div class="text-end">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại danh sách đơn hàng</a>
</div>
</div>
</div>

@endsection