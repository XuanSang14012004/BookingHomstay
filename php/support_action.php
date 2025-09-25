<?php
include 'config.php';
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors',1);

if(isset($_POST['action'])){
    $action = $_POST['action'];

    if($action=='save'){
        $id = $_POST['id'];
        $customerName = $_POST['customerName'];
        $email = $_POST['email'];
        $titel = $_POST['titel'];
        $content = $_POST['content'];
        $dateSupport = date('Y-m-d');

        if(empty($id)){
            $stmt = $conn->prepare("INSERT INTO support (customerName,email,titel,content,dateSupport,statusSupport) VALUES (?,?,?,?,?,?)");
            $status = 'Đang xử lý';
            $stmt->bind_param("ssssss",$customerName,$email,$titel,$content,$dateSupport,$status);
            echo $stmt->execute() ? 'success' : 'error: '.$stmt->error;
        } else {
            $stmt = $conn->prepare("UPDATE support SET customerName=?,email=?,titel=?,content=? WHERE id=?");
            $stmt->bind_param("ssssi",$customerName,$email,$titel,$content,$id);
            echo $stmt->execute() ? 'success' : 'error: '.$stmt->error;
        }
        exit;
    }

    if($action=='reply'){
        $id = $_POST['id'];
        $feedbacksp = $_POST['feedbacksp'];
        $stmt = $conn->prepare("UPDATE support SET feedbacksp=?,statusSupport='Đã phản hồi' WHERE id=?");
        $stmt->bind_param("si",$feedbacksp,$id);
        echo $stmt->execute() ? 'success' : 'error: '.$stmt->error;
        exit;
    }

    if($action=='delete'){
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM support WHERE id=?");
        $stmt->bind_param("i",$id);
        echo $stmt->execute() ? 'success' : 'error: '.$stmt->error;
        exit;
    }
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM support WHERE id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    echo json_encode($res);
    exit;
}
?>
