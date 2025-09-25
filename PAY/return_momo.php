<!-- <?php
include '../db.php';

$orderId = intval($_GET['orderId'] ?? 0);
$resultCode = $_GET['resultCode'] ?? '';
$amount = $_GET['amount'] ?? '';

if ($resultCode === '0' && $orderId > 0) {
    $sql = "UPDATE bookings SET status='paid' WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();

   
    echo "❌ Thanh toán MoMo thất bại. Mã trả về: $resultCode";
} else {
    
    echo "✅ Thanh toán MoMo thành công! Đơn hàng #$orderId, Số tiền: " . number_format(intval($amount),0,",",".") . "đ";
    
} 
