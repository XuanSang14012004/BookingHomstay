-- Tạo database
CREATE DATABASE homestay_db;
USE homestay_db;

-- Tạo bảng users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- Tạo bảng homestay
CREATE TABLE homestay (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- Tạo bảng booking
CREATE TABLE booking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    homestay_id INT,
    date DATE,
    status VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (homestay_id) REFERENCES homestay(id)
);

-- Thêm dữ liệu mẫu
INSERT INTO users (name) VALUES ('Nguyễn Văn A'), ('Trần Thị B');
INSERT INTO homestay (name) VALUES ('Sunshine Villa'), ('Green House');
INSERT INTO booking (user_id, homestay_id, date, status) VALUES
(1, 1, '2025-08-28', 'Đã xác nhận'),
(2, 2, '2025-08-27', 'Chờ xác nhận');