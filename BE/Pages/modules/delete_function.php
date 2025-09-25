<?php 
include "../../config/connect.php";
$action = isset($_GET['action']) ? $_GET['action'] :'';

// ------------------ Xóa account ---------------------
if ($action === 'delete_account') {
    $delete_account = isset($_GET['id']) ? $_GET['id'] : null;
    
    if ($delete_account) {
        $sql = "DELETE FROM db_account WHERE email = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $delete_account);
            
            if ($stmt->execute()) {
                header("Location: home.php?page=account&status=delete_success");
                exit();
            } else {
                header("Location: home.php?page=account&status=delete_error");
                exit();
            }
        } else {
            // Lỗi khi chuẩn bị truy vấn
            // echo "<script>alert('Lỗi: " . $conn->error . "');</script>";
        }
    } else {
        // Không có email được cung cấp
        // echo "<script>alert('Không tìm thấy tài khoản để xóa.');</script>";
    }
}

// Xóa user
if ($action === 'delete_user') {
    $delete_user = isset($_GET['id']) ? $_GET['id'] : null;
    
    if ($delete_user) {
        $sql = "DELETE FROM db_khachhang WHERE makhachhang = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $delete_user);
            
            if ($stmt->execute()) {
                header("Location: home.php?page=user&status=delete_success");
            } else {
                header("Location: home.php?page=user&status=delete_error");
            }
            exit();
        }
    }
}

// Xóa homestay
if (isset($_GET['page']) && $_GET['page'] == 'delete_homestay') {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $sql = "DELETE FROM db_homestay WHERE mahomestay = '$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: home.php?page=homestay&status=delete_success");
    } else {
        header("Location: home.php?page=homestay&status=delete_error");
    }
    exit();
}

// Xóa phòng
if (isset($_GET['page']) && $_GET['page'] == 'delete_rooms') {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $sql = "DELETE FROM db_phong WHERE maphong = '$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: home.php?page=rooms&status=delete_success");
    } else {
        header("Location: home.php?page=rooms&status=delete_error");
    }
    exit();
}

// Xóa booking
if (isset($_GET['page']) && $_GET['page'] == 'delete_booking') {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $sql = "DELETE FROM db_booking WHERE madondatphong = '$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: home.php?page=booking&status=delete_success");
    } else {
        header("Location: home.php?page=booking&status=delete_error");
    }
    exit();
}

// Xóa payment
if (isset($_GET['page']) && $_GET['page'] == 'delete_payment') {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $sql = "DELETE FROM db_payment WHERE mathanhtoan = '$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: home.php?page=payment&status=delete_success");
    } else {
        header("Location: home.php?page=payment&status=delete_error");
    }
    exit();
}
?>