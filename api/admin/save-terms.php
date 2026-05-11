<?php
require_once __DIR__ . '/../../../functions.php';

// 1. DELETE
if(isset($_GET['delete'])) {
    $conn->prepare("DELETE FROM terms_services WHERE id=?")->execute([$_GET['delete']]);
    header("Location: ../../manage-terms.php?success=deleted");
    exit;
}

// 2. ADD / UPDATE
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? '';
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    $points = [];
    if(isset($_POST['point_subtitle'])) {
        foreach($_POST['point_subtitle'] as $k => $sub) {
            if(!empty($_POST['point_desc'][$k])) {
                $points[] = [
                    'subtitle' => $sub,
                    'desc' => $_POST['point_desc'][$k]
                ];
            }
        }
    }
    $points_json = json_encode($points);

    try {
        if(!empty($id)) {
            $stmt = $conn->prepare("UPDATE terms_services SET title=?, description=?, points_json=? WHERE id=?");
            $stmt->execute([$title, $description, $points_json, $id]);
        } else {
            $stmt = $conn->prepare("INSERT INTO terms_services (title, description, points_json) VALUES (?,?,?)");
            $stmt->execute([$title, $description, $points_json]);
        }
        header("Location: ../../manage-terms.php?success=1");
    } catch(PDOException $e) { die($e->getMessage()); }
}