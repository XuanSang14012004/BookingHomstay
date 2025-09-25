<!-- Add Account -->
<?php
include "../../config/connect.php";

$sql_account = "SELECT * FROM db_account";
$result_account = mysqli_query($conn, $sql_account);
if (isset($_POST['submit_account'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    // Kiểm tra email đã tồn tại chưa
    $check_account = "SELECT email FROM db_account WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_account);
    if (mysqli_num_rows($check_result) > 0) {
        header("Location: ../home/home.php?page=add_account&status=exists");
        exit();
    }
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $sql = "INSERT INTO db_account(fullname, email, phone, password, role)
    VALUES ('$fullname','$email','$phone','$password','$role')";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("Location: ../home/home.php?page=account&status=add_success");
        exit();
    } else {
        header("Location: ../home/home.php?page=account&status=add_error");
        exit();
    }
}
?>


<!-- Add User -->
<?php
include "../../config/connect.php";

$sql_user = "SELECT * FROM db_khachhang";
$result_user = mysqli_query($conn, $sql_user);
if (isset($_POST['submit_user'])) {
    $makhachhang = $_POST['makhachhang'];
    // Kiểm tra mã khách hàng đã tồn tại chưa
    $check_user = "SELECT makhachhang FROM db_khachhang WHERE makhachhang = '$makhachhang'";
    $check_result = mysqli_query($conn, $check_user);
    if (mysqli_num_rows($check_result) > 0) {
        header("Location: ../home/home.php?page=add_user&status=exists");
        exit();
    }
    $tenkhachhang = $_POST['tenkhachhang'];
    $ngaysinh = $_POST['ngaysinh'];
    $gioitinh = $_POST['gioitinh'];
    $email = $_POST['email'];
    $sodienthoai = $_POST['sodienthoai'];
    $diachi = $_POST['diachi'];
    $sql = "INSERT INTO db_khachhang(makhachhang, tenkhachhang, ngaysinh, gioitinh, email, sodienthoai, diachi)
    VALUES ('$makhachhang','$tenkhachhang','$ngaysinh','$gioitinh','$email','$sodienthoai','$diachi')";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("Location: ../home/home.php?page=user&status=add_success");
        exit();
    } else {
        header("Location: ../home/home.php?page=user&status=add_error");
        exit();
    }

}
?>



<!-- Add Homestay -->
<?php
include "../../config/connect.php";

$sql_homestay = "SELECT * FROM db_homestay";
$result_homestay = mysqli_query($conn, $sql_homestay);
if (isset($_POST['submit_homestay'])) {
    $mahomestay = $_POST['mahomestay'];
    $check_homestay = "SELECT mahomestay FROM db_homestay WHERE mahomestay = '$mahomestay'";
    $check_result = mysqli_query($conn, $check_homestay);
    if (mysqli_num_rows($check_result) > 0) {
        header("Location: ../home/home.php?page=add_homestay&status=exists");
        exit();
    }
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
    $target_dir = "../../Images/";
    $target_file = $target_dir . $image;
    if (move_uploaded_file($_FILES["hinhanh"]["name"], $target_file)) {
        $sql = "INSERT INTO db_homestay(mahomestay, tenhomestay, loaihinh, trangthai, sophong, giathue, sodienthoai, email, diachi, mota, tiennghi, chinhsach, hinhanh, diemdanhgia, soluotdanhgia)
        VALUES ('$mahomestay','$tenhomestay','$loaihinh','$trangthai','$sophong','$giathue','$sodienthoai','$email','$diachi','$mota','$tiennghi','$chinhsach','$image','$diemdanhgia','$soluotdanhgia')";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            header("Location: ../home/home.php?page=homestay&status=add_success");
            exit();
        } else {
            header("Location: ../home/home.php?page=homestay&status=add_error");
            exit();
        }
    } else {
        header("Location: ../home/home.php?page=homestay&status=error_upload");
        exit();
    }
}
?>



<!-- Add Rooms -->
<?php
include "../../config/connect.php";

