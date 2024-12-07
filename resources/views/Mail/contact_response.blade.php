<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
<<<<<<< HEAD
    <title>Cảm ơn bạn đã liên hệ</title>
</head>
<body>
    <h1>Chào {{ $contact->name }},</h1>
    <p>Chúng tôi đã nhận được thông điệp của bạn:</p>
    <p>{{ $contact->message }}</p>
    <p>Cảm ơn bạn đã liên hệ với chúng tôi!</p>
</body>
</html>
=======
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ mới</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
        }
        .info {
            margin-bottom: 15px;
            padding: 15px;
            border: 2px solid #007bff;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        .info p {
            margin: 5px 0;
        }
        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #777;
            text-align: center;
        }
        .thank-you {
            margin-top: 15px;
            font-weight: bold;
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Liên hệ mới từ: {{ $data['name'] }}</h1>
        <div class="info">
            <p><strong>Email:</strong> {{ $data['email'] }}</p>
            <p><strong>Tin nhắn:</strong></p>
            <p>{{ $data['message'] }}</p>
        </div>

        <div class="footer">
            <p class="thank-you">Cảm ơn bạn đã liên hệ với chúng tôi!</p>
        </div>
    </div>
</body>
</html>
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc
