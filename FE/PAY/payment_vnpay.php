<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

function createVnpayPayment($orderId, $total_price) {
    // ... (Giữ nguyên các khai báo hằng số và biến) ...
    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = "http://localhost/BS/FE/PAY/return_vnpay.php";
    $vnp_TmnCode = "NW9ORH4U";
    $vnp_HashSecret = "LIFBZT07479IMO10IC7154LO3GOOQGYZ"; // Đảm bảo Hash Secret này là CHÍNH XÁC

    // ... (Giữ nguyên phần khởi tạo $inputData) ...
    $vnp_TxnRef = $orderId;
    $vnp_OrderInfo = "Thanh toán booking #$orderId";
    $vnp_OrderType = "other";
    $vnp_Amount = $total_price * 100;
    $vnp_Locale = "vn";
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

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
    
    $hashdata = "";
    $query = "";
    $i = 0;
    
    foreach ($inputData as $key => $value) {
        if ($i > 0) {
            $hashdata .= '&';
            $query .= '&';
        }
        
        // Sửa lỗi: Mã hóa URL giá trị cho $hashdata
        // Chuỗi hashdata cần phải nối các tham số đã URL Encode (giá trị)
        $hashdata .= $key . "=" . urlencode($value); 
        
        // Chuỗi query để gửi đi cũng cần mã hóa URL key và value
        $query .= urlencode($key) . "=" . urlencode($value);
        $i++;
    }

    $secureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
    $vnp_Url = $vnp_Url . "?" . $query . '&vnp_SecureHash=' . urlencode($secureHash); // urlencode SecureHash

    header("Location: $vnp_Url");
    exit();
}