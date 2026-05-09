<?php
header('Content-Type: application/json');
require_once '../../functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $desc = $_POST['description'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    global $conn;
    
    // Check if data exists
    $check = $conn->query("SELECT id FROM contact_info LIMIT 1")->fetch();

    if ($check) {
        $sql = "UPDATE contact_info SET description=?, mobile=?, email=?, address=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$desc, $mobile, $email, $address, $check['id']]);
    } else {
        $sql = "INSERT INTO contact_info (description, mobile, email, address) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$desc, $mobile, $email, $address]);
    }

    if ($result) {
        header("Location: ../../admin/manage-contact.php?status=success");
    } else {
        header("Location: ../../admin/manage-contact.php?status=error");
    }
}