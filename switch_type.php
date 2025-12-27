<?php
session_start();
require "config.php";

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["success" => false]);
    exit;
}

$contact_id = $_POST["contact_id"] ?? null;

if (!$contact_id) {
    echo json_encode(["success" => false]);
    exit;
}

$stmt = $pdo->prepare("SELECT type FROM contacts WHERE id = ?");
$stmt->execute([$contact_id]);
$current = $stmt->fetchColumn();

if (!$current) {
    echo json_encode(["success" => false]);
    exit;
}

$newType = $current === "Support" ? "Sales Lead" : "Support";

$update = $pdo->prepare("
    UPDATE contacts
    SET type = ?
    WHERE id = ?
");
$update->execute([$newType, $contact_id]);

echo json_encode([
    "success" => true,
    "newType" => $newType
]);
