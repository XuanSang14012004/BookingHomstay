<!-- Update Account -->
<?php
include "../../../config/connect.php";

if (isset($_POST['submit_account'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $sql = "UPDATE db_account SET fullname='$fullname', phone='$phone', password='$password', role='$role' WHERE email='$email'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("Location: ../../home/home.php?page=account&status=update_success");
        exit();
    } else {
        header("Location: ../../home/home.php?page=account&status=update_error");
        exit();
    }
}
?>


<!-- Update User -->
<?php
include "../../../config/connect.php";

if (isset($_POST['submit_user'])) {
    $makhachhang = $_POST['makhachhang'];
    $tenkhachhang = $_POST['tenkhachhang'];
    $ngaysinh = $_POST['ngaysinh'];
    $gioitinh = $_POST['gioitinh'];
    $email = $_POST['email'];
    $sodienthoai = $_POST['sodienthoai'];
    $diachi = $_POST['diachi'];
    $sql = "UPDATE db_khachhang SET tenkhachhang='$tenkhachhang', ngaysinh='$ngaysinh', gioitinh='$gioitinh', email='$email', sodienthoai='$sodienthoai', diachi='$diachi' WHERE makhachhang='$makhachhang'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("Location: ../../home/home.php?page=user&status=update_success");
        exit();
    } else {
        header("Location: ../../home/home.php?page=user&status=update_error");
        exit();
    }
}
?>


<!-- Update Homestay -->
<?php
include "../../../config/connect.php";

if (isset($_POST['submit_homestay'])) {
    $mahomestay = $_POST['mahomestay'];
    $tenhomestay = $_POST['tenhomestay'];
    $loaihinh = $_POST['loaihinh'];
    $trangthai = $_POST['trangthai'];
    $sophong = $_POST['sophong'];
    $giathue = $_POST['giathue'];
    $sodienthoai = $_POST['sodienthoai'];
    $email = $_POST['email'];
    $diachi = $_POST['diachi'];
    $mota = $_POST['mota'];
    $tiennghi = $_POST['tiennghi'];
    $chinhsach = $_POST['chinhsach'];
    $diemdanhgia = $_POST['diemdanhgia'];
    $soluotdanhgia = $_POST['soluotdanhgia'];
    $image = basename($_FILES['hinhanh']['name']);
    $target_dir = "../../../Images/";
    $target_file = $target_dir . $image;
    // Nếu có upload ảnh mới
    if (!empty($image) && move_uploaded_file($_FILES["hinhanh"]["tmp_name"], $target_file)) {
        $sql = "UPDATE db_homestay SET tenhomestay='$tenhomestay', loaihinh='$loaihinh', trangthai='$trangthai', sophong='$sophong', giathue='$giathue', sodienthoai='$sodienthoai', email='$email', diachi='$diachi', mota='$mota', tiennghi='$tiennghi', chinhsach='$chinhsach', hinhanh='$image', diemdanhgia='$diemdanhgia', soluotdanhgia='$soluotdanhgia' WHERE mahomestay='$mahomestay'";
    } else {
        $sql = "UPDATE db_homestay SET tenhomestay='$tenhomestay', loaihinh='$loaihinh', trangthai='$trangthai', sophong='$sophong', giathue='$giathue', sodienthoai='$sodienthoai', email='$email', diachi='$diachi', mota='$mota', tiennghi='$tiennghi', chinhsach='$chinhsach', diemdanhgia='$diemdanhgia', soluotdanhgia='$soluotdanhgia' WHERE mahomestay='$mahomestay'";
    }
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("Location: ../../home/home.php?page=homestay&status=update_success");
        exit();
    } else {
        header("Location: ../../home/home.php?page=homestay&status=update_error");
        exit();
    }
}
?>


<!-- Update Rooms -->
<?php
include "../../../config/connect.php";

if (isset($_POST['submit_room'])) {
    $maphong = $_POST['maphong'];
    $tenhomestay = $_POST['tenhomestay'];
    $tenphong = $_POST['tenphong'];
    $loaiphong = $_POST['loaiphong'];
    $mota = $_POST['mota'];
    $succhua = $_POST['succhua'];
    $gia = $_POST['gia'];
    $trangthai = $_POST['trangthai'];
    $hinhanh = basename($_FILES['hinhanh']['name']);
    $target_dir = "../../../Images/";
    $target_file = $target_dir . $hinhanh;
    if (!empty($hinhanh) && move_uploaded_file($_FILES["hinhanh"]["tmp_name"], $target_file)) {
        $sql = "UPDATE db_phong SET tenhomestay='$tenhomestay', tenphong='$tenphong', loaiphong='$loaiphong', mota='$mota', succhua='$succhua', gia='$gia', trangthai='$trangthai', hinhanh='$hinhanh' WHERE maphong='$maphong'";
    } else {
        $sql = "UPDATE db_phong SET tenhomestay='$tenhomestay', tenphong='$tenphong', loaiphong='$loaiphong', mota='$mota', succhua='$succhua', gia='$gia', trangthai='$trangthai' WHERE maphong='$maphong'";
    }
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("Location: ../../home/home.php?page=rooms&status=update_success");
        exit();
    } else {
        header("Location: ../../home/home.php?page=rooms&status=update_error");
        exit();
    }
}
?>


<!-- Update Booking -->
<?php
include "../../../config/connect.php";

if (isset($_POST['submit_booking'])) {
    $madondatphong = $_POST['madondatphong'];
    $tenkhachhang = $_POST['tenkhachhang'];
    $mahomestay = $_POST['mahomestay'];
    $maphong = $_POST['maphong'];
    $ngaydatphong = $_POST['ngaydatphong'];
    $ngaynhanphong = $_POST['ngaynhanphong'];
    $ngaytraphong = $_POST['ngaytraphong'];
    $songuoi = $_POST['songuoi'];
    $tongtien = $_POST['tongtien'];
    $trangthai = $_POST['trangthai'];
    $sql = "UPDATE db_booking SET tenkhachhang='$tenkhachhang', mahomestay='$mahomestay', maphong='$maphong', ngaydatphong='$ngaydatphong', ngaynhanphong='$ngaynhanphong', ngaytraphong='$ngaytraphong', songuoi='$songuoi', tongtien='$tongtien', trangthai='$trangthai' WHERE madondatphong='$madondatphong'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("Location: ../../home/home.php?page=account&status=update_success");
        exit();
    } else {
        header("Location: ../../home/home.php?page=account&status=update_error");
        exit();
    }
}
?>


<!-- Update Payment -->
<?php
include "../../../config/connect.php";

if (isset($_POST['submit_payment'])) {
    $mathanhtoan = $_POST['mathanhtoan'];
    $madondatphong = $_POST['madondatphong'];
    $hinhthucthanhtoan = $_POST['hinhthucthanhtoan'];
    $sotien = $_POST['sotien'];
    $ngaythanhtoan = $_POST['ngaythanhtoan'];
    $trangthai = $_POST['trangthai'];
    $sql = "UPDATE db_payment SET madondatphong='$madondatphong', hinhthucthanhtoan='$hinhthucthanhtoan', sotien='$sotien', ngaythanhtoan='$ngaythanhtoan', trangthai='$trangthai' WHERE mathanhtoan='$mathanhtoan'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("Location: ../../home/home.php?page=account&status=update_success");
        exit();
    } else {
        header("Location: ../../home/home.php?page=account&status=update_error");
        exit();
    }
}
?>


<!-- Update reviews -->

<!-- Update feedback -->
