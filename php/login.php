<?php
require_once 'config.php';
header('Content-Type: application/json');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, (int)DB_PORT);

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// RULE: Prepared Statements
$stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    $token = bin2hex(random_bytes(16));
    
    // Connect to Redis using Predis (as per your composer.json)
    try {
        $redis = new Predis\Client(REDIS_URL);
        $redis->setex("session:$token", 3600, $user['id']);
        
        echo json_encode([
            "status" => "success", 
            "session_id" => $token, // Match JS expectation
            "user_id" => $user['id']
        ]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "msg" => "Redis Connection Failed"]);
    }
} else {
    echo json_encode(["status" => "error", "msg" => "Invalid email or password"]);
}
