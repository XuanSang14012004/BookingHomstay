<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_bookinghomestay";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo 'Fail to connect DB ' . $conn->connect_error;
} else {
    // echo 'Connect successful';
}
