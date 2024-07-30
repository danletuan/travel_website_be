<?php
session_start();
require_once 'connect.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Kiểm tra thông tin đăng nhập
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    // Cập nhật thời gian đăng nhập gần nhất
    $stmt = $pdo->prepare("UPDATE users SET last_logged_at = NOW() WHERE id = ?");
    $stmt->execute([$user['id']]);
    // Chuyển hướng đến trang chính sau khi đăng nhập thành công
    header('Location: ../index.php');
    exit();
} else {
    // Hiển thị thông báo lỗi nếu đăng nhập không thành công
    echo '<div class="alert alert-danger" role="alert">Invalid email or password</div>';
}
