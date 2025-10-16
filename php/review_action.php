<?php
include 'config.php';
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors',1);

if(isset($_POST['action'])){
    $action = $_POST['action'];
    
    if($action == 'save'){
        $id = $_POST['id'];
        $feedback = $_POST['feedback'];
        $stmt = $conn->prepare("UPDATE review SET feedback=? WHERE id=?");
        $stmt->bind_param("si",$feedback,$id);
        echo $stmt->execute() ? 'success' : 'error: '.$stmt->error;
        exit;
    }

    if($action == 'delete'){
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM review WHERE id=?");
        $stmt->bind_param("i",$id);
        echo $stmt->execute() ? 'success' : 'error: '.$stmt->error;
        exit;
    }
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM review WHERE id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    echo json_encode($res);
    exit;
}
?>
