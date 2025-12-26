<?php
require_once "../config/database.php";

$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO users (firstname, lastname, email, password_hash, role)
        VALUES (:firstname, :lastname, :email, :password_hash, :role)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    'firstname' => $_POST['firstname'],
    'lastname' => $_POST['lastname'],
    'email' => $_POST['email'],
    'password_hash' => $hash,
    'role' => $_POST['role']
]);

echo "user created";
