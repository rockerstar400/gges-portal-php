<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
header('Content-Type: application/json');

/**
 * SMART PATH LOGIC for login.php
 * Server: 2 level up | Local: 3 level up
 */
if (file_exists(dirname(__DIR__, 2) . '/functions.php')) {
    require_once dirname(__DIR__, 2) . '/functions.php';
} else {
    require_once dirname(__DIR__, 3) . '/functions.php';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Please fill all fields']);
        exit;
    }

    try {
        global $conn;
        if (!isset($conn)) { echo json_encode(['success' => false, 'message' => 'DB Connection Fail']); exit; }

        $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_user'] = $admin['username'];
            echo json_encode(['success' => true, 'message' => 'Welcome back']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
}
?>