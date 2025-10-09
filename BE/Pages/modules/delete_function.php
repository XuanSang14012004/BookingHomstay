<?php 
include "../../config/connect.php";
$action = isset($_GET['action']) ? $_GET['action'] :'';

// ------------------- Xóa account ---------------------
if ($action === 'delete_account') {
    $delete_account = isset($_GET['id']) ? $_GET['id'] : null;
    if ($delete_account) {
        $sql = "DELETE FROM db_account WHERE account_id = ?";
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

// ---------------------- Xóa admin -------------------
if ($action === 'delete_admin') {
    $delete_admin = isset($_GET['id']) ? $_GET['id'] : null;
    if ($delete_admin) {
        $sql = "DELETE FROM db_admin WHERE admin_id = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $delete_admin);
            
            if ($stmt->execute()) {
                header("Location: home.php?page=admin&status=delete_success");
                exit();
            } else {
                header("Location: home.php?page=admin&status=delete_error");
                exit();
            }
        }
    }
}

// ---------------------- Xóa owner -------------------
if ($action === 'delete_owner') {
    $delete_owner = isset($_GET['id']) ? $_GET['id'] : null;
    if ($delete_owner) {
        $sql = "DELETE FROM db_owner WHERE owner_id = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $delete_owner);
            
            if ($stmt->execute()) {
                header("Location: home.php?page=owner&status=delete_success");
                exit();
            } else {
                header("Location: home.php?page=owner&status=delete_error");
                exit();
            }
        }
    }
}

// ------------------- Xóa homestay -----------------
if ($action === 'delete_homestay') {
    $delete_homestay = isset($_GET['id']) ? $_GET['id'] : null;
    if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql_select = "SELECT img,img1,img2,img3 FROM db_homestay WHERE homestay_id = $id";
    $result = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $image_path = '../../../FE/images/' . $row['img'];
        $image_path1 = '../../../FE/images/' . $row['img1'];
        $image_path2 = '../../../FE/images/' . $row['img2'];
        $image_path3 = '../../../FE/images/' . $row['img3'];
        if (file_exists($image_path) && is_file($image_path)) {
            unlink($image_path);
        }
        if (file_exists($image_path1) && is_file($image_path1)) {
            unlink($image_path1);
        }
        if (file_exists($image_path2) && is_file($image_path2)) {
            unlink($image_path2);
        }
        if (file_exists($image_path3) && is_file($image_path3)) {
            unlink($image_path3);
        }
    }
}
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
        $sql = "DELETE FROM db_booking WHERE booking_id = ?";

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
if ($action === 'delete_feedback') {
    $delete_feedback = isset($_GET['id']) ? $_GET['id'] : null;
    if ($delete_feedback) {
        $sql = "DELETE FROM db_feedback WHERE feedback_id = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $delete_feedback);
            
            if ($stmt->execute()) {
                header("Location: home.php?page=feedback&status=delete_success");
                exit();
            } else {
                header("Location: home.php?page=feedback&status=delete_error");
                exit();
            }
        }
    }
}
?>