<?php
$status = $_GET['status'] ?? '';
$orderId = $_GET['orderId'] ?? '';
$amount = $_GET['amount'] ?? '';
$txn = $_GET['txn'] ?? '';
$code = $_GET['code'] ?? '';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kết quả thanh toán VNPay</title>
</head>
<body>
    <h1>Kết quả thanh toán VNPay</h1>

    <?php if ($status === 'success'): ?>
        <p>✅ Thanh toán thành công!</p>
        <p>🧾 Mã đơn: #<?= htmlspecialchars($orderId) ?></p>
        <p>💰 Số tiền: <?= number_format($amount,0,',','.') ?> VND</p>
        <p>🔢 Mã giao dịch VNPay: <?= htmlspecialchars($txn) ?></p>
    <?php elseif ($status === 'failed'): ?>
        <p>❌ Thanh toán thất bại!</p>
        <p>Mã lỗi: <?= htmlspecialchars($code) ?></p>
        <p>Mã đơn: #<?= htmlspecialchars($orderId) ?></p>
    <?php else: ?>
        <p>❗ Chưa có giao dịch nào.</p>
    <?php endif; ?>
</body>
</html>
