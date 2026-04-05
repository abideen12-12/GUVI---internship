<?php
header('Content-Type: application/json');

// 1. Connection using Railway Environment Variables
// Note: (int) is required for the PORT
$conn = new mysqli(
    $_ENV['MYSQLHOST'], 
    $_ENV['MYSQLUSER'], 
    $_ENV['MYSQLPASSWORD'], 
    $_ENV['MYSQLDATABASE'], 
    (int)$_ENV['MYSQLPORT']
);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed"]);
    exit;
}

// 2. Get Input
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);

// 3. RULE: Must use Prepared Statements
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
