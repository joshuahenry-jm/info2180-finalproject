<?php
session_start();
require_once "../config/database.php";

$sql = "INSERT INTO contacts
(title, firstname, lastname, email, telephone, company, type, assigned_to, created_by)
VALUES
(:title, :firstname, :lastname, :email, :telephone, :company, :type, :assigned_to, :created_by)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    'title' => $_POST['title'],
    'firstname' => $_POST['firstname'],
    'lastname' => $_POST['lastname'],
    'email' => $_POST['email'],
    'telephone' => $_POST['telephone'],
    'company' => $_POST['company'],
    'type' => $_POST['type'],
    'assigned_to' => $_POST['assigned_to'],
    'created_by' => $_SESSION['user_id']
]);

echo "contact created";
