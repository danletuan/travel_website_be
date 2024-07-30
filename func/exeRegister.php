<?php
require_once 'connect.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$name, $email, $password]);
    // Chuyển hướng đến trang đăng nhập sau khi đăng ký thành công
    header('Location: ../login.php');
    exit();
} catch (PDOException $e) {
    die('Registration failed: ' . $e->getMessage());
}
