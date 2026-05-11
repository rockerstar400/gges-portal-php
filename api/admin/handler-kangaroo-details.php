<?php
require_once __DIR__ . '/../../../functions.php';

if(isset($_GET['delete'])) {
    $conn->prepare("DELETE FROM kangaroo_details WHERE id=?")->execute([$_GET['delete']]);
    header("Location: ../../manage-math-kangaroo.php?success=deleted");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = json_encode(array_values(array_filter($_POST['description'] ?? [])));
    $image = !empty($_FILES['image']['name']) ? uploadFile($_FILES['image']) : null;

    if(!empty($id)) {
        $sql = "UPDATE kangaroo_details SET title=?, description=?";
        $params = [$title, $description];
        if($image) { $sql .= ", image=?"; $params[] = $image; }
        $sql .= " WHERE id=?"; $params[] = $id;
        $conn->prepare($sql)->execute($params);
    } else {
        $conn->prepare("INSERT INTO kangaroo_details (title, description, image) VALUES (?,?,?)")->execute([$title, $description, $image]);
    }
    header("Location: ../../manage-math-kangaroo.php?success=1");
}