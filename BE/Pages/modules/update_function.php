<?php
include "../../config/connect.php";
// ------------ Account ------------
if (isset($_POST['submit_account'])) {
    $account_id= $_POST['account_id'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    
    $sql = "UPDATE db_account SET 
                fullname='$fullname', 
                phone='$phone',
                email = '$email', 
                password='$password', 
                role='$role' 
            WHERE account_id='$account_id'";
    
    $query = mysqli_query($conn, $sql);
    if ($query&& mysqli_affected_rows($conn) > 0) {
        header("Location: ../home/home.php?page=account&status=update_success");
        exit();
    } else {
        header("Location: ../home/home.php?page=account&status=update_error");
        exit();
    }
}
?>


<?php
include "../../config/connect.php";
// ------------ Customer ------------
if (isset($_POST['submit_user'])) {
    $customer_id = $_POST['customer_id'];
    $temp = $_POST['account_id'];
    if ($temp == '' || $temp == null) {
        $account_id = "NULL";
    } else {
        $account_id = (int)$temp;
    }
    $fullname = $_POST['fullname'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    
    $sql = "UPDATE db_customer SET 
                account_id=$account_id,
                fullname='$fullname', 
                birthday='$birthday', 
                gender='$gender', 
                email='$email', 
                phone='$phone', 
                address='$address' 
            WHERE customer_id='$customer_id'";
            
    $query = mysqli_query($conn, $sql);
    if ($query&& mysqli_affected_rows($conn) > 0) {
        header("Location: ../home/home.php?page=user&status=update_success");
        exit();
    } else {
        header("Location: ../home/home.php?page=user&status=update_error");
        exit();
    }
}
?>

<?php
include "../../config/connect.php";

if (isset($_POST['submit_admin'])) {
    $admin_id = $_POST['admin_id'];
    $temp = $_POST['account_id'];
    $account_id = ($temp == '' || $temp == null) ? "NULL" : (int)$temp;

    $fullname = $_POST['fullname'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $image = null;
    if (isset($_FILES['image'])) {
        $image = basename($_FILES['image']['name']);
        $target_dir = "../../Images/";
        $target_file = $target_dir . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    }
    if (!empty($image)) {
        $sql = "UPDATE db_admin SET 
                    account_id=$account_id,
                    fullname='$fullname', 
                    birthday='$birthday', 
                    gender='$gender', 
                    email='$email', 
                    phone='$phone', 
                    `address`='$address',
                    `image`='$image'
                WHERE admin_id='$admin_id'";
    } else {
        $sql = "UPDATE db_admin SET 
                    account_id=$account_id,
                    fullname='$fullname', 
                    birthday='$birthday', 
                    gender='$gender', 
                    email='$email', 
                    phone='$phone', 
                    `address`='$address'
                WHERE admin_id='$admin_id'";
    }

    $query = mysqli_query($conn, $sql);

    if ($query && mysqli_affected_rows($conn) > 0) {
        header("Location: ../home/home.php?page=admin&status=update_success");
        exit();
    } else {
        header("Location: ../home/home.php?page=admin&status=update_error");
        exit();
    }
}
?>

<?php
include "../../config/connect.php";
// ------------ Owner ------------
if (isset($_POST['submit_owner'])) {
    $owner_id = $_POST['owner_id'];
    $temp = $_POST['account_id'];
    if ($temp == '' || $temp == null) {
        $account_id = "NULL";
    } else {
        $account_id = (int)$temp;
    }
    $fullname = $_POST['fullname'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    
    $sql = "UPDATE db_owner SET 
                account_id=$account_id,
                fullname='$fullname', 
                birthday='$birthday', 
                gender='$gender', 
                email='$email', 
                phone='$phone', 
                address='$address' 
            WHERE owner_id='$owner_id'";
            
    $query = mysqli_query($conn, $sql);
    if ($query&& mysqli_affected_rows($conn) > 0) {
        header("Location: ../home/home.php?page=owner&status=update_success");
        exit();
    } else {
        header("Location: ../home/home.php?page=owner&status=update_error");
        exit();
    }
}
?>


<?php
include "../../config/connect.php";
// ------------ Homestay ------------
if (isset($_POST['submit_homestay'])) {
    $homestay_id = $_POST['homestay_id'];
    $homestay_name = mysqli_real_escape_string($conn, $_POST['homestay_name']);
    $room_type = $_POST['room_type'];
    $guests = $_POST['guests'];
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
    $address = $_POST['address'];
    $description = $_POST['description'];
    $policy = $_POST['policy'];
    $rating = $_POST['rating'];
    $reviews_count = $_POST['reviews_count'];

    $update_fields = "
        homestay_name='$homestay_name',
        room_type='$room_type',
        `status`='$status',
        price='$price',
        owner_id=$owner_id,
        homestay_phone='$homestay_phone',
        homestay_email='$homestay_email',
        `address`='$address',
        `description`='$description',
        checkin='$checkin',
        checkout='$checkout',
        guests='$guests',
        `policy`='$policy',
        rating='$rating',
        reviews_count='$reviews_count'
    ";

    $image_fields = [
        'img'  => 'image_new',
        'img1' => 'image1_new',
        'img2' => 'image2_new',
        'img3' => 'image3_new'
    ];

    foreach ($image_fields as $db_field => $input_name) {
        if (!empty($_FILES[$input_name]['name'])) {
            $file_name = basename($_FILES[$input_name]['name']);
            $target_file = "../../../FE/images/" . $file_name;

            if (move_uploaded_file($_FILES[$input_name]['tmp_name'], $target_file)) {
                $update_fields .= ", `$db_field` = '" . $file_name . "'";
            }
        }
    }

    $sql = "UPDATE db_homestay SET $update_fields WHERE homestay_id='$homestay_id'";

    $query = mysqli_query($conn, $sql);

    if ($query && mysqli_affected_rows($conn) >= 0) {
        header("Location: ../home/home.php?page=homestay&action_status=update_success");
        exit();
    } else {
        header("Location: ../home/home.php?page=homestay&action_status=update_error");
        exit();
    }
}
?>





<?php
include "../../config/connect.php";
// ------------ Booking ------------
if (isset($_POST['submit_booking'])) {
    $booking_id = $_POST['booking_id'];
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

    $sql = "UPDATE db_booking SET 
                homestay_id ='$homestay_id',
                customer_id=$customer_id, 
                customer_name='$customer_name',
                customer_email='$customer_email', 
                customer_phone='$customer_phone',  
                created_at='$date_booking', 
                checkin_date='$date_checkin', 
                checkout_date='$date_checkout', 
                guests='$guests',
                payment_method='$payment_method', 
                total_price='$booking_price', 
                `status`='$booking_status',
                payment_status='$payment_status', 
                payment_date='$payment_date',  
                note='$note' 
            WHERE booking_id='$booking_id'";
            
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("Location: ../home/home.php?page=booking&action_status=update_success");
        exit();
    } else {
        header("Location: ../home/home.php?page=booking&action_status=update_error");
        exit();
    }
}
?>

<?php
include "../../config/connect.php";
// ------------ Payment ------------
$action = isset($_GET['action']) ? $_GET['action'] :'';
if (isset($_POST['done_payment'])) {
    $booking_id = $_POST['payment_id'];
    $payment_method = $_POST['payment_method'];
    $total_price = $_POST['total_price'];
    $payment_status = $_POST['payment_status'];
    $payment_date = $_POST['payment_date'];
    $sql = "UPDATE db_booking SET 
                payment_method = '$payment_method',
                total_price = '$total_price',
                payment_date = '$payment_date',
                payment_status = '$payment_status' WHERE booking_id = '$booking_id'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("Location: ../home/home.php?page=payment&status=success_payment");
        exit();
    } else {
    header("Location: ../home/home.php?page=payment&status=error_payment");
        exit();
    }
}

if (isset($_POST['submit_payment'])) {
    $booking_id = $_POST['payment_id'];
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $customer_phone = $_POST['customer_phone'];
    $payment_method = $_POST['payment_method'];
    $total_price = $_POST['total_price'];
    $payment_date = $_POST['payment_date'];
    $payment_status = $_POST['payment_status'];
    
    $sql = "UPDATE db_booking SET
                customer_name ='$customer_name',
                customer_email ='$customer_email',
                customer_phone ='$customer_phone',
                payment_method = '$payment_method',
                total_price = '$total_price',
                payment_date = '$payment_date',
                payment_status = '$payment_status' 
            WHERE booking_id='$booking_id'";
            
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("Location: ../home/home.php?page=payment&status=update_success");
        exit();
    } else {
        header("Location: ../home/home.php?page=payment&status=update_error");
        exit();
    }
}
?>

<?php
include "../../config/connect.php";
$action = isset($_GET['action']) ? $_GET['action'] :'';
// ------------ Reviews ------------
if (isset($_POST['submit_review'])) {
    $review_id =  $_POST['review_id'];
    $content_feedback = $_POST['content_feedback'];
    $status_review = $_POST['status_review'];
    $sql = "UPDATE db_review SET
    content_feedback ='$content_feedback', 
    status_review = '$status_review' 
    WHERE review_id='$review_id'";         
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("Location: ../home/home.php?page=reviews&status=update_success");
        exit();
    } else {
        header("Location: ../home/home.php?page=reviews&status=update_error");
        exit();
    }
}
?>
