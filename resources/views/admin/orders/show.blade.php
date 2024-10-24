@extends('admin.layouts.master')

@section('title', 'Chi tiết đơn hàng')

@section('content')

<div class="row">
    <div class="col-xl-9">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h5 class="card-title flex-grow-1 mb-0">Đơn hàng: #{{ $order->order_code }}
                        @if ($order->order_status === 'Đã giao')
                        <span class="badge bg-success">Đã giao</span>
                    @elseif ($order->order_status === 'Đang giao')
                        <span class="badge bg-info">Đang giao</span>
                    @elseif($order->order_status === 'Đã hủy')
                        <span class="badge bg-danger">Đã Hủy</span>
                    @else
                    <span class="badge bg-warning">Đang xử lý</span>
                    @endif
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
                                <th scope="col">Sản phẩm</th>
                                <th scope="col">Đánh giá</th>
                                <th scope="col" class="text-center">Giá sản phẩm</th>
                                <th scope="col" class="text-center">Số lượng</th>
                                
                                <th scope="col" class="text-center">Tổng tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($order->items && $order->items->count() > 0)
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                <img src="{{ asset('storage/' . $item->product_thumbnail) }}" 
                                                     alt="{{ $item->product_name }}" class="img-fluid d-block">
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h5 class="fs-15">
                                                    <a href="#" class="link-primary">{{ $item->product_name }}</a>
                                                </h5>
                                                @if($item->variant_color)
                                                <p class="text-muted mb-0">Màu sắc: <span class="fw-medium">{{ $item->variant_color }}</span></p>
                                            @endif
                                            
                                            @if($item->variant_size)
                                                <p class="text-muted mb-0">Size: <span class="fw-medium">{{ $item->variant_size }}</span></p>
                                            @endif
                                            
                                            @if($item->variant_weight)
                                                <p class="text-muted mb-0">Trọng lượng (gam): <span class="fw-medium">{{ (int) $item->variant_weight }}</span></p>
                                            @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-warning fs-15">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="ri-star{{ $i <= $item->rating ? '-fill' : '-line' }}"></i>
                                            @endfor
                                        </div>
                                    </td>
                                    <td class="text-center">{{ number_format($item->price) }}₫</td>
                                    <td class="text-center">{{ $item->qty }}</td>
                                   
                                    <td class="fw-medium text-center">
                                        {{ number_format($item->price * $item->qty) }}₫
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">Không có sản phẩm nào.</td>
                                </tr>
                            @endif
                    
                            <tr class="border-top border-top-dashed">
                                <td colspan="3"></td>
                                <td colspan="2" class="fw-medium p-0">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <td>Tổng tiền :</td>
                                                <td class="text-end">{{ number_format($order->total_amount) }}₫</td>
                                            </tr>
                                            <tr>
                                                <td>Khuyến mãi ({{ $order->discount }}) :</td>
                                                <td class="text-end">-{{ number_format($order->discount) }}₫</td>
                                            </tr>
                                            <tr>
                                                <td>Phí vận chuyển :</td>
                                                <td class="text-end">{{ number_format($order->shipping_fee) }}₫</td>
                                            </tr>
                                           
                                            <tr class="border-top border-top-dashed">
                                                <th scope="row">Số tiền phải trả (VND) :</th>
                                                <th class="text-end">{{ number_format($order->total_amount - ($order->discount ?? 0) + $order->shipping_fee, 0, ',', '.') }}₫</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
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
                    <h5 class="card-title flex-grow-1 mb-0"><i class=" ri-user-2-line align-middle me-1 text-muted"></i>Thông tin khách hàng</h5>
                    
                </div>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0 vstack gap-3">
                    <li>
                        <div class="d-flex align-items-center mb-3">
                           
                                <img src="{{ $customer->cover ? asset('storage/' . $customer->cover) : asset('theme/admin/assets/images/users/user-dummy-img.jpg') }}"
                                alt=""
                                class="avatar-sm rounded me-3">
                            <div>
                                <h6 class="fs-14 mb-1">{{ $customer->full_name }}</h6>
                                <p class="text-muted mb-0">Khách hàng</p>
                            </div>
                        </div>
                    </li>
                    <li><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i>{{$customer->email
                        }}</li>
                    <li><i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>{{
                        $customer->phone }}
                    </li>
                </ul>
            </div>
        </div>
        <!--end card-->
        <div class="card mb-4">
            <div class="card-header" style="padding: 10px 15px;">
                <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i>Địa chỉ giao hàng</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0 vstack gap-3">
                    <li>
                        <div class="d-flex  mb-3">
                            <i class="ri-map-pin-line me-2 align-middle text-muted fs-16"></i>
                            <strong style="width: 100px">Địa chỉ:</strong> 
                            <span class="ms-2 text-secondary">
                                @if($order->user_id)
                                    {{-- Lấy địa chỉ mặc định từ bảng user_addresses nếu có user_id --}}
                                    @php
                                        $defaultAddress = $customer->addresses->firstWhere('is_default', 1);
                                    @endphp
                                    {{ $defaultAddress->address ?? 'Không có địa chỉ mặc định' }}
                                @else
                                    {{-- Lấy địa chỉ từ bảng orders nếu không có user_id --}}
                                    {{ $order->user_address ?? 'Không có địa chỉ' }}
                                @endif
                            </span>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex align-items-center mb-3">
                            <i class="ri-book-open-line me-2"></i>
                            <strong class="text-primary">Ghi chú:</strong>
                            <span class="ms-2 text-secondary">{{ $order->user_note ?? 'Không có ghi chú' }}</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="ri-secure-payment-line align-bottom me-1 text-muted"></i>Chi tiết thanh toán</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="flex-shrink-0">
                        <p class="text-muted mb-0">Mã giao dịch :</p>
                    </div>
                    <div class="flex-grow-1 ms-2">
                        <h6 class="mb-0">{{ $order->payment->transaction_id }}</h6>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <div class="flex-shrink-0">
                        <p class="text-muted mb-0">Phương thức thanh toán :</p>
                    </div>
                    <div class="flex-grow-1 ms-2">
                        <h6 class="mb-0"> {{ $order->payment_method }}</h6>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <div class="flex-shrink-0">
                        <p class="text-muted mb-0">Trạng thái :</p>
                    </div>
                    <div class="flex-grow-1 ms-2">
                        <h6 class="mb-0"> 
                            @if ($order->payment_status === 'Chưa thanh toán')
                            <span class="badge bg-warning">Chưa thanh toán</span>
                            @else
                                <span class="badge bg-success">{{ $order->payment_status }}</span>
                            @endif
                        </h6>
                    </div>
                </div>
              
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <p class="text-muted mb-0">Tổng tiền thanh toán:</p>
                    </div>
                    <div class="flex-grow-1 ms-2">
                        <h6 class="mb-0">{{ number_format($order->total_amount - ($order->discount ?? 0) + $order->shipping_fee, 0, ',', '.') }}₫</h6>
                    </div>
                </div>
            </div>
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!--end row-->
<!-- Nút quay lại -->
<div class="text-end mb-2">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Danh sách đơn hàng</a>
</div>
</div>
</div>

@endsection