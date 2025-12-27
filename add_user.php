<?php
session_start();
require "config.php";

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "Admin") {
    echo json_encode(["success" => false, "message" => "Not authorized"]);
    exit;
}

$firstname = trim($_POST['firstname'] ?? '');
$lastname  = trim($_POST['lastname'] ?? '');
$email     = trim($_POST['email'] ?? '');
$password  = $_POST['password'] ?? '';
$role      = $_POST['type'] ?? 'Member';

if (!$firstname || !$lastname || !$email || !$password) {
    echo json_encode(["success" => false, "message" => "All fields are required"]);
    exit;
}


$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    echo json_encode(["success" => false, "message" => "Email already exists"]);
    exit;
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("
    INSERT INTO users (firstname, lastname, email, password_hash, role)
    VALUES (?, ?, ?, ?, ?)
");
$stmt->execute([$firstname, $lastname, $email, $password_hash, $role]);

echo json_encode(["success" => true, "message" => "User added successfully"]);
exit;
