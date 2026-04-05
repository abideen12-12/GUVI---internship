<?php
header('Content-Type: application/json');
session_start();

// 1. Include config and autoloader
require_once __DIR__ . '/config.php';

try {
    // 2. Connect to MongoDB
    $client = new MongoDB\Client(MONGO_URI);
    $collection = $client->user_auth->users;

    // 3. Get Input
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "Please fill in all fields"]);
        exit;
    }

    // 4. Find user by email
    $user = $collection->findOne(['email' => $email]);

    if ($user && password_verify($password, $user['password'])) {
        // Success! Set session variables
        $_SESSION['user_id'] = (string)$user['_id'];
        $_SESSION['username'] = $user['username'];
        
        echo json_encode(["status" => "success"]);
    } else {
        // Failure: User not found or password wrong
        echo json_encode(["status" => "error", "message" => "Invalid email or password"]);
    }

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(["status" => "error", "message" => "Database error"]);
}
?>
