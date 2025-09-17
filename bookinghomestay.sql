-- Xóa bảng cũ
DROP TABLE IF EXISTS homestays;

-- Tạo bảng homestays
CREATE TABLE homestays (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255),
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

-- Thêm dữ liệu 32 homestay với 4 ảnh
INSERT INTO homestays (name, price, img, img1, img2, img3, rating, room_type, guests, address, description) VALUES
-- Sóc Sơn
('Amaya Home Deluxe', 1300000, '../ANH/SS1.jpg', '../ANH/Amayahome-deluxe1.jpg', '../ANH/Amayahome-deluxe2.jpg', '../ANH/Amayahome-deluxe2.jpg', 5, 'Deluxe', 8, 'Sóc Sơn, Hà Nội', 'Homestay yên tĩnh, gần rừng thông, thích hợp nghỉ dưỡng.'),
('Amaya Home Family', 950000, '../ANH/SS1.jpg', '../ANH/amaya-family1.jpg', '../ANH/amaya-family1.jpg', '../ANH/amaya-family1.jpg', 4, 'Standard', 6, 'Sóc Sơn, Hà Nội', 'Phòng tiêu chuẩn, đầy đủ tiện nghi.'),
('Cerf Volant Soc Son Deluxe', 1500000, '../ANH/SS2.jpg', '../ANH/CerfVolantSocSonResort-deluxe1.jpg', '../ANH/CerfVolantSocSonResort-deluxe2.jpg', '../ANH/CerfVolantSocSonResort-deluxe3.jpg', 5, 'Deluxe', 5, 'Sóc Sơn, Hà Nội', 'Khu nghỉ dưỡng với view núi.'),
('Cerf Volant Soc Son Standard', 1100000, '../ANH/Cerf Volant Soc Son Resort-standard3.jpg', '../ANH/Cerf Volant Soc Son Resort-standard1.jpg', '../ANH/Cerf Volant Soc Son Resort-standard2.jpg', '../ANH/SS2.jpg', 4, 'Standard', 4, 'Sóc Sơn, Hà Nội', 'Phòng standard gần hồ.'),
('Debay Retreat Deluxe', 1200000, '../ANH/SS3.jpg', '../ANH/SS3.1.jpg', '../ANH/SS3.4.jpg', '../ANH/SS3.3.jpg', 4, 'Deluxe', 7, 'Sóc Sơn, Hà Nội', 'Phong cách hiện đại, gần hồ nước.'),
('Debay Retreat Standard', 850000, '../ANH/SS3.jpg', '../ANH/SS3.4.jpg', '../ANH/SS3.3.jpg', '../ANH/SS3.5.jpg', 3, 'Standard', 5, 'Sóc Sơn, Hà Nội', 'Phòng standard giá rẻ.'),
('Amaya Retreat Family', 1400000, '../ANH/SS5.jpg', '../ANH/Amaya Retreat-Family1.webp', '../ANH/Amaya Retreat-Family2.webp', '../ANH/Amaya Retreat-Family3.webp', 5, 'Deluxe', 6, 'Sóc Sơn, Hà Nội', 'Biệt thự nghỉ dưỡng sang trọng.'),
('Amaya Retreat Standard', 1000000, '../ANH/SS5.jpg', '../ANH/Amaya Retreat-Standard1.webp', '../ANH/Amaya Retreat-Standard3.webp', '../ANH/Amaya Retreat-Standard2.webp', 4, 'Standard', 4, 'Sóc Sơn, Hà Nội', 'Phòng tiêu chuẩn tiện nghi.'),

-- Ba Vì
('BaVi Padme Deluxe', 1250000, '../ANH/BV1.jpg', '../ANH/BV1-1.jpg', '../ANH/BV1-2.jpg', '../ANH/BV1-3.jpg', 5, 'Deluxe', 6, 'Ba Vì, Hà Nội', 'Homestay gần vườn quốc gia Ba Vì.'),
('BaVi Padme Standard', 900000, '../ANH/BV1.jpg', '../ANH/BV1-1.jpg', '../ANH/BV1-2.jpg', '../ANH/BV1-3.jpg', 4, 'Standard', 5, 'Ba Vì, Hà Nội', 'Phòng standard đầy đủ tiện nghi.'),
('Melia Bavi Mountain Retreat Deluxe', 1350000, '../ANH/BV2.jpg', '../ANH/BV2-1.jpg', '../ANH/BV2-2.jpg', '../ANH/BV2-3.jpg', 5, 'Deluxe', 8, 'Ba Vì, Hà Nội', 'Resort cao cấp giữa núi rừng.'),
('Melia Bavi Mountain Retreat Standard', 950000, '../ANH/BV2.jpg', '../ANH/BV2-1.jpg', '../ANH/BV2-2.jpg', '../ANH/BV2-3.jpg', 4, 'Standard', 6, 'Ba Vì, Hà Nội', 'Phòng nghỉ đơn giản, thoáng mát.'),
('Mely Farm Standard', 950000, '../ANH/BV3.jpg', '../ANH/BV2-1.jpg', '../ANH/BV2-2.jpg', '../ANH/BV2-3.jpg', 4, 'Standard', 6, 'Ba Vì, Hà Nội', 'Trải nghiệm nông trại độc đáo.'),
('Mely Farm Deluxe', 1250000, '../ANH/BV3.jpg', '../ANH/BV2-1.jpg', '../ANH/BV2-2.jpg', '../ANH/BV2-3.jpg', 5, 'Deluxe', 7, 'Ba Vì, Hà Nội', 'Phòng deluxe rộng rãi.'),
('Family Homestay Deluxe', 1450000, '../ANH/BV4.jpg', '../ANH/BV1-1.jpg', '../ANH/BV1-2.jpg', '../ANH/BV1-3.jpg', 5, 'Deluxe', 6, 'Ba Vì, Hà Nội', 'Thích hợp cho gia đình.'),
('Family Homestay Standard', 1050000, '../ANH/BV4.jpg', '../ANH/BV1-1.jpg', '../ANH/BV1-2.jpg', '../ANH/BV1-3.jpg', 4, 'Standard', 5, 'Ba Vì, Hà Nội', 'Phòng gia đình tiêu chuẩn.'),

