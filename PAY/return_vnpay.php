<?php
include '../db.php';
$vnp_HashSecret = "YOUR_HASH_SECRET"; // đổi

$inputData = $_GET;
$vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
unset($inputData['vnp_SecureHash'], $inputData['vnp_SecureHashType']);
ksort($inputData);
$hashData = urldecode(http_build_query($inputData));
$secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

if ($secureHash === $vnp_SecureHash) {
    $orderId = intval($inputData['vnp_TxnRef'] ?? 0);
    $responseCode = $inputData['vnp_ResponseCode'] ?? '';
    if ($responseCode === '00' && $orderId > 0) {
        $sql = "UPDATE bookings SET status='paid' WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        echo "✅ Thanh toán VNPay thành công! Mã đặt: #$orderId";
    } else {
        echo "❌ Thanh toán VNPay thất bại. Mã trả về: $responseCode";
    }
} else {
    echo "❌ Chữ ký không hợp lệ (VNPay).";
}
