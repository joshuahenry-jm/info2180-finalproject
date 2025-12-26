<?php
require_once "../config/database.php";

$sql = "SELECT notes.*, users.firstname
        FROM notes
        JOIN users ON notes.created_by = users.id
        WHERE contact_id = :contact_id
        ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute(['contact_id' => $_GET['contact_id']]);

