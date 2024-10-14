<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cảm ơn bạn đã liên hệ</title>
</head>
<body>
    <h1>Chào {{ $contact->name }},</h1>
    <p>Chúng tôi đã nhận được thông điệp của bạn:</p>
    <p>{{ $contact->message }}</p>
    <p>Cảm ơn bạn đã liên hệ với chúng tôi!</p>
</body>
</html>
