<?php
function createMomoPayment($bookingId, $amount) {
    $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
    $partnerCode = "MOMO"; 
    $accessKey = "F8BBA842ECF85";     
    $secretKey = "K951B6PE1waDMi640xX08PD3vg6EkVlz";     

    // orderId phải duy nhất
    $orderId = "BOOK{$bookingId}_" . time();
    $orderInfo = "Thanh toán đặt phòng homestay #{$bookingId}";

    // $redirectUrl = "http://localhost/BookingHomstay/PLACE/history.php"; 
    // $ipnUrl      = "http://localhost/booking/notify_momo.php"; 
      $redirectUrl = "http://localhost/BS_UPDATE/BS/FE/PAY/return_momo.php";
      $ipnUrl      = "http://localhost/BS/FE/PAY/notify_momo.php";


    $requestId   = time() . "";
    $requestType = "payWithATM";

    // gửi thêm booking_id trong extraData để khi callback xử lý
    $extraData = base64_encode(json_encode([
        "booking_id" => $bookingId
    ]));

    $amountStr = strval(intval(round($amount)));

    $rawHash = "accessKey={$accessKey}&amount={$amountStr}&extraData={$extraData}&ipnUrl={$ipnUrl}&orderId={$orderId}&orderInfo={$orderInfo}&partnerCode={$partnerCode}&redirectUrl={$redirectUrl}&requestId={$requestId}&requestType={$requestType}";
    $signature = hash_hmac("sha256", $rawHash, $secretKey);

    $data = array(
        'partnerCode' => $partnerCode,
        'partnerName' => "BookingHomeStay",
        'storeId'     => "BookingStore",
        'requestId'   => $requestId,
        'amount'      => $amountStr,
        'orderId'     => $orderId,
        'orderInfo'   => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl'      => $ipnUrl,
        'lang'        => 'vi',
        'extraData'   => $extraData,
        'requestType' => $requestType,
        'signature'   => $signature
    );

    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $result = curl_exec($ch);
    curl_close($ch);

    $jsonResult = json_decode($result, true);
    if (!empty($jsonResult['payUrl'])) {
        header('Location: ' . $jsonResult['payUrl']);
        exit;
    } else {
        echo "Lỗi tạo payment MoMo: ";
        var_dump($jsonResult);
        exit;
    }
}
