<?php
require_once __DIR__ . '/../../../functions.php';

if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->prepare("DELETE FROM science_details WHERE id=?")->execute([$id]);
    header("Location: ../../manage-math-science.php?success=deleted");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $heading = $_POST['heading'];
    $description = $_POST['description'];
    $image = !empty($_FILES['image']['name']) ? uploadFile($_FILES['image']) : null;

    if(!empty($id)) {
        $sql = "UPDATE science_details SET title=?, heading=?, description=?";
        $params = [$title, $heading, $description];
        if($image) { $sql .= ", image=?"; $params[] = $image; }
        $sql .= " WHERE id=?"; $params[] = $id;
        $conn->prepare($sql)->execute($params);
    } else {
        $conn->prepare("INSERT INTO science_details (title, heading, description, image) VALUES (?,?,?,?)")->execute([$title, $heading, $description, $image]);
    }
    header("Location: ../../manage-math-science.php?success=1");
}