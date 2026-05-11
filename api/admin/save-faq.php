<?php
require_once __DIR__ . '/../../../functions.php';

// 1. DELETE LOGIC
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        $stmt = $conn->prepare("DELETE FROM faqs WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: ../../manage-faq.php?success=deleted");
    } catch(PDOException $e) { die($e->getMessage()); }
    exit;
}

// 2. SAVE / UPDATE LOGIC
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? '';
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    
    // Filter points to remove empty ones
    $points = array_values(array_filter($_POST['points'] ?? []));
    $points_json = json_encode($points);

    try {
        if(!empty($id)) {
            // EDIT CASE
            $sql = "UPDATE faqs SET title=?, description=?, points_json=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$title, $description, $points_json, $id]);
        } else {
            // ADD CASE
            $sql = "INSERT INTO faqs (title, description, points_json) VALUES (?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$title, $description, $points_json]);
        }
        
        header("Location: ../../manage-faq.php?success=1");
        exit();

    } catch(PDOException $e) { 
        die("Database Error: " . $e->getMessage()); 
    }
}