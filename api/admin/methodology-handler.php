<?php
require_once __DIR__ . '/../../../functions.php';

// Handle Delete
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->prepare("DELETE FROM k12_methodology WHERE id=?")->execute([$id]);
    header("Location: ../../manage-k12.php?tab=methodology&success=deleted");
    exit;
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $image = !empty($_FILES['image']['name']) ? uploadFile($_FILES['image']) : null;

    if(!empty($id)) {
        $sql = "UPDATE k12_methodology SET title=?, description=?";
        $params = [$title, $desc];
        if($image) { $sql .= ", image=?"; $params[] = $image; }
        $sql .= " WHERE id=?"; $params[] = $id;
        $conn->prepare($sql)->execute($params);
    } else {
        $conn->prepare("INSERT INTO k12_methodology (title, description, image) VALUES (?,?,?)")->execute([$title, $desc, $image]);
    }
    header("Location: ../../manage-k12.php?tab=methodology&success=1");
}