<?php
// 1. Session start sirf ek baar top par
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Response type JSON
header('Content-Type: application/json');

// 3. SMART PATH LOGIC (Universal Fix)
// Live server par path: api/auth/login.php (2 level up)
// Local Windows par path: admin/api/auth/login.php (3 level up)
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
        global $conn; // Yeh connection 'functions.php' ke 'db.php' se aayega

        // Check karein connection available hai ya nahi
        if (!isset($conn)) {
            echo json_encode(['success' => false, 'message' => 'Database connection failed inside API']);
            exit;
        }

        $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            // LOGIN SUCCESS
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_user'] = $admin['username'];

            echo json_encode([
                'success' => true, 
                'message' => 'Welcome back, ' . $admin['username']
            ]);
        } else {
            // LOGIN FAILED
            echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
        }

    } catch (PDOException $e) {
        // Live par error message thoda simple rakhein
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>