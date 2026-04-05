<?php
header('Content-Type: application/json');
// 1. MySQL for auth
$conn = new mysqli($_ENV['MYSQLHOST'], $_ENV['MYSQLUSER'], $_ENV['MYSQLPASSWORD'], $_ENV['MYSQLDATABASE'], $_ENV['MYSQLPORT']);

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    // 2. Redis for session (Generating a simple token)
    $token = bin2hex(random_bytes(16));
    $redis = new Redis();
    $redis->connect($_ENV['REDISHOST'], $_ENV['REDISPORT']);
    $redis->auth($_ENV['REDISPASSWORD']);
    $redis->setex("session:$token", 3600, $user['id']); // Store for 1 hour

    // 3. Return token for localStorage
    echo json_encode(["status" => "success", "token" => $token]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid credentials"]);
}
?>
