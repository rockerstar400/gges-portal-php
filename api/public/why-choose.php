<?php
header('Content-Type: application/json');
require_once '../../functions.php';

// Humne pehle getAll() function banaya tha, wahi yahan kaam karega
$data = getAll('why_choose');

if ($data) {
    echo json_encode(['success' => true, 'message' => 'Fetched successfully', 'data' => $data]);
} else {
    echo json_encode(['success' => false, 'message' => 'No data found', 'data' => []]);
}
?>