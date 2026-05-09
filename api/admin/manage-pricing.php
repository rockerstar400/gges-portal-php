<?php
header('Content-Type: application/json');
require_once '../../functions.php';

$action = $_GET['action'] ?? '';

// --- ADD PRICING ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add') {
    $labels = $_POST['fee_labels'] ?? [];
    $prices = $_POST['fee_prices'] ?? [];
    
    $feesArray = [];
    for($i=0; $i < count($labels); $i++) {
        if(!empty($labels[$i])) {
            $feesArray[] = [
                'label' => $labels[$i], 
                'price' => $prices[$i]
            ];
        }
    }

    $data = [
        'planName'    => $_POST['planName'] ?? '',
        'className'   => $_POST['className'] ?? '',
        'feesPerHour' => $_POST['feesPerHour'] ?? '',
        'off'         => $_POST['off'] ?? '',
        'fees'        => $feesArray
    ];

    if (addPricing($data, $_FILES['image'])) {
        header("Location: ../../admin/manage-pricing.php?status=success");
    } else {
        header("Location: ../../admin/manage-pricing.php?status=error");
    }
    exit();
}

// --- DELETE PRICING (Line 44 Fix) ---
if ($action === 'delete') {
    $id = $_GET['id'] ?? null;
    if ($id) {
        global $conn;
        // 1. Pehle image path nikalein taaki folder se delete kar sakein
        $stmt = $conn->prepare("SELECT image FROM pricing WHERE id = ?");
        $stmt->execute([$id]);
        $p = $stmt->fetch();

        if ($p && !empty($p['image'])) {
            $fullPath = "../../" . $p['image'];
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }

        // 2. Database se record delete karein
        $delStmt = $conn->prepare("DELETE FROM pricing WHERE id = ?");
        $delStmt->execute([$id]);

        header("Location: ../../admin/manage-pricing.php?status=deleted");
    } else {
        header("Location: ../../admin/manage-pricing.php?status=error");
    }
    exit();
}