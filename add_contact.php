<?php
session_start();
require "config.php";

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit;
}

$title       = $_POST['title'] ?? '';
$firstname   = trim($_POST['firstname'] ?? '');
$lastname    = trim($_POST['lastname'] ?? '');
$email       = trim($_POST['email'] ?? '');
$telephone   = trim($_POST['telephone'] ?? '');
$company     = trim($_POST['company'] ?? '');
$type        = $_POST['type'] ?? '';
$assigned_to = $_POST['assigned_to'] ?: null;
$created_by  = $_SESSION['user_id'];

if (empty($firstname) || empty($lastname) || empty($email) || empty($telephone) || empty($company)) {
    echo json_encode(["success" => false, "message" => "First name and last name are required."]);
    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO contacts 
    (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$success = $stmt->execute([$title, $firstname, $lastname, $email, $telephone, $company, $type, $assigned_to, $created_by]);

if ($success) {
    echo json_encode(["success" => true, "message" => "Contact added successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to add contact"]);
}
