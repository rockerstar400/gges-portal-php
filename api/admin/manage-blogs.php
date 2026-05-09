<?php
header('Content-Type: application/json');
require_once '../../functions.php';

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add') {
    $title = $_POST['title'];
    $description = $_POST['description']; // CKEditor content
    $type = $_POST['type']; // 'image' or 'video'
    
    // YAHAN FIX HAI: 'image' ki jagah 'media_file' use kiya hai matching HTML
    $file = $_FILES['media_file'] ?? null;

    if (empty($title) || empty($description)) {
        header("Location: ../../admin/manage-blogs.php?status=error&message=required_fields");
        exit;
    }

    // Helper function se file upload karein
    $filePath = uploadFile($file);
    
    if ($filePath) {
        global $conn;
        
        // Logic: Agar type image hai toh image column mein path daalo, varna video mein
        $imagePath = ($type === 'image') ? $filePath : null;
        $videoPath = ($type === 'video') ? $filePath : null;

        try {
            $sql = "INSERT INTO blogs (title, description, type, image, video) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute([$title, $description, $type, $imagePath, $videoPath])) {
                header("Location: ../../admin/manage-blogs.php?status=success");
            } else {
                header("Location: ../../admin/manage-blogs.php?status=error");
            }
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
        }
    } else {
        header("Location: ../../admin/manage-blogs.php?status=error&message=upload_failed");
    }
}

// Delete Blog logic
if ($action === 'delete') {
    $id = $_GET['id'];
    global $conn;
    
    // Pehle database se file paths nikalo taaki folder se delete kar sakein
    $stmt = $conn->prepare("SELECT image, video FROM blogs WHERE id = ?");
    $stmt->execute([$id]);
    $blog = $stmt->fetch();
    
    if($blog) {
        if(!empty($blog['image']) && file_exists("../../".$blog['image'])) unlink("../../".$blog['image']);
        if(!empty($blog['video']) && file_exists("../../".$blog['video'])) unlink("../../".$blog['video']);
    }

    $stmt = $conn->prepare("DELETE FROM blogs WHERE id = ?");
    if($stmt->execute([$id])) {
        header("Location: ../../admin/manage-blogs.php?status=deleted");
    }
}
?>