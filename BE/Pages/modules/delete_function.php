<?php 
include "../../config/connect.php";
$action = isset($_GET['action']) ? $_GET['action'] :'';

// ------------------- Xóa account ---------------------
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
        }
    }
}

// ---------------------- Xóa user -------------------
if ($action === 'delete_user') {
    $delete_user = isset($_GET['id']) ? $_GET['id'] : null;
    if ($delete_user) {
        $sql = "DELETE FROM db_customer WHERE customer_id = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $delete_user);
            
            if ($stmt->execute()) {
                header("Location: home.php?page=user&status=delete_success");
                exit();
            } else {
                header("Location: home.php?page=user&status=delete_error");
                exit();
            }
        }
    }
}

// ------------------- Xóa homestay -----------------
if ($action === 'delete_homestay') {
    $delete_homestay = isset($_GET['id']) ? $_GET['id'] : null;
    if ($delete_homestay) {
        $sql = "DELETE FROM db_homestay WHERE homestay_id = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $delete_homestay);
            
            if ($stmt->execute()) {
                header("Location: home.php?page=homestay&status=delete_success");
                exit();
            } else {
                header("Location: home.php?page=homestay&status=delete_error");
                exit();
            }
        }
    }
}

// --------------------- Xóa phòng -----------------
if ($action === 'delete_room') {
    $delete_room = isset($_GET['id']) ? $_GET['id'] : null;
    if ($delete_room) {
        $sql = "DELETE FROM db_room WHERE room_id = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $delete_room);
            
            if ($stmt->execute()) {
                header("Location: home.php?page=rooms&status=delete_success");
                exit();
            } else {
                header("Location: home.php?page=rooms&status=delete_error");
                exit();
            }
        }
    }
}

// -------------------- Xóa booking --------------------
if ($action === 'delete_booking') {
    $delete_booking = isset($_GET['id']) ? $_GET['id'] : null;
    if ($delete_booking) {
        $sql = "DELETE FROM db_booking WHERE booking_id = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $delete_booking);
            
            if ($stmt->execute()) {
                header("Location: home.php?page=booking&status=delete_success");
                exit();
            } else {
                header("Location: home.php?page=booking&status=delete_error");
                exit();
            }
        }
    }
}

// ---------------------- Xóa payment -----------------------
if ($action === 'delete_payment') {
    $delete_payment = isset($_GET['id']) ? $_GET['id'] : null;
    if ($delete_payment) {
        $sql = "DELETE FROM db_payment WHERE payment_id = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $delete_payment);
            
            if ($stmt->execute()) {
                header("Location: home.php?page=payment&status=delete_success");
                exit();
            } else {
                header("Location: home.php?page=payment&status=delete_error");
                exit();
            }
        }
    }
}

// ---------------------- Xóa đánh giá -----------------------
if ($action === 'delete_review') {
    $delete_review = isset($_GET['id']) ? $_GET['id'] : null;
    if ($delete_review) {
        $sql = "DELETE FROM db_review WHERE review_id = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $delete_review);
            
            if ($stmt->execute()) {
                header("Location: home.php?page=reviews&status=delete_success");
                exit();
            } else {
                header("Location: home.php?page=reviews&status=delete_error");
                exit();
            }
        }
    }
}

// ---------------------- Xóa khiếu nại -----------------------
if ($action === 'delete_homestay') {
    $delete_homestay = isset($_GET['id']) ? $_GET['id'] : null;
    if ($delete_homestay) {
        $sql = "DELETE FROM db_homestay WHERE homestay_id = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $delete_homestay);
            
            if ($stmt->execute()) {
                header("Location: home.php?page=homestay&status=delete_success");
                exit();
            } else {
                header("Location: home.php?page=homestay&status=delete_error");
                exit();
            }
        }
    }
}
?>