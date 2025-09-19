-- Xóa bảng cũ
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS homestays;

-- Tạo bảng homestays
CREATE TABLE homestays (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255),
    status VARCHAR(20) DEFAULT 'còn phòng',
    description TEXT,
    price INT NOT NULL,
    guests INT DEFAULT 2,
    room_type VARCHAR(50) NOT NULL,
    img VARCHAR(255),
    img1 VARCHAR(255),
    img2 VARCHAR(255),
    img3 VARCHAR(255),
    checkin VARCHAR(50) DEFAULT '14:00 - 22:00',
    checkout VARCHAR(50) DEFAULT 'Trước 12:00 trưa',
    rating FLOAT DEFAULT 4.5,
    reviews_count INT DEFAULT 0
);
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    homestay_id INT NOT NULL,
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    checkin_date DATE NOT NULL,
    checkout_date DATE NOT NULL,
    guests INT DEFAULT 1,
    payment_method VARCHAR(50) NOT NULL,     -- phương thức thimages toán
    total_price INT NOT NULL DEFAULT 0,      -- tổng tiền
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (homestay_id) REFERENCES homestays(id) ON DELETE CASCADE
);



-- Thêm dữ liệu 32 homestay với 4 ảnh
INSERT INTO homestays (name, price, img, img1, img2, img3, rating, room_type, guests, address, description) VALUES
-- Sóc Sơn
('Amaya Home Deluxe', 1300000, '../images/SS1.jpg', '../images/Amayahome-deluxe1.jpg', '../images/Amayahome-deluxe2.jpg', '../images/Amayahome-deluxe2.jpg', 5, 'Deluxe', 8, 'Sóc Sơn, Hà Nội', 'Homestay yên tĩnh, gần rừng thông, thích hợp nghỉ dưỡng.'),
('Amaya Home Family', 950000, '../images/SS1.jpg', '../images/amaya-family1.jpg', '../images/amaya-family1.jpg', '../images/amaya-family1.jpg', 4, 'Family', 6, 'Sóc Sơn, Hà Nội', 'Phòng tiêu chuẩn, đầy đủ tiện nghi.'),
('Cerf Volant Soc Son Deluxe', 1500000, '../images/SS2.jpg', '../images/CerfVolantSocSonResort-deluxe1.jpg', '../images/CerfVolantSocSonResort-deluxe2.jpg', '../images/CerfVolantSocSonResort-deluxe3.jpg', 5, 'Deluxe', 5, 'Sóc Sơn, Hà Nội', 'Khu nghỉ dưỡng với view núi.'),
('Cerf Volant Soc Son Standard', 1100000, '../images/Cerf Volant Soc Son Resort-standard3.jpg', '../images/Cerf Volant Soc Son Resort-standard1.jpg', '../images/Cerf Volant Soc Son Resort-standard2.jpg', '../images/SS2.jpg', 4, 'Standard', 4, 'Sóc Sơn, Hà Nội', 'Phòng standard gần hồ.'),
('Debay Retreat Deluxe', 1200000, '../images/SS3.jpg', '../images/SS3.1.jpg', '../images/SS3.4.jpg', '../images/SS3.3.jpg', 4, 'Deluxe', 7, 'Sóc Sơn, Hà Nội', 'Phong cách hiện đại, gần hồ nước.'),
('Debay Retreat Standard', 850000, '../images/SS3.jpg', '../images/SS3.4.jpg', '../images/SS3.3.jpg', '../images/SS3.5.jpg', 3, 'Standard', 5, 'Sóc Sơn, Hà Nội', 'Phòng standard giá rẻ.'),
('Amaya Retreat Family', 1400000, '../images/SS5.jpg', '../images/Amaya Retreat-Family1.webp', '../images/Amaya Retreat-Family2.webp', '../images/Amaya Retreat-Family3.webp', 5, 'Family', 6, 'Sóc Sơn, Hà Nội', 'Biệt thự nghỉ dưỡng sang trọng.'),
('Amaya Retreat Standard', 1000000, '../images/SS5.jpg', '../images/Amaya Retreat-Standard1.webp', '../images/Amaya Retreat-Standard3.webp', '../images/Amaya Retreat-Standard2.webp', 4, 'Standard', 4, 'Sóc Sơn, Hà Nội', 'Phòng tiêu chuẩn tiện nghi.'),

