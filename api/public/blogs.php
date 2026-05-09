<?php
header('Content-Type: application/json');
require_once '../../functions.php';

$id = $_GET['id'] ?? null;

if ($id) {
    // Blog Details API
    $blog = getBlogById($id);
    if ($blog) {
        echo json_encode(['success' => true, 'data' => $blog]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Blog not found']);
    }
} else {
    // Blog List API
    $blogs = getBlogs();
    echo json_encode(['success' => true, 'data' => $blogs]);
}
?>