{{-- @extends('admin.layouts.master')

@section('title')
Đơn hàng
@endsection

@section('style-libs')
<link href="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('script-libs')
<style>
    .card-body {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 15px;
        /* Điều chỉnh khoảng cách giữa các nút */
    }

    .btn {
        padding: 10px 20px;
        /* Tăng khoảng cách bên trong nút nếu cần */
    }

    .text-end {
        text-align: right;
        /* Căn chỉnh văn bản bên phải */
    }
</style>
<script src="{{ asset('theme/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('theme/admin/vendor/select2/select2.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
        $('.js-example-basic-single').select2();
    });

    // Xử lý in
    document.getElementById('btn-print').addEventListener('click', function () {
        window.print();
    });
</script>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xxl-9">
        <div class="card" id="demo">
            <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-header border-bottom-dashed p-4">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <img src="assets/images/logo-dark.png" class="card-logo card-logo-dark" alt="logo dark" height="17">
                                                    <img src="assets/images/logo-light.png" class="card-logo card-logo-light" alt="logo light" height="17">
                                                    <div class="mt-sm-5 mt-4">
                                                        <h6 class="text-muted text-uppercase fw-semibold">Địa chỉ:</h6>
                                                        <p class="text-muted mb-1" id="address-details">Hà Nội</p>
                                                        <p class="text-muted mb-0" id="zip-code"><span>Zip-code:</span> 90201</p>
                                                    </div>
                                                </div>
                                                <div class="flex-shrink-0 mt-sm-0 mt-3">
        
                                                    <h6><span class="text-muted fw-normal">Email:</span><span id="email">Huybqph36479@fpt.edu.vn</span></h6>
                                                    <h6><span class="text-muted fw-normal">Website:</span> <a href="https://themesbrand.com/" class="link-primary" target="_blank" id="website">huybui.com</a></h6>
                                                    <h6 class="mb-0"><span class="text-muted fw-normal">Liên hệ: </span><span id="contact-no"> +(85)333109261</span></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end card-header-->
                                    </div><!--end col-->
                <div class="col-lg-12">
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-lg-3 col-6">
                                <p class="text-muted mb-2 text-uppercase fw-semibold">Mã đơn</p>
                                <h5 class="fs-14 mb-0">#VL<span id="invoice-no">{{ $order->order_code }}</span></h5>
                            </div>
                            <div class="col-lg-3 col-6">
                                <p class="text-muted mb-2 text-uppercase fw-semibold">Ngày</p>
                                <h5 class="fs-14 mb-0"><span id="invoice-date">{{ $order->created_at->format('d M, Y')
                                        }}</span> <small class="text-muted" id="invoice-time">{{
                                        $order->created_at->format('h:i A') }}</small></h5>
                            </div>
                            <div class="col-lg-3 col-6">
                                <p class="text-muted mb-2 text-uppercase fw-semibold">Trạng thái thanh toán</p>
                                <span class="" id="payment-status">
                                            @if($order->status_order === 'Hoàn thành')
                                                <span class="badge bg-success">Hoàn thành</span>
                                            @elseif($order->status_order === 'Chưa giải quyết')
                                                <span class="badge bg-warning">Chưa giải quyết</span>   
                                            @elseif($order->status_order === 'Đã hủy')
                                                <span class="badge bg-danger">Đã hủy</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $order->status_order }}</span> <!-- Trạng thái khác -->
                                            @endif
                                </span>
                            </div>
                            <div class="col-lg-3 col-6">
                                <p class="text-muted mb-2 text-uppercase fw-semibold">Tổng số tiền</p>
                                <h5 class="fs-14 mb-0"><span id="total-amount"> {{ number_format($order->total_price -
                                        ($order->discount_price ?? 0) + $order->shipping_fee, 0, ',', '.') }}</span>₫
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card-body p-4 border-top border-top-dashed">
                        <div class="row g-3">
                            <div class="col-6">
                                <h6 class="text-muted text-uppercase fw-semibold mb-3">Địa chỉ thanh toán</h6>
                                <p class="fw-medium mb-2" id="billing-name">{{ $order->user_name }}</p>
                                <p class="text-muted mb-1" id="billing-address-line-1">{{ $order->user_address }}</p>
                                <p class="text-muted mb-1"><span>Số điện thoại: </span><span id="billing-phone-no">{{
                                        $order-> user_phone }}</span></p>
                                <p class="text-muted mb-0"><span>Chi tiết: </span><span id="billing-tax-no">{{
                                        $order->user_note }}</span></p>
                            </div>
                            <div class="col-6">
                                <h6 class="text-muted text-uppercase fw-semibold mb-3">Địa chỉ giao hàng</h6>
                                <p class="fw-medium mb-2" id="billing-name">{{ $order->user_name}}</p>
                                <p class="text-muted mb-1" id="billing-address-line-1">{{ $order->user_address }}</p>
                                <p class="text-muted mb-1"><span>Số điện thoại: </span><span id="billing-phone-no">{{
                                        $order-> user_phone }}</span></p>
                                <p class="text-muted mb-0"><span>Chi tiết: </span><span id="billing-tax-no">{{
                                        $order->user_note }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                <thead>
                                    <tr class="table-active">
                                        <th scope="col" style="width: 15%;">#</th>
                                        <th scope="col" style="width: 50%;">Chi tiết sản phẩm</th>
                                        <th scope="col" style="width: 20%;">Giá</th>       
                                        <th scope="col" style="width: 5%;">Số lượng</th>
                                        <th scope="col" class="text-end" style="width: 5%;">Tổng tiền</th>
                                    </tr>
                                </thead>
                                <tbody id="order-items-list">
                                    @foreach($orderItems as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="text-start">
                                            <span class="fw-medium">{{$item->product_name }}</span>
                                            <p class="text-muted mb-0">Color: <span class="fw-medium">{{
                                                    $item->variant_color_name }}</span></p>
                                            <p class="text-muted mb-0">Size: <span class="fw-medium">{{
                                                    $item->variant_size_name }}</span></p>
                                        </td>
                                        <td>
                                            
                                            {{ number_format($item->product_price_sale, 0, ',', '.') }}₫
                                          
                                        </td>
                                        <td>{{ $item->qty }}</td>
                                        <td class="text-end">{{ number_format($item->product_price_sale * $item->qty)
                                            }}₫</td>
                                    </tr>
                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr class="border-top border-top-dashed">
                                        <td colspan="4"></td>
                                        <td colspan="1" class="fw-medium p-0">
                                            <table class="table table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="text-start">Tổng tiền :</td>
                                                        <td class="text-end">
                                                            {{ number_format($orderItems->sum(function($item) {
                                                            return $item->product_price_sale ?
                                                            $item->product_price_sale * $item->qty :
                                                            $item->product_price * $item->qty;
                                                            }), 0, ',', '.') }}₫
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-start">Giảm giá:</td>
                                                        <td class="text-end">
                                                            {{ number_format($order->discount_price ?? 0, 0, ',', '.')
                                                            }}₫
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-start">Phí vận chuyển:</td>
                                                        <td class="text-end">
                                                            {{ number_format($order->shipping_fee, 0, ',', '.') }}₫
                                                        </td>
                                                    </tr>
                                                    <tr class="border-top border-top-dashed">
                                                        <th class="text-start" scope="row">Tổng tiền:</th>
                                                        <th class="text-end">
                                                            {{ number_format($order->total_price -
                                                            ($order->discount_price ?? 0) + $order->shipping_fee, 0,
                                                            ',', '.') }}₫
                                                        </th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div
                        class="card-body p-4 text-end border-top border-top-dashed d-flex justify-content-end align-items-center gap-3">
                        <a href="javascript:window.print()" class="btn btn-success">
                            <i class="ri-printer-line align-bottom me-1"></i> In
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
