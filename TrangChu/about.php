<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Về Chúng Tôi - Booking Homestay</title>
  <link rel="stylesheet" href="../CSS/css.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="body">
  <header class="header">
    <h1>Booking Homestay</h1>
    <p>Trải nghiệm không gian nghỉ dưỡng thoải mái & đáng nhớ</p>
  </header>

  <section class="about">
    <h2>Về Chúng Tôi</h2>
    <p><strong>Booking Homestay</strong> là nền tảng đặt phòng homestay trực tuyến, giúp kết nối du khách với những không gian nghỉ dưỡng độc đáo và tiện nghi trên khắp Việt Nam. Với hệ thống tìm kiếm thông minh, thông tin minh bạch và đa dạng lựa chọn, chúng tôi cam kết mang đến trải nghiệm đặt phòng nhanh chóng, an toàn và giá cả hợp lý. Booking Homestay không chỉ là nơi bạn tìm được chỗ ở ưng ý, mà còn là người bạn đồng hành trên mỗi hành trình khám phá, mang lại những khoảnh khắc nghỉ dưỡng thoải mái và đáng nhớ.</p>
    <p>Chúng tôi cam kết mang đến trải nghiệm du lịch thân thiện, uy tín và nhanh chóng
      với hệ thống đặt phòng dễ dàng, hỗ trợ 24/7.</p>

    <div class="values">
      <div class="value-box">
        <i class="fas fa-handshake"></i>
        <h3>Uy tín</h3>
        <p>Hợp tác cùng chủ homestay được xác minh, đảm bảo an toàn và đáng tin cậy.</p>
      </div>
      <div class="value-box">
        <i class="fas fa-star"></i>
        <h3>Chất lượng</h3>
        <p>Mang đến không gian nghỉ dưỡng tiện nghi, phù hợp cho mọi du khách.</p>
      </div>
      <div class="value-box">
        <i class="fas fa-smile"></i>
        <h3>Trải nghiệm</h3>
        <p>Đặt phòng nhanh chóng, dịch vụ hỗ trợ tận tình, mang lại sự hài lòng tối đa.</p>
      </div>
    </div>

    <div class="team">
      <h2>Đội Ngũ</h2>
      <div class="team-members">
        <div class="member">
          <img src="../ANH/10.jpg" alt="Thành viên 1">
          <h4>Nguyễn Văn A</h4>
          <p>Founder & CEO</p>
        </div>
        <div class="member">
          <img src="../ANH/10.jpg" alt="Thành viên 2">
          <h4>Trần Thị B</h4>
          <p>Marketing</p>
        </div>
        <div class="member">
          <img src="../ANH/10.jpg" alt="Thành viên 3">
          <h4>Lê Văn C</h4>
          <p>Developer</p>
        </div>
        <div class="team-members">
        <div class="member">
          <img src="../ANH/10.jpg" alt="Thành viên 1">
          <h4>Nguyễn Văn A</h4>
          <p>Founder & CEO</p>
        </div>
         <div class="team-members">
        <div class="member">
          <img src="../ANH/10.jpg" alt="Thành viên 1">
          <h4>Nguyễn Văn A</h4>
          <p>Founder & CEO</p>
        </div>
      </div>
    </div>
  </section>

  <footer>
    <p>© 2025 Booking Homestay. All rights reserved.</p>
    <div class="social">
      <i class="fab fa-facebook"></i>
      <i class="fab fa-instagram"></i>
      <i class="fab fa-twitter"></i>
    </div>
  </footer>

  <style>
.body {
      font-family: "Roboto", sans-serif;
      line-height: 1.6;
      background: #fafafa;
      color: #333;
  }
.header {
      background: #0077b6;
      color: white;
      padding: 20px 0;
      text-align: center;
}
.header h1 {
      font-size: 36px;
}
.about {
      max-width: 1100px;
      margin: 0 auto;
      padding: 50px 20px;
      text-align: center;
}
.about h2 {
      font-size: 28px;
      margin-bottom: 15px;
      color: #0077b6;
}
.about p {
      font-size: 18px;
      color: #444;
      margin-bottom: 20px;
}
.values {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
      margin-top: 40px;
}
.value-box {
      background: white;
      padding: 25px;
      border-radius: 16px;
      width: 280px;
      margin: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      transition: 0.3s;
}
.value-box:hover {
      transform: translateY(-5px);
}
.value-box i {
      font-size: 40px;
      color: #0077b6;
      margin-bottom: 15px;
}
.value-box h3 {
      margin-bottom: 10px;
      color: #0077b6;
}
.team {
      margin-top: 60px;
}
.team h2 {
      margin-bottom: 20px;
      color: #0077b6;
}
.team-members {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 30px;
}
.member {
      width: 220px;
      text-align: center;
      background: white;
      padding: 20px;
      border-radius: 16px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.member img {
      width: 100%;
      border-radius: 50%;
      margin-bottom: 10px;
}
footer {
      background: #0077b6;
      color: white;
      text-align: center;
      padding: 20px;
      margin-top: 50px;
}
footer .social i {
      margin: 0 10px;
      font-size: 22px;
      cursor: pointer;
      transition: 0.3s;
}
footer .social i:hover {
      color: #ffdd00;
}
  </style>
</body>
</html>
