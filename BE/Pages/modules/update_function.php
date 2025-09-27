<?php
include "../../config/connect.php";
// ------------ Account ------------
if (isset($_POST['submit_account'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    
    $sql = "UPDATE db_account SET 
                fullname='$fullname', 
                phone='$phone', 
                password='$password', 
                role='$role' 
            WHERE email='$email'";
    
    $query = mysqli_query($conn, $sql);
    if ($query) {
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
    $customer_name = $_POST['customer_name'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $customer_phone = $_POST['customer_phone'];
    $address = $_POST['address'];
    
    $sql = "UPDATE db_customer SET 
                customer_name='$customer_name', 
                birthday='$birthday', 
                gender='$gender', 
                email='$email', 
                customer_phone='$customer_phone', 
                address='$address' 
            WHERE customer_id='$customer_id'";
            
    $query = mysqli_query($conn, $sql);
    if ($query) {
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
// ------------ Homestay ------------
if (isset($_POST['submit_homestay'])) {
    $homestay_id = $_POST['homestay_id'];
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
    $target_dir = "../../../Images/";
    $target_file = $target_dir . $image;
    
    if (!empty($image) && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $sql = "UPDATE db_homestay SET 
                    homestay_name='$homestay_name', 
                    homestay_type='$homestay_type', 
                    homestay_status='$homestay_status', 
                    room_number='$room_number', 
                    home_price='$home_price', 
                    phone_owner='$phone_owner', 
                    email='$email', 
                    homestay_address='$homestay_address', 
                    `describe`='$describe', 
                    amenities='$amenities', 
                    `policy`='$policy', 
                    image='$image', 
                    home_rating='$home_rating', 
                    rating_number='$rating_number' 
                WHERE homestay_id='$homestay_id'";
    } else {
        $sql = "UPDATE db_homestay SET 
                    homestay_name='$homestay_name', 
                    homestay_type='$homestay_type', 
                    homestay_status='$homestay_status', 
                    room_number='$room_number', 
                    home_price='$home_price', 
                    phone_owner='$phone_owner', 
                    email='$email', 
                    homestay_address='$homestay_address', 
                    `describe`='$describe', 
                    amenities='$amenities', 
                    `policy`='$policy', 
                    home_rating='$home_rating', 
                    rating_number='$rating_number' 
                WHERE homestay_id='$homestay_id'";
    }
    
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("Location: ../home/home.php?page=homestay&status=update_success");
        exit();
    } else {
        header("Location: ../home/home.php?page=homestay&status=update_error");
        exit();
    }
}
?>



<?php
include "../../config/connect.php";
// ------------ Rooms ------------
if (isset($_POST['submit_room'])) {
    $room_id = $_POST['room_id']; 
    $room_name = $_POST['room_name'];
    $room_type = $_POST['room_type'];
    $homestay_name = $_POST['homestay_name'];
    $room_describe = $_POST['room_describe'];
    $room_people = $_POST['room_people'];
    $room_price = $_POST['room_price'];
    $room_status = $_POST['room_status'];
    
    $image_room = basename($_FILES['image_room']['name']);
    $target_dir = "../../../Images/";
    $target_file = $target_dir . $image_room;
    
    if (!empty($image_room) && move_uploaded_file($_FILES["image_room"]["tmp_name"], $target_file)) {
        $sql = "UPDATE db_room SET 
                    room_name='$room_name', 
                    room_type='$room_type', 
                    homestay_name='$homestay_name', 
                    room_describe='$room_describe', 
                    room_people='$room_people', 
                    room_price='$room_price', 
                    room_status='$room_status', 
                    image_room='$image_room' 
                WHERE room_id='$room_id'";
    } else {
        $sql = "UPDATE db_room SET 
                    room_name='$room_name', 
                    room_type='$room_type', 
                    homestay_name='$homestay_name', 
                    room_describe='$room_describe', 
                    room_people='$room_people', 
                    room_price='$room_price', 
                    room_status='$room_status' 
                WHERE room_id='$room_id'";
    }
    
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("Location: ../home/home.php?page=rooms&status=update_success");
        exit();
    } else {
        header("Location: ../home/home.php?page=rooms&status=update_error");
        exit();
    }
}
?>

<?php
include "../../config/connect.php";
// ------------ Booking ------------
if (isset($_POST['submit_booking'])) {
    $booking_id = $_POST['booking_id'];
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

    $sql = "UPDATE db_booking SET 
                customer_id='$customer_id', 
                customer_name='$customer_name', 
                homestay_id='$homestay_id', 
                room_id='$room_id', 
                date_booking='$date_booking', 
                date_checkin='$date_checkin', 
                date_checkout='$date_checkout', 
                booking_people='$booking_people', 
                booking_price='$booking_price', 
                booking_status='$booking_status', 
                note='$note' 
            WHERE booking_id='$booking_id'";
            
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("Location: ../home/home.php?page=booking&status=update_success");
        exit();
    } else {
        header("Location: ../home/home.php?page=booking&status=update_error");
        exit();
    }
}
?>

<?php
include "../../config/connect.php";
// ------------ Payment ------------
if (isset($_POST['submit_payment'])) {
    $payment_id = $_POST['payment_id'];
    $booking_id = $_POST['booking_id'];
    $method = $_POST['method'];
    $payment_price = $_POST['payment_price'];
    $date = $_POST['date'];
    $payment_status = $_POST['payment_status'];
    
    $sql = "UPDATE db_payment SET 
                booking_id='$booking_id', 
                method='$method', 
                payment_price='$payment_price', 
                date='$date', 
                payment_status='$payment_status' 
            WHERE payment_id='$payment_id'";
            
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
// ------------ Reviews ------------
if (isset($_POST['submit_review'])) {
    $review_id = $_POST['review_id']; 
    $customer_id = $_POST['customer_id'];
    $room_id = $_POST['room_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $rating = $_POST['rating'];
    $date = $_POST['date'];
    $review_status = $_POST['review_status'];
    
    $sql = "UPDATE db_review SET 
                customer_id='$customer_id', 
                room_id='$room_id', 
                title='$title', 
                content='$content', 
                rating='$rating', 
                date='$date', 
                review_status='$review_status' 
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

<?php
include "../../config/connect.php";
// ------------ Feedback ------------
if (isset($_POST['submit_feedback'])) {
    $feedback_id = $_POST['feedback_id'];
    $customer_id = $_POST['customer_id'];
    $customer_name = $_POST['customer_name'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $date = $_POST['date'];
    $feedback_status = $_POST['feedback_status'];
    $reply = $_POST['reply'];
    
    $sql = "UPDATE db_feedback SET 
                customer_id='$customer_id', 
                customer_name='$customer_name', 
                title='$title', 
                content='$content', 
                date='$date', 
                feedback_status='$feedback_status', 
                reply='$reply' 
            WHERE feedback_id='$feedback_id'";
            
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("Location: ../home/home.php?page=feedback&status=update_success");
        exit();
    } else {
        header("Location: ../home/home.php?page=feedback&status=update_error");
        exit();
    }
}
?>