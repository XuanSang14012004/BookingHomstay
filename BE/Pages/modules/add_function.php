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
        header("Location: ../home/home.php?page=account&action=add_account&status=exists");
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


<!-- Add Customer -->
<?php
include "../../config/connect.php";

$sql_user = "SELECT * FROM db_customer";
$result_user = mysqli_query($conn, $sql_user);

if (isset($_POST['submit_user'])) {
    $temp = $_POST['account_id'];
    if ($temp == '' || $temp == null) {
        $account_id = "NULL";
    } else {
        $account_id = (int)$temp;
    }
    $fullname =  $_POST['fullname'];
    $birthday = $_POST['birthday'];          
    $gender = $_POST['gender']; 
    $email = $_POST['email'];    
    $customer_phone = $_POST['phone']; 
    $address = $_POST['address'];   
    
    $sql = "INSERT INTO db_customer( account_id,fullname, birthday, gender, email, phone, address)
    VALUES ($account_id,'$fullname','$birthday','$gender','$email','$customer_phone','$address')";
    
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

<!-- Add Admin -->
<?php
include "../../config/connect.php";

$sql_admin = "SELECT * FROM db_admin";
$result_admin = mysqli_query($conn, $sql_admin);

if (isset($_POST['submit_admin'])) {
    $temp = $_POST['account_id'];
    if ($temp == '' || $temp == null) {
        $account_id = "NULL";
    } else {
        $account_id = (int)$temp;
    }
    $fullname =  $_POST['fullname'];
    $birthday = $_POST['birthday'];          
    $gender = $_POST['gender']; 
    $email = $_POST['email'];    
    $phone = $_POST['phone']; 
    $address = $_POST['address'];  
    
    $image = null;
    $target_dir = "../../Images/";

    if (isset($_FILES['image'])) {
        $image = basename($_FILES['image']['name']);
        $target_file = $target_dir . $image;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        } else {
            $image = null;
        }
    }
    if ($image) {
        $sql = "INSERT INTO db_admin (account_id, fullname, birthday, gender, email, phone, address, image)
                VALUES ($account_id, '$fullname', '$birthday', '$gender', '$email', '$phone', '$address', '$image')";
    } else {
        $sql = "INSERT INTO db_admin (account_id, fullname, birthday, gender, email, phone, address)
                VALUES ($account_id, '$fullname', '$birthday', '$gender', '$email', '$phone', '$address')";
    }

    if (!empty($sql)) {
        $query = mysqli_query($conn, $sql);

        if ($query) {
            header("Location: ../home/home.php?page=admin&status=add_success");
            exit();
        } else {
            header("Location: ../home/home.php?page=admin&status=add_error");
            exit();
        }
    } 
}
?>

<!-- Add Owner -->
<?php
include "../../config/connect.php";

$sql_owner = "SELECT * FROM db_owner";
$result_owner = mysqli_query($conn, $sql_owner);

