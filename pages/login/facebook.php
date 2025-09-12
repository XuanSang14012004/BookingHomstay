<?php
session_start();

// Thay các giá trị này bằng App ID, App Secret và URL callback của bạn
$app_id = 'YOUR_FACEBOOK_APP_ID';
$app_secret = 'YOUR_FACEBOOK_APP_SECRET';
$redirect_uri = 'http://localhost/Chuyende_100/Baitap/account/facebook.php';

// Bước 1: Nếu chưa có mã code, chuyển hướng sang Facebook để xác thực
if (!isset($_GET['code'])) {
	$fb_auth_url = 'https://www.facebook.com/v19.0/dialog/oauth?client_id=' . $app_id .
		'&redirect_uri=' . urlencode($redirect_uri) .
		'&scope=email,public_profile';
	header('Location: ' . $fb_auth_url);
	exit();
}

// Bước 2: Đã có mã code, lấy access token
$code = $_GET['code'];
$token_url = 'https://graph.facebook.com/v19.0/oauth/access_token?client_id=' . $app_id .
	'&redirect_uri=' . urlencode($redirect_uri) .
	'&client_secret=' . $app_secret .
	'&code=' . $code;

$response = file_get_contents($token_url);
$params = json_decode($response, true);

if (isset($params['access_token'])) {
	$access_token = $params['access_token'];
	// Lấy thông tin người dùng
	$graph_url = 'https://graph.facebook.com/me?fields=id,name,email,picture&access_token=' . $access_token;
	$user = json_decode(file_get_contents($graph_url), true);

	// Lưu thông tin vào session hoặc xử lý đăng nhập
	$_SESSION['user'] = [
		'id' => $user['id'],
		'name' => $user['name'],
		'email' => isset($user['email']) ? $user['email'] : '',
		'picture' => $user['picture']['data']['url']
	];

	// Chuyển hướng về trang chính hoặc dashboard
	header('Location: /Chuyende_100/Baitap/index.php');
	exit();
} else {
	echo 'Đăng nhập Facebook thất bại!';
}
