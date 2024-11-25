<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('theme/admin/assets') }}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <h1>Thông Tin Liên Hệ</h1>
    <p>Có một khách hàng vừa gửi thông tin liên hệ:</p>
    <div>
        <p><strong>Tên:</strong> {{ $data['name'] ?? 'Không có tên' }}</p>
        <p><strong>Email:</strong> {{ $data['email'] ?? 'Không có email' }}</p>
        <p><strong>Nội dung:</strong> {{ $data['message'] ?? 'Không có nội dung' }}</p>
    </div>
</body>
</html>