<?php
header('Content-Type: application/json');

// 1. Get variables (with fallbacks to avoid the 'Undefined' warning)
$host = $_ENV['MYSQLHOST'] ?? '';
$user = $_ENV['MYSQLUSER'] ?? '';
$pass = $_ENV['MYSQLPASSWORD'] ?? '';
$db   = $_ENV['MYSQLDATABASE'] ?? '';
$port = (int)($_ENV['MYSQLPORT'] ?? 3306);

// 2. Connect
$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed"]);
    exit;
}

// 3. RULE: Use Prepared Statements for Register
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $password);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
