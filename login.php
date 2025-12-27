<?php
session_start();
require "config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html");
    exit;
}

$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

if (empty($email) || empty($password)) {
    die("Email and password are required.");
}

$stmt = $pdo->prepare(
    "SELECT id, firstname, lastname, password_hash, role
     FROM users
     WHERE email = ?"
);

$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user["password_hash"])) {

    $_SESSION["user_id"] = $user["id"];
    $_SESSION["firstname"] = $user["firstname"];
    $_SESSION["lastname"] = $user["lastname"];
    $_SESSION["role"] = $user["role"];

    header("Location: dashboard.php");
    exit;

} else {
     echo "<script>
        alert('Invalid email or password. Please try again');
        window.location.href = 'index.html';
    </script>";
    exit;
}
