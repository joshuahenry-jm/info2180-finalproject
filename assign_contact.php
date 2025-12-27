<?php
session_start();
require "config.php";

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["success" => false]);
    exit;
}

$contact_id = $_POST["contact_id"] ?? null;
$user_id = $_SESSION["user_id"];

if (!$contact_id) {
    echo json_encode(["success" => false]);
    exit;
}

$stmt = $pdo->prepare("
    UPDATE contacts
    SET assigned_to = ?
    WHERE id = ?
");
$stmt->execute([$user_id, $contact_id]);

$userStmt = $pdo->prepare("
    SELECT firstname, lastname
    FROM users
    WHERE id = ?
");
$userStmt->execute([$user_id]);
$user = $userStmt->fetch();

echo json_encode([
    "success" => true,
    "name" => $user["firstname"] . " " . $user["lastname"]
]);
