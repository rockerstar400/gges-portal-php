<?php
header('Content-Type: application/json');
require_once '../../functions.php';

$data = getTrustData();

if ($data) {
    echo json_encode(['success' => true, 'data' => $data]);
} else {
    echo json_encode(['success' => false, 'message' => 'No data found', 'data' => []]);
}
?>