<?php
header('Content-Type: application/json');
require_once '../../functions.php';

$data = getAbout();
if ($data) {
    // JSON strings ko wapas PHP arrays mein badlein taaki frontend ko array mile
    $data['description'] = json_decode($data['description']);
    $data['whyUsDescription'] = json_decode($data['why_us']);
    $data['howDiffrentDescription'] = json_decode($data['how_different']);
    $data['safetyDescription'] = json_decode($data['safety']);
    
    echo json_encode(['success' => true, 'data' => $data]);
} else {
    echo json_encode(['success' => false, 'message' => 'No content found']);
}