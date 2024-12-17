<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('theme/admin/assets') }}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <body>
        <h1>Thông báo trạng thái đơn hàng</h1>
        <p>Đơn hàng ID: {{ $order->id }}</p>
        <p>Trạng thái hiện tại: {{ $newStatus }}</p>
        <p>Chúng tôi sẽ tiếp tục cập nhật tình trạng đơn hàng của bạn khi có sự thay đổi.</p>
    </body>
</body>
</html>