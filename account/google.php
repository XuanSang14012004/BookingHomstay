<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Đường dẫn tới Google API Client

$client = new Google_Client();
$client->setClientId('YOUR_CLIENT_ID'); // Thay bằng Client ID của bạn
$client->setClientSecret('YOUR_CLIENT_SECRET'); // Thay bằng Client Secret của bạn
$client->setRedirectUri('http://localhost/BookingHomstay/account/google.php');
$client->addScope('email');
$client->addScope('profile');

if (!isset($_GET['code'])) {
    $authUrl = $client->createAuthUrl();
    echo '<a href="' . htmlspecialchars($authUrl) . '">Đăng nhập bằng Google</a>';
} else {
    $client->authenticate($_GET['code']);
    $token = $client->getAccessToken();
    $client->setAccessToken($token);

    $oauth2 = new Google_Service_Oauth2($client);
    $userInfo = $oauth2->userinfo->get();
    // Xử lý đăng nhập: $userInfo->id, $userInfo->name, $userInfo->email
    echo 'Xin chào, ' . $userInfo->name;
    // Tại đây bạn có thể lưu thông tin người dùng vào database và tạo session đăng nhập
}
?>