<?php
function remove_bom($file_path) {
    $bom = pack('H*', 'EFBBBF');
    $content = file_get_contents($file_path);
    if (substr($content, 0, 3) === $bom) {
        $content = substr($content, 3);
        file_put_contents($file_path, $content);
        return true;
    }
    return false;
}

$file_to_fix = 'navbar.php'; // Đổi tên file cần sửa

if (file_exists($file_to_fix)) {
    if (remove_bom($file_to_fix)) {
        echo "Đã xóa thành công BOM từ file: " . $file_to_fix;
    } else {
        echo "File không chứa BOM hoặc không thể sửa: " . $file_to_fix;
    }
} else {
    echo "Không tìm thấy file: " . $file_to_fix;
}
?>