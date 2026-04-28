<?php
header('Content-Type: application/json');
require_once '../../functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slug = $_POST['category_slug'];
    $title = $_POST['title'];
    $content = $_POST['content']; // Yeh poora array hoga (Chapters, Descriptions, etc.)

    $jsonContent = json_encode($content);

    global $conn;
    $stmt = $conn->prepare("INSERT INTO course_sections (category_slug, title, content_json) 
                            VALUES (?, ?, ?) 
                            ON DUPLICATE KEY UPDATE title = VALUES(title), content_json = VALUES(content_json)");
    
    if ($stmt->execute([$slug, $title, $jsonContent])) {
        header("Location: ../../admin/manage-course.php?type=$slug&status=success");
    } else {
        header("Location: ../../admin/manage-course.php?type=$slug&status=error");
    }
}