-- Tam Đảo
('Dream House Deluxe', 1600000, '../ANH/TD1.jpg', '../ANH/Dream1.jpg', '../ANH/Dream4.jpg', '../ANH/Dream3.jpg', 5, 'Deluxe', 7, 'Tam Đảo, Vĩnh Phúc', 'View núi đẹp, không khí mát mẻ.'),
('Dream House Standard', 1150000, '../ANH/TD1.jpg', '../ANH/dream2.1jpg', '../ANH/dream3.1jpg', '../ANH/dream1.1jpg', 4, 'Standard', 5, 'Tam Đảo, Vĩnh Phúc', 'Phòng tiêu chuẩn, tiện nghi.'),
('Le Bleu Floating Cloud Deluxe', 1450000, '../ANH/TD2.jpg', '../ANH/Le_Bleu_Tam_Dao_1jpg', '../ANH/Le_Bleu_Tam_Dao_2jpg', '../ANH/Le_Bleu_Tam_Dao_3jpg', 5, 'Deluxe', 6, 'Tam Đảo, Vĩnh Phúc', 'Homestay nổi tiếng view mây.'),
('Le Bleu Floating Cloud Standard', 1000000, '../ANH/TD2.jpg', '../ANH/Le_Bleu_Tam_Dao_5jpg', '../ANH/Le_Bleu_Tam_Dao_6jpg', '../ANH/Le_Bleu_Tam_Dao_7jpg', 4, 'Standard', 4, 'Tam Đảo, Vĩnh Phúc', 'Phòng standard xinh xắn.'),
('Up In The Air Homestay Deluxe', 1550000, '../ANH/TD3.jpg', '../ANH/up6.jpg', '../ANH/up5.jpg', '../ANH/up4.jpg', 5, 'Deluxe', 7, 'Tam Đảo, Vĩnh Phúc', 'Phòng cao tầng nhìn toàn cảnh.'),
('Up In The Air Homestay Family', 1050000, '../ANH/TD3.jpg', '../ANH/up1.jpg', '../ANH/up2.jpg', '../ANH/up3.jpg', 4, 'Standard', 5, 'Tam Đảo, Vĩnh Phúc', 'Phòng standard tiện nghi.'),
('Cloudy Garden Deluxe', 1500000, '../ANH/TD4.jpg', '../ANH/cl3.jpg', '../ANH/cl1.jpg', '../ANH/cl2.jpg', 5, 'Deluxe', 6, 'Tam Đảo, Vĩnh Phúc', 'Homestay giữa vườn hoa.'),
('Cloudy Garden Standard', 1100000, '../ANH/TD4.jpg', '../ANH/cl1.jpg', '../ANH/cl4.jpg', '../ANH/cl5.jpg', 4, 'Standard', 5, 'Tam Đảo, Vĩnh Phúc', 'Phòng standard gần vườn.'),

-- Mộc Châu
('Phoenix Mộc Châu Bungalow Family', 1400000, '../ANH/MC1.webp', '../ANH/MC1.1.jpg', '../ANH/MC1.2.jpg', '../ANH/MC1.3.jpg', 5, 'Deluxe', 6, 'Mộc Châu, Sơn La', 'Bungalow đẹp, view vườn.'),
('Phoenix Mộc Châu Bungalow Standard', 950000, '../ANH/MC1.webp', '../ANH/MC1.4.jpg', '../ANH/MC1.5.jpg', '../ANH/MC1.6.jpg', 4, 'Standard', 5, 'Mộc Châu, Sơn La', 'Phòng standard ấm cúng.'),
('Mộc Châu Eco-garden Deluxe', 1550000, '../ANH/MC2.webp', '../ANH/MC2.1.jpg', '../ANH/MC2.2.jpg', '../ANH/MC2-3.jpg', 5, 'Deluxe', 7, 'Mộc Châu, Sơn La', 'Homestay giữa vườn cây.'),
('Mộc HomeStay Family', 1500000, '../ANH/MC3.webp', '../ANH/mcc.jpg', '../ANH/mcc1.jpg', '../ANH/mmc2.jpg', 5, 'Deluxe', 6, 'Mộc Châu, Sơn La', 'Không gian ấm áp, gần thiên nhiên.'),
('Mama House Standard', 1100000, '../ANH/MC4.webp', '../ANH/MC4.1.webpjpg', '../ANH/MC4.3.webpjpg', '../ANH/MC4.4.webpjpg', 4, 'Standard', 5, 'Mộc Châu, Sơn La', 'Phòng standard tiện nghi.');
