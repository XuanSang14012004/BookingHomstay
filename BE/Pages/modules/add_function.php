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
    $customer_id = $_POST['customer_id'];
    $check_user = "SELECT customer_id FROM db_customer WHERE customer_id = '$customer_id'";
    $check_result = mysqli_query($conn, $check_user);
    
    if (mysqli_num_rows($check_result) > 0) {
        header("Location: ../home/home.php?page=user&action=add_user&status=exists");
        exit();
    }
    $customer_name = $_POST['customer_name']; 
    $birthday = $_POST['birthday'];          
    $gender = $_POST['gender']; 
    $email = $_POST['email'];    
    $customer_phone = $_POST['customer_phone']; 
    $address = $_POST['address'];   
    
    $sql = "INSERT INTO db_customer(customer_id, customer_name, birthday, gender, email, customer_phone, address)
    VALUES ('$customer_id','$customer_name','$birthday','$gender','$email','$customer_phone','$address')";
    
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
    $homestay_id = $_POST['homestay_id']; 
    $check_homestay = "SELECT homestay_id FROM db_homestay WHERE homestay_id = '$homestay_id'";
    $check_result = mysqli_query($conn, $check_homestay);
    
    if (mysqli_num_rows($check_result) > 0) {
        header("Location: ../home/home.php?page=homestay&action=add_homestay&status=exists");
        exit();
    }
    $homestay_name = $_POST['homestay_name'];
    $homestay_type = $_POST['homestay_type'];
    $homestay_status = $_POST['homestay_status'];
    $room_number = $_POST['room_number'];
    $home_price = $_POST['home_price'];
    $phone_owner = $_POST['phone_owner'];
    $email = $_POST['email'];
    $homestay_address = $_POST['homestay_address'];
    $describe = $_POST['describe'];
    $amenities = $_POST['amenities'];
    $policy = $_POST['policy'];
    $home_rating = $_POST['home_rating'];
    $rating_number = $_POST['rating_number'];
    
    $image = basename($_FILES['image']['name']); 
    $target_dir = "../../Images/";
    $target_file = $target_dir . $image;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) { 
        $sql = "INSERT INTO db_homestay(homestay_id, homestay_name, homestay_type, homestay_status, room_number, home_price, phone_owner, email, homestay_address, `describe`, amenities, `policy`, `image`, home_rating, rating_number)
        VALUES ('$homestay_id','$homestay_name','$homestay_type','$homestay_status','$room_number','$home_price','$phone_owner','$email','$homestay_address','$describe','$amenities','$policy','$image','$home_rating','$rating_number')";
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

$sql_room = "SELECT * FROM db_room"; 
$result_room = mysqli_query($conn, $sql_room);

if (isset($_POST['submit_room'])) {
    $room_id = $_POST['room_id'];
    
    // Kiểm tra mã phòng đã tồn tại chưa
    $check_room = "SELECT room_id FROM db_room WHERE room_id = '$room_id'";
    $check_result = mysqli_query($conn, $check_room);
    
    if (mysqli_num_rows($check_result) > 0) {
        header("Location: ../home/home.php?page=rooms&action=add_room&status=exists");
        exit();
    }
    
    $room_name = $_POST['room_name'];
    $room_type = $_POST['room_type'];
    $temp = $_POST['homestay_name'];
    $homestay_name = mysqli_real_escape_string($conn, $temp);
    $room_describe = $_POST['room_describe'];
    $room_people = $_POST['room_people'];
    $room_price = $_POST['room_price'];
    $room_status = $_POST['room_status'];
    
    $image_room = basename($_FILES['image_room']['name']); 
    $target_dir = "../../Images/";
    $target_file = $target_dir . $image_room;
    
    if (move_uploaded_file($_FILES["image_room"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO db_room(room_id, room_name, room_type, homestay_name, room_describe, room_people, room_status, room_price, image_room)
        VALUES ('$room_id','$room_name','$room_type','$homestay_name','$room_describe','$room_people','$room_status','$room_price','$image_room')";
        
        $query = mysqli_query($conn, $sql);
        
        if ($query&& mysqli_affected_rows($conn) > 0) {
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
    $booking_id = $_POST['booking_id']; 

    $check_booking = "SELECT booking_id FROM db_booking WHERE booking_id = '$booking_id'";
    $check_result = mysqli_query($conn, $check_booking);
    if (mysqli_num_rows($check_result) > 0) {
        header("Location: ../home/home.php?page=booking&action=add_booking&status=exists");
        exit();
    }
    $customer_id = $_POST['customer_id'];
    $customer_name = $_POST['customer_name'];
    $homestay_id = $_POST['homestay_id']; 
    $room_id = $_POST['room_id'];
    $date_booking = $_POST['date_booking']; 
    $date_checkin = $_POST['date_checkin']; 
    $date_checkout = $_POST['date_checkout']; 
    $booking_people = $_POST['booking_people'];
    $booking_price = $_POST['booking_price']; 
    $booking_status = $_POST['booking_status']; 
    $note = $_POST['note']; 

    $sql = "INSERT INTO db_booking(booking_id, customer_id, customer_name, homestay_id, room_id, date_booking, date_checkin, date_checkout, booking_people, booking_price, booking_status, note)
    VALUES ('$booking_id','$customer_id','$customer_name','$homestay_id','$room_id','$date_booking','$date_checkin','$date_checkout','$booking_people','$booking_price','$booking_status','$note')";
    
    $query = mysqli_query($conn, $sql);
    
    if ($query) {
        header("Location: ../home/home.php?page=booking&status=add_success");
        exit();
    } else {
        header("Location: ../home/home.php?page=booking&status=add_error");
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
    $payment_id = $_POST['payment_id'];

    $check_payment = "SELECT payment_id FROM db_payment WHERE payment_id = '$payment_id'";
    $check_result = mysqli_query($conn, $check_payment);
    
    if (mysqli_num_rows($check_result) > 0) {
        header("Location: ../home/home.php?page=payment&action=add_payment&status=exists");
        exit();
    }
    
    $booking_id = $_POST['booking_id']; 
    $method = $_POST['method'];
    $payment_price = $_POST['payment_price'];  
    $date = $_POST['date']; 
    $payment_status = $_POST['payment_status']; 

    $sql = "INSERT INTO db_payment(payment_id, booking_id, method, payment_price, date, payment_status)
    VALUES ('$payment_id','$booking_id','$method','$payment_price','$date','$payment_status')";
    
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


