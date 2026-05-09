<?php
header('Content-Type: application/json');
require_once '../../functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $message = $_POST['message'] ?? '';
    $captchaToken = $_POST['g-recaptcha-response'] ?? ''; // Google auto-fills this

    // 1. Validation
    if (!$captchaToken) {
        echo json_encode(['success' => false, 'message' => 'Please verify that you are not a robot']);
        exit;
    }

    if (empty($name) || empty($email) || empty($mobile) || empty($message)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }

    // 2. Google reCAPTCHA Verification (Node.js axios.post jaisa)
    $secretKey = "6LcmQmosAAAAAAEfoWBovpRE5E9-SYu6giC3BQbF";
    $verifyUrl = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captchaToken";
    
    $response = file_get_contents($verifyUrl);
    $responseData = json_decode($response);

    if (!$responseData->success) {
        echo json_encode(['success' => false, 'message' => 'Captcha verification failed']);
        exit;
    }

    // 3. Save to Database
    if (saveContact(['name'=>$name, 'email'=>$email, 'mobile'=>$mobile, 'message'=>$message])) {
        echo json_encode(['success' => true, 'message' => 'Thank you! Your message has been sent.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
}
?>