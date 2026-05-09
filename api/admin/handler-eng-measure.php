<?php
require_once __DIR__ . '/../../../functions.php';

// DELETE
if(isset($_GET['delete'])) {
    $conn->prepare("DELETE FROM eng_measure_details WHERE id=?")->execute([$_GET['delete']]);
    header("Location: ../../manage-eng-reg.php?success=deleted");
    exit;
}

// ADD/EDIT
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $desc = $_POST['description'];

    if(!empty($id)) {
        $stmt = $conn->prepare("UPDATE eng_measure_details SET title=?, description=? WHERE id=?");
        $stmt->execute([$title, $desc, $id]);
    } else {
        $stmt = $conn->prepare("INSERT INTO eng_measure_details (title, description) VALUES (?,?)");
        $stmt->execute([$title, $desc]);
    }
    header("Location: ../../manage-eng-reg.php?success=1");
}