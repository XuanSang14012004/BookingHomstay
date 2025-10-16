<?php
// Tên file: return_vnpay.php

$vnp_HashSecret = "LIFBZT07479IMO10IC7154LO3GOOQGYZ"; 
$vnp_SecureHash = $_GET['vnp_SecureHash'];

// --- 1. TẠO CHUỖI HASH ĐỂ XÁC MINH ---
$inputData = array();
foreach ($_GET as $key => $value) {
    if (substr($key, 0, 4) == "vnp_") {
        $inputData[$key] = $value;
    }
}
unset($inputData['vnp_SecureHash']);

ksort($inputData);
$hashData = "";
$i = 0;
foreach ($inputData as $key => $value) {
    if ($i > 0) {
        $hashData .= '&';
    }
    // Vẫn dùng urlencode() cho giá trị để khớp với quá trình tạo chữ ký
    $hashData .= $key . "=" . urlencode($value);
    $i++;
}
$secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

// --- 2. XÁC MINH VÀ CHUYỂN HƯỚNG ---

$vnp_TxnRef = $_GET['vnp_TxnRef']; // Mã đơn hàng của bạn
$vnp_ResponseCode = $_GET['vnp_ResponseCode']; // Mã phản hồi VNPAY

$redirect_url = "../PLACE/history.php?"; // Khởi tạo URL chuyển hướng

if ($secureHash == $vnp_SecureHash) {
    // KÝ TỰ HỢP LỆ
    
    // **Ghi chú quan trọng:** Tại đây bạn cần CẬP NHẬT DATABASE
    // Dựa vào $vnp_TxnRef (mã đơn hàng) và $vnp_ResponseCode (mã phản hồi)
    
    if ($vnp_ResponseCode == '00') {
        // Giao dịch thành công: Cập nhật trạng thái đơn hàng = SUCCESS
        $redirect_url .= "status=success&orderId=" . $vnp_TxnRef;
    } else {
        // Giao dịch thất bại: Cập nhật trạng thái đơn hàng = FAILED
        $redirect_url .= "status=failed&orderId=" . $vnp_TxnRef . "&code=" . $vnp_ResponseCode;
    }
    
} else {
    // SAI CHỮ KÝ (Lỗi 70)
    // Bạn có thể không cập nhật database, hoặc cập nhật trạng thái = FRAUD/INVALID_SIGNATURE
    $redirect_url .= "status=invalid_signature&orderId=" . $vnp_TxnRef;
}

// Chuyển hướng người dùng sang trang history.php để hiển thị kết quả
header("Location: " . $redirect_url);
exit();

?>