$sql_room = "SELECT * FROM db_phong";
$result_room = mysqli_query($conn, $sql_room);
if (isset($_POST['submit_room'])) {
    $maphong = $_POST['maphong'];
    // Kiểm tra mã phòng đã tồn tại chưa
    $check_room = "SELECT maphong FROM db_phong WHERE maphong = '$maphong'";
    $check_result = mysqli_query($conn, $check_room);
    if (mysqli_num_rows($check_result) > 0) {
        header("Location: ../home/home.php?page=add_rooms&status=exists");
        exit();
    }
    $tenhomestay = $_POST['tenhomestay'];
    $tenphong = $_POST['tenphong'];
    $loaiphong = $_POST['loaiphong'];
    $mota = $_POST['mota'];
    $succhua = $_POST['succhua'];
    $gia = $_POST['gia'];
    $trangthai = $_POST['trangthai'];
    $hinhanh = basename($_FILES['hinhanh']['name']);
    $target_dir = "../../Images/";
    $target_file = $target_dir . $hinhanh;
    if (move_uploaded_file($_FILES["hinhanh"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO db_phong(tenhomestay, maphong, tenphong, loaiphong, mota, succhua, gia, trangthai, hinhanh)
        VALUES ('$tenhomestay','$maphong','$tenphong','$loaiphong','$mota','$succhua','$gia','$trangthai','$hinhanh')";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            header("Location: ../home/home.php?page=rooms&status=add_success");
            exit();
        } else {
            header("Location: ../home/home.php?page=rooms&status=add_error");
            exit();
        }
    } else {
        header("Location: ../home/home.php?page=rooms&status=error_upload");
        exit();
    }
}
?>

<!-- Add Booking -->
<?php
include "../../config/connect.php";

$sql_booking = "SELECT * FROM db_booking";
$result_booking = mysqli_query($conn, $sql_booking);
if (isset($_POST['submit_booking'])) {
    $madondatphong = $_POST['madondatphong'];
    // Kiểm tra mã đơn đặt phòng đã tồn tại chưa
    $check_booking = "SELECT madondatphong FROM db_booking WHERE madondatphong = '$madondatphong'";
    $check_result = mysqli_query($conn, $check_booking);
    if (mysqli_num_rows($check_result) > 0) {
        header("Location: ../home/home.php?page=add_booking&status=exists");
        exit();
    }
    $tenkhachhang = $_POST['tenkhachhang'];
    $mahomestay = $_POST['mahomestay'];
    $maphong = $_POST['maphong'];
    $ngaydatphong = $_POST['ngaydatphong'];
    $ngaynhanphong = $_POST['ngaynhanphong'];
    $ngaytraphong = $_POST['ngaytraphong'];
    $songuoi = $_POST['songuoi'];
    $tongtien = $_POST['tongtien'];
    $trangthai = $_POST['trangthai'];
    $sql = "INSERT INTO db_booking(madondatphong, tenkhachhang, mahomestay, maphong, ngaydatphong, ngaynhanphong, ngaytraphong, songuoi, tongtien, trangthai)
    VALUES ('$madondatphong','$tenkhachhang','$mahomestay','$maphong','$ngaydatphong','$ngaynhanphong','$ngaytraphong','$songuoi','$tongtien','$trangthai')";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("Location: ../home/home.php?page=account&status=add_success");
        exit();
    } else {
        header("Location: ../home/home.php?page=account&status=add_error");
        exit();
    }
}
?>

<!-- Add Payment -->
<?php
include "../../config/connect.php";

$sql_payment = "SELECT * FROM db_payment";
$result_payment = mysqli_query($conn, $sql_payment);
if (isset($_POST['submit_payment'])) {
    $mathanhtoan = $_POST['mathanhtoan'];
    // Kiểm tra mã thanh toán đã tồn tại chưa
    $check_payment = "SELECT mathanhtoan FROM db_payment WHERE mathanhtoan = '$mathanhtoan'";
    $check_result = mysqli_query($conn, $check_payment);
    if (mysqli_num_rows($check_result) > 0) {
        header("Location: ../home/home.php?page=add_payment&status=exists");
        exit();
    }
    $madondatphong = $_POST['madondatphong'];
    $hinhthucthanhtoan = $_POST['hinhthucthanhtoan'];
    $sotien = $_POST['sotien'];
    $ngaythanhtoan = $_POST['ngaythanhtoan'];
    $trangthai = $_POST['trangthai'];
    $sql = "INSERT INTO db_payment(mathanhtoan, madondatphong, hinhthucthanhtoan, sotien, ngaythanhtoan, trangthai)
    VALUES ('$mathanhtoan','$madondatphong','$hinhthucthanhtoan','$sotien','$ngaythanhtoan','$trangthai')";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("Location: ../home/home.php?page=account&status=add_success");
        exit();
    } else {
        header("Location: ../home/home.php?page=account&status=add_error");
        exit();
    }
}
?>



