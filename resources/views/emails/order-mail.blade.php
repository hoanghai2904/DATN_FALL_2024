<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('theme/admin/assets') }}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <h1>Xác Nhận Đơn Hàng</h1>
    <p>Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ liên hệ với bạn sớm.</p>
    <p>Chi tiết đơn hàng:</p>
    
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Mã Đơn Hàng</th>
            <td>{{ $order->order_code }}</td>
        </tr>
        <tr>
            <th>Tên Khách Hàng</th>
            <td>{{ $order->name }}</td>
        </tr>
        <tr>
            <th>Địa Chỉ Giao Hàng</th>
            <td>{{ $order->address }}</td>
        </tr>
        <tr>
            <th>Số Điện Thoại</th>
            <td>{{ $order->phone }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $order->email }}</td>
        </tr>
        <tr>
            <th>Phương Thức Thanh Toán</th>
            <td>{{ $order->paymentMethod->name }}</td>
        </tr>
        <tr>
            <th colspan="2">Chi Tiết Sản Phẩm</th>
        </tr>
        <tr>
            <th>Tên Sản Phẩm</th>
            <th>Số Lượng</th>
            <th>Giá</th>
            <th>Tạm Tính</th>
        </tr>
        @foreach($order->orderDetails as $detail)
            <tr>
                <td>{{ $detail->productDetail->product->name }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>{{ number_format($detail->price, 0, ',', '.') }} đ</td>
                <td>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} đ</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="3">Tạm Tính</th>
            <td>{{ number_format($order->orderDetails->sum(function($detail) { return $detail->price * $detail->quantity; }), 0, ',', '.') }} đ</td>
        </tr>
        <tr>
            <th colspan="3">Phí Giao Hàng</th>
            <td>{{ number_format($order->fee, 0, ',', '.') }} đ</td>
        </tr>
        <tr>
            <th colspan="3">Giảm Giá</th>
            <td>{{ number_format($order->discount, 0, ',', '.') }} đ</td>
        </tr>
        <tr>
            <th colspan="3">Tổng Tiền Cần Thanh Toán</th>
            <td>{{ number_format($order->orderDetails->sum(function($detail) { return $detail->price * $detail->quantity; }) + $order->fee - $order->discount, 0, ',', '.') }} đ</td>
        </tr>
    </table>
</body>
</html>