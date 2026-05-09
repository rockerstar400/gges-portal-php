<?php
session_start();
// Agar admin pehle se logged in hai, toh seedha dashboard par bhejo
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GGES | Admin Login</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #0e1d3e 0%, #305CDE 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            padding: 40px;
        }
        .login-logo {
            width: 80px;
            margin-bottom: 20px;
        }
        .form-control {
            height: 50px;
            border-radius: 10px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding-left: 45px;
        }
        .input-group-text {
            background: transparent;
            border: none;
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            color: #94a3b8;
        }
        .input-group {
            position: relative;
        }
        .btn-login {
            height: 50px;
            border-radius: 10px;
            background: #305CDE;
            border: none;
            font-weight: 600;
            font-size: 16px;
            transition: 0.3s;
        }
        .btn-login:hover {
            background: #1e40af;
            transform: translateY(-2px);
        }
        .error-msg {
            color: #ef4444;
            font-size: 14px;
            text-align: center;
            margin-bottom: 15px;
            display: none;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="text-center">
        <!-- Logo (Aap apna logo path change kar sakte hain) -->
        <img src="assets/images/logo.png" alt="Logo" class="login-logo" onerror="this.src='https://via.placeholder.com/80'">
        <h4 class="fw-bold text-dark mb-1">Admin Portal</h4>
        <p class="text-muted mb-4 small">Please login to manage your website</p>
    </div>

    <!-- Error Message Area -->
    <div id="errorMessage" class="error-msg">Invalid username or password!</div>

    <form id="loginForm">
        <!-- Username -->
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
        </div>

        <!-- Password -->
        <div class="mb-4">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary btn-login w-100">
            Sign In <i class="fas fa-sign-in-alt ms-2"></i>
        </button>
    </form>

    <div class="mt-4 text-center">
        <a href="../index.php" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Back to Website
        </a>
    </div>
</div>

<!-- JS for AJAX Login (Node.js jaisa experience) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: 'api/auth/login.php', // Hamari Login API
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if(response.success) {
                        window.location.href = 'dashboard.php';
                    } else {
                        $('#errorMessage').text(response.message).fadeIn();
                    }
                }
            });
        });
    });
</script>

</body>
</html>
