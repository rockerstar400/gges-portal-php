<?php
header('Content-Type: application/json');
require_once '../../functions.php';

$bannerData = getBanner();

if ($bannerData) {
    echo json_encode(['success' => true, 'data' => $bannerData]);
} else {
    echo json_encode(['success' => false, 'message' => 'No banner found']);
}
?>