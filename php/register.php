<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "user_auth");

$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

//HASH PASSWORD
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $hashedPassword);

$stmt->execute();

echo json_encode(["status" => "success"]);
?>