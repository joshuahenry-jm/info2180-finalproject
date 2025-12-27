<?php
session_start();
require "config.php";

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["success" => false]);
    exit;
}

$comment = trim($_POST["comment"] ?? "");
$contact_id = $_POST["contact_id"] ?? null;
$user_id = $_SESSION["user_id"];

if ($comment === "" || !$contact_id) {
    echo json_encode(["success" => false]);
    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO notes (contact_id, comment, created_by)
    VALUES (?, ?, ?)
");
$stmt->execute([$contact_id, $comment, $user_id]);

echo json_encode([
    "success" => true,
    "comment" => htmlspecialchars($comment),
    "author" => $_SESSION["firstname"] . " " . $_SESSION["lastname"],
    "date" => date("F j, Y \\a\\t g:i a")
]);
