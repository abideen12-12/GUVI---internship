<?php
header('Content-Type: application/json');

// 1. Include your config and autoloader
require_once __DIR__ . '/config.php';

try {
    // 2. Connect using the MONGO_URI from your config.php
    $client = new MongoDB\Client(MONGO_URI);
    
    // 3. Select your database and collection (Change 'user_auth' if needed)
    $collection = $client->user_auth->users;

    // 4. Get and Sanitize Input
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $plain_password = $_POST['password'] ?? '';

    if (empty($username) || empty($email) || empty($plain_password)) {
        echo json_encode(["status" => "error", "message" => "Missing fields"]);
        exit;
    }

    $password_hash = password_hash($plain_password, PASSWORD_DEFAULT);

    // 5. Insert into MongoDB
    $result = $collection->insertOne([
        "username" => $username,
        "email" => $email,
        "password" => $password_hash,
        "created_at" => new MongoDB\BSON\UTCDateTime()
    ]);

    if ($result->getInsertedCount() === 1) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Insert failed"]);
    }

} catch (Exception $e) {
    // Log the actual error for debugging in Railway logs
    error_log($e->getMessage());
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
}
?>
