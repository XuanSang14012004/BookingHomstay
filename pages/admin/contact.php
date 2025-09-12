<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Liên hệ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: Arial, sans-serif; background: #f7f7f7; margin: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; padding: 32px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);}
        h2 { text-align: center; color: #333; }
        .info { margin-bottom: 24px; }
        .info p { margin: 8px 0; }
        form label { display: block; margin-top: 16px; }
        form input, form textarea { width: 100%; padding: 8px; margin-top: 4px; border: 1px solid #ccc; border-radius: 4px; }
        form button { margin-top: 16px; padding: 10px 24px; background: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer;}
        form button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Liên hệ với chúng tôi</h2>
        <div class="info">
            <p><strong>Địa chỉ:</strong> 123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh</p>
            <p><strong>Email:</strong> contact@homstay.com</p>
            <p><strong>Điện thoại:</strong> 0123 456 789</p>
        </div>
        <form>
            <label for="name">Họ và tên:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Nội dung:</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit">Gửi liên hệ</button>
        </form>
    </div>
</body>