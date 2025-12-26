<?php
session_start();
require_once "../config/database.php";

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password_hash'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    echo "success";
} else {
    echo "invalid";
}
