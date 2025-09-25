<?php
function createVnpayPayment($orderId, $amount) {
    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = "https://localhost/booking/return_vnpay.php"; // đổi 
    $vnp_TmnCode = "YOUR_TMNCODE"; // đổi
    $vnp_HashSecret = "YOUR_HASH_SECRET"; // đổi

    $vnp_TxnRef = $orderId;
    $vnp_OrderInfo = "Thanh toan dat phong homestay #{$orderId}";
    $vnp_OrderType = "billpayment";
    $vnp_Amount = intval(round($amount * 100)); // VNPay dùng VND*100
    $vnp_Locale = "vn";
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

    $inputData = array(
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $vnp_TxnRef
    );

    ksort($inputData);
    $hashdata = urldecode(http_build_query($inputData));
    $vnp_SecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
    $inputData['vnp_SecureHash'] = $vnp_SecureHash;

    $vnp_Url .= '?' . http_build_query($inputData);
    header('Location: ' . $vnp_Url);
    exit;
}
