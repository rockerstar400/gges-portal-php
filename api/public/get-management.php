<?php
header('Content-Type: application/json');
require_once '../../functions.php';

$members = getMembers();
echo json_encode(['success' => true, 'data' => $members]);