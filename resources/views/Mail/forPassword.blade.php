<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .email-container {
            max-width: 600px; /* Độ rộng tối đa */
            margin: auto; /* Căn giữa */
            background-color: rgba(255, 255, 255, 0.9); /* Nền trắng với độ trong suốt */
            padding: 30px; /* Padding cho khối nội dung */
            border-radius: 10px; /* Bo tròn góc */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Bóng đổ */
        }
        h3 {
            color: #333; /* Màu chữ tiêu đề */
        }
        p {
            color: #555; /* Màu chữ nội dung */
            line-height: 1.5; /* Khoảng cách dòng */
        }
        .btn-confirm {
            display: inline-block; /* Hiển thị inline */
            background-color: #007bff; /* Màu nền nút */
            color: #ffffff; /* Màu chữ nút */
            padding: 10px 20px; /* Padding cho nút */
            border-radius: 5px; /* Bo tròn góc nút */
            text-decoration: none; /* Bỏ gạch chân */
            font-weight: bold; /* Chữ đậm */
        }
        .btn-confirm:hover {
            background-color: #0056b3; /* Màu nền nút khi hover */
            color: #ffffff;
        }
    </style>
</head>
<body>
    <table role="presentation" width="90%" cellspacing="0" cellpadding="0" border="0" style="background-image: url('https://mcdn2-coolmate.cdn.vccloud.vn/uploads/December2021/shop-quan-ao-thu-cung.jpg'); background-size: cover; background-repeat: no-repeat; height: 100vh;">
        <tr>
            <td align="center" valign="top" style="padding: 20px;">
                <div class="email-container">
                    <h3>Xin chào: {{$user->full_name}}</h3>
                    <p>Bạn muốn lấy lại mật khẩu.</p>
                    <p>Click vào nút bên dưới để đặt lại mật khẩu của bạn:</p>
                    <a href="{{ route('admin.reset_pass',$token) }}" class="btn-confirm">Xác nhận</a>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
