<?php
$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'db_bookinghomestay';

$map = [
    'account'   => 'db_account',
    'user'      => 'db_customer',
    'admin'     => 'db_admin',
    'owner'     => 'db_owner',
    'homestay'  => 'db_homestay',
    'booking'   => 'db_booking',
    'payment'   => 'db_booking',
    'reviews'   => 'db_review',
];

$page = isset($_GET['page']) ? trim($_GET['page']) : '';

if ($page === '' || !array_key_exists($page, $map)) {
    http_response_code(400);
    header('Content-Type: text/plain; charset=utf-8');
    echo "Invalid or missing page parameter.";
    exit;
}

$table = $map[$page];

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo "DB connection failed: " . $mysqli->connect_error;
    exit;
}
$mysqli->set_charset('utf8mb4');

$sql = "SELECT * FROM `{$table}`";
if (!$result = $mysqli->query($sql)) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo "Query failed: " . $mysqli->error;
    exit;
}

$now = date('Ymd_His');
$filename = "{$page}_{$now}.csv";

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="'.$filename.'"');
header('Pragma: no-cache');
header('Expires: 0');

echo "\xEF\xBB\xBF";

$out = fopen('php://output', 'w');
if ($out === false) {
    http_response_code(500);
    exit;
}

$fields = $result->fetch_fields();
$header = [];
foreach ($fields as $f) {
    $header[] = $f->name;
}
fputcsv($out, $header);

while ($row = $result->fetch_assoc()) {
    $line = [];
    foreach ($header as $col) {
        $val = isset($row[$col]) ? $row[$col] : '';
        if (is_array($val) || is_object($val)) $val = json_encode($val, JSON_UNESCAPED_UNICODE);
        $line[] = $val;
    }
    fputcsv($out, $line);
}

fclose($out);
$result->free();
$mysqli->close();
exit;