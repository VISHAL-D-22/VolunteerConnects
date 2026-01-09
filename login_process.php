<?php
session_start();
require 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. Fetch user by email
    $stmt = $pdo->prepare("SELECT * FROM volunteers WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // 2. VERIFY HASH (This is where the error usually is)
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['volunteer_id'] = $user['volunteer_id'];
        $_SESSION['volunteer_name'] = $user['name'];
        
        // Redirect to the dashboard
        header("Location: volunteer_dashboard.php?id=" . $user['volunteer_id']);
        exit();
    } else {
        // This triggers the alert you see
        echo "<script>alert('Invalid Email or Password'); window.location.href='home.html';</script>";
    }
}
?>