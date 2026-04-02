<?php
require __DIR__ . '/../vendor/autoload.php';

use Predis\Client;

header('Content-Type: application/json');

// 🔴 Redis connection
$redis = new Client();

// 🔴 Get session_id
$session_id = $_GET['session_id'] ?? $_POST['session_id'] ?? '';

// 🔴 Validate session
$user_id = $redis->get($session_id);

if (!$user_id) {
    echo json_encode(["status" => "unauthorized"]);
    exit;
}

// 🔴 MongoDB
$client = new MongoDB\Client("mongodb://127.0.0.1:27017");
$collection = $client->user_profiles->profiles;

// 🔹 GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $data = $collection->findOne(["user_id" => (int)$user_id]);

    echo json_encode($data ?: []);
}

// 🔹 POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $collection->updateOne(
        ["user_id" => (int)$user_id],
        ['$set' => [
            "name" => $_POST['name'],
            "age" => $_POST['age'],
            "dob" => $_POST['dob'],
            "contact" => $_POST['contact']
        ]],
        ["upsert" => true]
    );

    echo json_encode(["status" => "success"]);
}
?>