if (isset($_POST['submit_owner'])) {
    $temp = $_POST['account_id'];
    if ($temp == '' || $temp == null) {
        $account_id = "NULL";
    } else {
        $account_id = (int)$temp;
    }
    $fullname =  $_POST['fullname'];
    $birthday = $_POST['birthday'];          
    $gender = $_POST['gender']; 
    $email = $_POST['email'];    
    $phone = $_POST['phone']; 
    $address = $_POST['address'];   
    
    $sql = "INSERT INTO db_owner( account_id,fullname, birthday, gender, email, phone, address)
    VALUES ($account_id,'$fullname','$birthday','$gender','$email','$phone','$address')";
    
    $query = mysqli_query($conn, $sql);
    
    if ($query) {
        header("Location: ../home/home.php?page=owner&status=add_success");
        exit();
    } else {
        header("Location: ../home/home.php?page=owner&status=add_error");
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
    $homestay_name = $_POST['homestay_name'];
    $room_type = $_POST['room_type'];
    $status = $_POST['status'];
    $price = $_POST['price'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $temp = $_POST['owner_id'];
    if ($temp == '' || $temp == null) {
        $owner_id = "NULL";
    } else {
        $owner_id = (int)$temp;
    }
    $homestay_phone = $_POST['homestay_phone'];
    $homestay_email = $_POST['homestay_email'];
    $homestay_address = $_POST['address'];
    $description = $_POST['description'];
    $guests = $_POST['guests'];
    $policy = $_POST['policy'];
    $rating = $_POST['rating'];
    $reviews_count = $_POST['reviews_count'];
    
    $image ="../images/". basename($_FILES['img']['name']); 
    $target_dir = "../../../FE/images/";
    $target_file = $target_dir . $image;

    $image1 = "../images/". basename($_FILES['img1']['name']); 
    $target_dir = "../../../FE/images/";
    $target_file1 = $target_dir . $image1;

    $image2 = "../images/".basename($_FILES['img2']['name']); 
    $target_dir = "../../../FE/images/";
    $target_file2 = $target_dir . $image2;

    $image3 = "../images/".basename($_FILES['img3']['name']); 
    $target_dir = "../../../FE/images/";
    $target_file3 = $target_dir . $image3;

    if ((move_uploaded_file($_FILES["img"]["tmp_name"], $target_file))
        &&(move_uploaded_file($_FILES["img1"]["tmp_name"], $target_file1))
        &&(move_uploaded_file($_FILES["img2"]["tmp_name"], $target_file2))
        &&(move_uploaded_file($_FILES["img3"]["tmp_name"], $target_file3))) { 
        $sql = "INSERT INTO db_homestay( homestay_name, room_type, `status`, price, checkin, checkout, homestay_phone,owner_id, homestay_email, `address`, `description`,guests,`policy`, img, img1, img2, img3, rating, reviews_count)
        VALUES ('$homestay_name','$room_type','$status','$price','$checkin','$checkout','$homestay_phone',$owner_id,'$homestay_email','$homestay_address','$description','$guests','$policy','$image','$image1','$image2','$image3','$rating','$reviews_count')";
        $query = mysqli_query($conn, $sql);
        
        if ($query) {
            header("Location: ../home/home.php?page=homestay&action_status=add_success");
            exit();
        } else {
            header("Location: ../home/home.php?page=homestay&action_status=add_error");
            exit();
        }
    } else {
        header("Location: ../home/home.php?page=homestay&action_status=error_upload");
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
    $homestay_id = $_POST['homestay_id'];
    $temp = $_POST['customer_id'];
    if ($temp == '' || $temp == null) {
        $customer_id = "NULL";
    } else {
        $customer_id = (int)$temp;
    }
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $customer_phone = $_POST['customer_phone'];
    $date_booking = $_POST['created_at']; 
    $date_checkin = $_POST['checkin_date']; 
    $date_checkout = $_POST['checkout_date']; 
    $guests = $_POST['guests'];
    $payment_method = $_POST['payment_method'];
    $booking_price = $_POST['total_price']; 
    $booking_status = $_POST['status']; 
    $payment_status = $_POST['payment_status'];
    $payment_date = $_POST['payment_date'];  
    $note = $_POST['note']; 

    $sql = "INSERT INTO db_booking(homestay_id, customer_id, customer_name, customer_email, customer_phone, created_at, checkin_date, checkout_date, guests, payment_method, total_price, status, note)
    VALUES ('$homestay_id',$customer_id,'$customer_name','$customer_email','$customer_phone','$date_booking','$date_checkin','$date_checkout','$guests','$payment_method','$booking_price','$booking_status','$note')";
    
    $query = mysqli_query($conn, $sql);
    
    if ($query) {
        header("Location: ../home/home.php?page=booking&action_status=add_success");
        exit();
    } else {
        header("Location: ../home/home.php?page=booking&action_status=add_error");
        exit();
    }
}
?>



