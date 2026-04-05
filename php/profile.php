<?php
require_once 'config.php';
header('Content-Type: application/json');

try {
    $redis = new Predis\Client(REDIS_URL);
    $session_id = $_REQUEST['session_id'] ?? '';
    $user_id = $redis->get("session:$session_id");

    if (!$user_id) {
        http_response_code(401);
        echo json_encode(["status" => "unauthorized"]);
        exit;
    }

    $client = new MongoDB\Client(MONGO_URI);
    $collection = $client->selectDatabase('guvi_internship')->profiles;

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $data = $collection->findOne(["user_id" => $user_id]);
        echo json_encode($data ?: (object)[]);
    } 
    elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $collection->updateOne(
            ["user_id" => $user_id],
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
} catch (Exception $e) {
    echo json_encode(["status" => "error", "msg" => $e->getMessage()]);
}
