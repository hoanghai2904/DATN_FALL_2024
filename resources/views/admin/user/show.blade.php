@extends('admin.layouts.master')

@section('title', 'Thông tin Khách hàng')

@section('embed-css')
@endsection

@section('custom-css')
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.users') }}"><i class="fa fa-users"></i> Quản Lý Tài Khoản</a></li>
        <li class="active">{{ $user->name }}</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle"
                        src="{{ Helper::get_image_avatar_url($user->avatar_image) }}" alt="User profile picture">

                    <h3 class="profile-username text-center">{{ $user->name }}</h3>

                    @if ($user->active)
                        <p class="text-center"><span class="label label-success">Đã kích hoạt</span></p>
                    @else
                        <p class="text-center"><span class="label label-danger">Chưa kích hoạt</span></p>
                    @endif

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Email</b> <a class="pull-right">{{ $user->email }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Số điện thoại</b> <a class="pull-right">{{ $user->phone }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Liên kết tài khoản</b> <a class="pull-right">{{ $user->provider ?: 'Không' }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Ngày tạo</b> <a class="pull-right">{{ date_format($user->created_at, 'd/m/Y') }}</a>
                        </li>
                    </ul>
                    <strong><i class="fa fa-map-marker margin-r-5"></i> Địa chỉ</strong>
                    <p class="text-muted">{{ $user->address }}</p>
                    @if (!$user->active)
                        <a href="{{ route('admin.user_send', ['id' => $user->id]) }}"
                            class="btn btn-warning btn-block"><b>Kích hoạt tài khoản</b></a>
                    @endif
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#comment-timeline" data-toggle="tab">Lịch Sử Đánh Giá</a></li>
                    <li><a href="#order-timeline" data-toggle="tab">Lịch Sử Mua Hàng</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="comment-timeline">
                        @if ($product_votes->isNotEmpty())
                            <!-- The timeline -->
                            <ul class="timeline timeline-inverse">
                                @foreach ($product_votes as $vote)
                                    <!-- timeline time label -->
                                    <li class="time-label">
                                        <span class="bg-red">
                                            <i class="fa fa-clock-o"></i> {{ date_format($vote->created_at, 'H:i d/m/Y') }}
                                        </span>
                                    </li>
                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->
                                    <li>
                                        <i class="fa fa-comments bg-blue" aria-hidden="true"></i>

                                        <div class="timeline-item">

                                            <h3 class="timeline-header"><a>{{ $user->name }}</a> đã đánh giá
                                                <a>{{ $vote->rate }}</a> sao về sản phẩm
                                                <a>{{ $vote->order_details->variants->product->name }} - ( {{ explode('-', $vote->order_details->variants->sku)[1] ?? $vote->order_details->variants->sku ?? "" }} )</a>
                                            </h3>
                                            
                                            <div class="timeline-body">
                                                {{-- <b>Phản hồi của bạn:</b> <span class="text-success">{{ Auth::user()->name }}</span> --}}
                                                <b>Nội Dung:</b> {{ $vote->content }}
                                                <hr>

                                                @if ($vote->replies->isNotEmpty())
                                                    <div class="timeline-replies mt-3">
                                                        @foreach ($vote->replies as $reply)
                                                            <!-- Thời gian phản hồi -->
                                                            <span class="text-muted small">
                                                                {{ $reply->created_at->format('H:i d/m/Y') }}
                                                            </span>
                                                            <div class="reply-item mb-3">
                                                                <!-- Tên người phản hồi -->
                                                                <b class="text-primary">{{ $reply->user->name }}</b>: {{ $reply->content }}

                                                                {{-- <hr> --}}

                                                                <!-- Hiển thị các phản hồi con -->
                                                                @if ($reply->replies->isNotEmpty())
                                                                    <div class="replies-children ms-4">
                                                                        @foreach ($reply->replies as $childReply)
                                                                            <div class="reply-item mb-2">
                                                                                <b
                                                                                    class="text-secondary">{{ $childReply->user->name }}</b>
                                                                                trả lời:
                                                                                <p class="mb-1">
                                                                                    {{ $childReply->content }}</p>
                                                                                <span class="text-muted small">
                                                                                    {{ $childReply->created_at->format('H:i d/m/Y') }}
                                                                                </span>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="text-muted mt-3">Chưa có phản hồi nào.</p>
                                                @endif
                                            </div>




                                            <div class="timeline-footer"
                                                style="display: flex;justify-content: space-between; align-items: center;">
                                                <span class="label label-warning">{{ $vote->rate }} Sao</span>
                                                <button class="btn btn-primary reply-toggle-btn"
                                                    data-id="{{ $vote->id }}">Trả lời</button>
                                            </div>

                                            <!-- Form trả lời -->
                                            <div>
                                                <form action="{{ route('admin.vote.reply', $vote->id) }}" method="POST"
                                                    class="mt-2 reply-form" id="reply-form-{{ $vote->id }}"
                                                    style="display: none;padding: 20px">
                                                    @csrf
                                                    <input type="hidden" name="order_detail_id" value="{{ $vote->order_detail_id }}" >
                                                    <div class="form-group">
                                                        <textarea name="content" class="form-control" rows="2" placeholder="Viết trả lời..."></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-sm mt-2">Gửi trả
                                                        lời</button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- END timeline item -->
                                @endforeach
                                <li>
                                    <i class="fa fa-clock-o bg-gray"></i>
                                </li>
                            </ul>
                        @else
                            <div style="width: 100%; padding-top: 30%; position: relative;">
                                <div
                                    style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 20px;">
                                    Lịch Sử Bình Luận Trống!</div>
                            </div>
                        @endif
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="order-timeline">
                        @if ($orders->isNotEmpty())
                            <!-- The timeline -->
                            <ul class="timeline timeline-inverse">
                                @foreach ($orders as $order)
                                    @php
                                        $qty = 0;
                                        $price = 0;
                                        foreach ($order->order_details as $order_detail) {
                                            $qty = $qty + $order_detail->quantity;
                                            $price = $price + $order_detail->price * $order_detail->quantity;
                                        }
                                    @endphp
                                    <!-- timeline time label -->
                                    <li class="time-label">
                                        <span class="bg-yellow">
                                            <i class="fa fa-clock-o"></i>
                                            {{ date_format($order->created_at, 'H:i d/m/Y') }}
                                        </span>
                                    </li>
                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->
                                    <li>
                                        @if ($order->status)
                                            <i class="fa fa-check bg-green" aria-hidden="true"></i>
                                        @else
                                            <i class="fa fa-times bg-red" aria-hidden="true"></i>
                                        @endif

                                        <div class="timeline-item">

                                            <h3 class="timeline-header"><a>{{ $user->name }}</a> đã mua <b
                                                    style="color: #f30;">{{ $qty }}</b> sản phẩm với giá trị <b
                                                    style="color: #f30;">{{ number_format($price, 0, ',', '.') }}</b> VNĐ
                                            </h3>

                                            <div class="timeline-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped"
                                                        style="margin-bottom: 0; background-color: #fff;">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center" style="vertical-align: middle;">
                                                                    STT
                                                                </th>
                                                                <th class="text-center" style="vertical-align: middle;">
                                                                    Mã<br>Sản Phẩm</th>
                                                                <th class="text-center" style="vertical-align: middle;">
                                                                    Tên<br>Sản Phẩm</th>
                                                                <th class="text-center" style="vertical-align: middle;">
                                                                    Loại
                                                                </th>
                                                                <th class="text-center" style="vertical-align: middle;">Số
                                                                    Lượng</th>
                                                                <th class="text-center" style="vertical-align: middle;">
                                                                    Đơn
                                                                    Giá</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($order->order_details as $key => $order_detail)
                                                                <tr>
                                                                    <td class="text-center"
                                                                        style="vertical-align: middle;">
                                                                        {{ $key + 1 }}</td>
                                                                    <td class="text-center"
                                                                        style="vertical-align: middle;"><a
                                                                            title="{{ $order_detail->variants->product->name }}">{{ $order_detail->variants->product->sku_code }}</a>
                                                                    </td>
                                                                    <td class="text-center"
                                                                        style="vertical-align: middle;">
                                                                        {{ $order_detail->variants->product->name }}</td>
                                                                    <td class="text-center"
                                                                        style="vertical-align: middle;">
                                                                        {{ $order_detail->variants->sku }}</td>
                                                                    <td class="text-center"
                                                                        style="vertical-align: middle;">
                                                                        {{ $order_detail->quantity }}</td>
                                                                    <td class="text-center"
                                                                        style="color: #f30; vertical-align: middle;">
                                                                        {{ number_format($order_detail->price, 0, ',', '.') }}₫
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="timeline-footer">
                                                @if ($order->status == 6)
                                                    <span class="label label-success">Thành Công</span>
                                                @elseif($order->status == 8)
                                                    <span class="label label-danger">Hủy</span>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    <!-- END timeline item -->
                                @endforeach
                                <li>
                                    <i class="fa fa-clock-o bg-gray"></i>
                                </li>
                            </ul>
                        @else
                            <div style="width: 100%; padding-top: 30%; position: relative;">
                                <div
                                    style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 20px;">
                                    Lịch Sử Mua Hàng Trống!</div>
                            </div>
                        @endif
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection

@section('embed-js')

@endsection

@section('custom-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lấy tất cả các nút "Trả lời"
            const replyButtons = document.querySelectorAll('.reply-toggle-btn');

            replyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Lấy ID từ data-id
                    const id = this.getAttribute('data-id');
                    // Lấy form tương ứng
                    const form = document.getElementById(`reply-form-${id}`);

                    // Hiển thị hoặc ẩn form
                    if (form.style.display === 'none') {
                        form.style.display = 'block';
                    } else {
                        form.style.display = 'none';
                    }
                });
            });
        });
    </script>

@endsection
