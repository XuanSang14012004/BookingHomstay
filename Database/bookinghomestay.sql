c,'eco_deluxe@gmail.com','../images/MC1.2.webp','../images/MC1.4.jpeg',5,'Deluxe','Còn trống',1280000,'Deluxe homestay trong khu eco-garden',5),
('HS28','Mộc HomeStay Family','Mộc Châu, Sơn La','0123456816','moc_family@gmail.com','../images/MC1.3.jpg','../images/MC1.5.jpeg',6,'Family','Còn trống',1450000,'Homestay rộng cho gia đình, gần chợ Mộc Châu',5),
('HS29','Mama House Standard','Mộc Châu, Sơn La','0123456817','mama_standard@gmail.com','../images/mcc2.webp','../images/mc4.3.jpg',4,'Standard','Còn trống',890000,'Phòng standard ấm cúng, gần trung tâm',4),
('HS30','Mộc Châu Eco-garden Standard','Mộc Châu, Sơn La','0123456818','eco_standard@gmail.com','../images/mcc.webp','../images/2.3.jpg',4,'Standard','Còn trống',910000,'Standard trong khu vườn sinh thái',4),
('HS31','Mộc HomeStay Deluxe','Mộc Châu, Sơn La','0123456819','moc_deluxe@gmail.com','../images/MC3.webp','../images/mc4.1.jpg',5,'Deluxe','Còn trống',1300000,'Phòng deluxe, thiết kế gỗ truyền thống',5),
('HS32','Mama House Deluxe','Mộc Châu, Sơn La','0123456820','mama_deluxe@gmail.com','../images/MC4.webp','../images/mc4.4.jpg',5,'Deluxe','Còn trống',1200000,'Deluxe homestay tiện nghi, gần khu du lịch',5);



-- ==========================
-- TẠO BẢNG PHÒNG
-- ==========================
CREATE TABLE db_phong (
    maphong VARCHAR(10) PRIMARY KEY,
    mahomestay VARCHAR(10),
    tenphong VARCHAR(255) NOT NULL,
    tenhomestay VARCHAR(255) NOT NULL,
    hinhanh VARCHAR(255) NOT NULL,
    loaiphong VARCHAR(50),
    songuoi INT DEFAULT 2,
    gia INT NOT NULL,
    mota TEXT,
    trangthai VARCHAR(20) DEFAULT 'còn phòng',
    FOREIGN KEY (mahomestay) REFERENCES db_homestay(mahomestay) ON DELETE CASCADE
);

-- ==========================
-- TẠO BẢNG ĐẶT PHÒNG
-- ==========================
CREATE TABLE db_booking (
    madondatphong VARCHAR(10) PRIMARY KEY,
    makhachhang VARCHAR(10),
    maphong VARCHAR(10),
    ngaydat DATE NOT NULL,
    ngaynhan DATE NOT NULL,
    ngaytra DATE NOT NULL,
    songuoi INT DEFAULT 1,
    trangthai VARCHAR(20) DEFAULT 'chờ xử lý',
    FOREIGN KEY (makhachhang) REFERENCES db_khachhang(makhachhang) ON DELETE CASCADE,
    FOREIGN KEY (maphong) REFERENCES db_phong(maphong) ON DELETE CASCADE
);

-- ==========================
-- TẠO BẢNG THANH TOÁN
-- ==========================
CREATE TABLE db_thanhtoan (
    mathanhtoan VARCHAR(10) PRIMARY KEY,
    madondatphong VARCHAR(10),
    phuongthuctt VARCHAR(50) NOT NULL,
    sotien INT NOT NULL,
    ngaytt DATE NOT NULL,
    trangthai VARCHAR(20) NOT NULL,
    FOREIGN KEY (madondatphong) REFERENCES db_booking(madondatphong) ON DELETE CASCADE
);

-- ==========================
-- TẠO BẢNG ĐÁNH GIÁ
-- ==========================
CREATE TABLE db_danhgia (
    madanhgia VARCHAR(10) PRIMARY KEY,
    makhachhang VARCHAR(10),
    tenkhachhang VARCHAR(255) NOT NULL,
    maphong VARCHAR(10),
    sao INT CHECK (sao BETWEEN 1 AND 5),
    binhluan TEXT,
    ngaydg DATE DEFAULT CURRENT_DATE,
    FOREIGN KEY (makhachhang) REFERENCES db_khachhang(makhachhang) ON DELETE CASCADE,
    FOREIGN KEY (maphong) REFERENCES db_phong(maphong) ON DELETE CASCADE
);

-- ==========================
-- TẠO BẢNG FEEDBACK
-- ==========================
CREATE TABLE db_feedback (
    maphanhoi VARCHAR(10) PRIMARY KEY,
    makhachhang VARCHAR(10),
    noidung TEXT NOT NULL,
    ngaygui DATE DEFAULT CURRENT_DATE,
    FOREIGN KEY (makhachhang) REFERENCES db_khachhang(makhachhang) ON DELETE CASCADE
);


c