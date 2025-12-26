<?php
require_once "../config/database.php";

$sql = "SELECT contacts.*, users.firstname AS assigned_name
        FROM contacts
        LEFT JOIN users ON contacts.assigned_to = users.id";

$stmt = $pdo->query($sql);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
