<?php
session_start();
require_once "../config/database.php";

$sql = "INSERT INTO notes (contact_id, comment, created_by)
        VALUES (:contact_id, :comment, :created_by)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    'contact_id' => $_POST['contact_id'],
    'comment' => $_POST['comment'],
    'created_by' => $_SESSION['user_id']
]);

echo "note added";