-- Ba Vì
('BaVi Padme Deluxe', 1250000, '../images/BV1.jpg', '../images/BV1.1.jpg', '../images/BV1.3.jpg', '../images/BV1.4.jpg', 5, 'Deluxe', 6, 'Ba Vì, Hà Nội', 'Homestay gần vườn quốc gia Ba Vì.'),
('BaVi Padme Standard', 900000, '../images/BV1.jpg', '../images/BV1.6.jpg', '../images/BV1.1.jpg', '../images/BV1.5.jpg', 4, 'Standard', 5, 'Ba Vì, Hà Nội', 'Phòng standard đầy đủ tiện nghi.'),
('Melia Bavi Mountain Retreat Deluxe', 1350000, '../images/BV2.jpg', '../images/BV2.1.jpg', '../images/BV2.3.jpg', '../images/BV2.4.jpg', 5, 'Deluxe', 8, 'Ba Vì, Hà Nội', 'Resort cao cấp giữa núi rừng.'),
('Melia Bavi Mountain Retreat Standard', 950000, '../images/BV2.jpg', '../images/BV2.1.jpg', '../images/BV2.5.jpg', '../images/BV2.6.jpg', 4, 'Standard', 6, 'Ba Vì, Hà Nội', 'Phòng nghỉ đơn giản, thoáng mát.'),
('Mely Farm Standard', 950000, '../images/BV3.jpg', '../images/3.1.jpg', '../images/3.3.jpg', '../images/3.4.jpg', 4, 'Standard', 6, 'Ba Vì, Hà Nội', 'Trải nghiệm nông trại độc đáo.'),
('Mely Farm Deluxe', 1250000, '../images/BV3.jpg', '../images/BV3.5.jpg', '../images/BV3.6.jpg', '../images/3.4.jpg', 5, 'Deluxe', 7, 'Ba Vì, Hà Nội', 'Phòng deluxe rộng rãi.'),
('Family Homestay Deluxe', 1450000, '../images/BV4.jpg', '../images/BV1.1.jpg', '../images/BV2.jpg', '../images/BV1.3.jpg', 5, 'Deluxe', 6, 'Ba Vì, Hà Nội', 'Thích hợp cho gia đình.'),
('Family Homestay Standard', 1050000, '../images/BV4.jpg', '../images/BV4.1.jpg', '../images/BV4.3.jpg', '../images/BV1.3.jpg', 4, 'Standard', 5, 'Ba Vì, Hà Nội', 'Phòng gia đình tiêu chuẩn.'),

-- Tam Đảo
('Dream House Deluxe', 1600000, '../images/TD1.jpg', '../images/TD1.8.png', '../images/TD1.3.jpg', '../images/TD1.4.jpg', 5, 'Deluxe', 7, 'Tam Đảo, Vĩnh Phúc', 'View núi đẹp, không khí mát mẻ.'),
('Dream House Standard', 1150000, '../images/TD1.jpg', '../images/dream2.1.jpg', '../images/dream3.1.jpg', '../images/TD1.3.jpg', 4, 'Standard', 5, 'Tam Đảo, Vĩnh Phúc', 'Phòng tiêu chuẩn, tiện nghi.'),
('Le Bleu Floating Cloud Deluxe', 1450000, '../images/TD2.jpg', '../images/Le_Bleu_Tam_Dao_1.jpg', '../images/Le_Bleu_Tam_Dao_2.jpg', '../images/Le_Bleu_Tam_Dao_3.jpg', 5, 'Deluxe', 6, 'Tam Đảo, Vĩnh Phúc', 'Homestay nổi tiếng view mây.'),
('Le Bleu Floating Cloud Standard', 1000000, '../images/TD2.jpg', '../images/Le_Bleu_Tam_Dao_5.jpg', '../images/Le_Bleu_Tam_Dao_6.jpg', '../images/Le_Bleu_Tam_Dao_7.jpg', 4, 'Standard', 4, 'Tam Đảo, Vĩnh Phúc', 'Phòng standard xinh xắn.'),
('Up In The Air Homestay Deluxe', 1550000, '../images/TD3.jpg', '../images/up6.jpg', '../images/up5.jpg', '../images/up4.jpg', 5, 'Deluxe', 7, 'Tam Đảo, Vĩnh Phúc', 'Phòng cao tầng nhìn toàn cảnh.'),
('Up In The Air Homestay Family', 1050000, '../images/TD3.jpg', '../images/up1.jpg', '../images/up2.jpg', '../images/up3.jpg', 4, 'Family', 5, 'Tam Đảo, Vĩnh Phúc', 'Phòng family tiện nghi.'),
('Cloudy Garden Deluxe', 1500000, '../images/TD4.jpg', '../images/cl3.jpg', '../images/cl1.jpg', '../images/cl2.jpg', 5, 'Deluxe', 6, 'Tam Đảo, Vĩnh Phúc', 'Homestay giữa vườn hoa.'),
('Cloudy Garden Standard', 1100000, '../images/TD4.jpg', '../images/cl1.jpg', '../images/cl4.jpg', '../images/cl5.jpg', 4, 'Standard', 5, 'Tam Đảo, Vĩnh Phúc', 'Phòng standard gần vườn.'),

-- Mộc Châu
('Phoenix Bungalow Family', 1400000, '../images/MC.jpg', '../images/MC1.1.jpg', '../images/MC1.2.webp', '../images/MC1.3.jpg', 5, 'Family', 6, 'Mộc Châu, Sơn La', 'Bungalow đẹp, view vườn.'),
('Phoenix Bungalow Standard', 950000, '../images/MC.jpg', '../images/MC1.4.jpeg', '../images/MC1.5.jpeg', '../images/MC1.6.jpeg', 4, 'Standard', 5, 'Mộc Châu, Sơn La', 'Phòng standard ấm cúng.'),
('Mộc Châu Eco-garden Deluxe', 1550000, '../images/mcc2.webp', '../images/MC2.1.jpg', '../images/MC2.2.webp', '../images/MC2.3.jpg', 5, 'Deluxe', 7, 'Mộc Châu, Sơn La', 'Homestay giữa vườn cây.'),
('Mộc HomeStay Family', 1500000, '../images/MC3.webp', '../images/mcc.webp', '../images/mcc1.webp', '../images/mcc2.webp', 5, 'Family', 6, 'Mộc Châu, Sơn La', 'Không gian ấm áp, gần thiên nhiên.'),
('Mama House Standard', 1100000, '../images/MC4.webp', '../images/MC4.1.jpg', '../images/MC4.3.jpg', '../images/MC4.4.jpg', 4, 'Standard', 5, 'Mộc Châu, Sơn La', 'Phòng standard tiện nghi.');


