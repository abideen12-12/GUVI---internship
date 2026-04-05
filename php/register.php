<?php
header('Content-Type: application/json');

// 1. Connection using Railway Environment Variables
$conn = new mysqli(
    $_ENV['MYSQLHOST'], 
    $_ENV['MYSQLUSER'], 
    $_ENV['MYSQLPASSWORD'], 
    $_ENV['MYSQLDATABASE'], 
    (int)$_ENV['MYSQLPORT']
);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "DB Connection Failed"]);
    exit;
}

// 2. Get Input from AJAX
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$plain_password = $_POST['password'] ?? '';

if (empty($username) || empty($email) || empty($plain_password)) {
    echo json_encode(["status" => "error", "message" => "Fields cannot be empty"]);
    exit;
}

$password_hash = password_hash($plain_password, PASSWORD_DEFAULT);

// 3. RULE: Must use Prepared Statements
$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $password_hash);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
