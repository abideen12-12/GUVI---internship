<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

require __DIR__ . '/../vendor/autoload.php';

use Predis\Client;

// 🔹 MySQL connection
$conn = new mysqli("localhost", "root", "", "user_auth");

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "msg" => "DB connection failed"]);
    exit;
}

// 🔹 Get POST data safely
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    echo json_encode(["status" => "error", "msg" => "Missing email or password"]);
    exit;
}

// 🔹 Prepared statement
$stmt = $conn->prepare("SELECT id, password FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {

    if (password_verify($password, $row['password'])) {

        $redis = new Client([
            'scheme' => 'tcp',
            'host'   => '127.0.0.1',
            'port'   => 6379,
        ]);

        //Generate session ID
        $session_id = bin2hex(random_bytes(16));

        $redis->set($session_id, $row['id']);

        //Expiry in 1hour
        $redis->expire($session_id, 3600);

        echo json_encode([
            "status" => "success",
            "user_id" => $row['id'],
            "session_id" => $session_id
        ]);

    } else {
        echo json_encode(["status" => "error", "msg" => "Wrong password"]);
    }

} else {
    echo json_encode(["status" => "error", "msg" => "User not found"]);
}
?>