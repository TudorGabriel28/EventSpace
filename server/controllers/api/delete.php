<?php

header('Content-Type: application/json');

include_once("../../config.php");
include_once("../../db_connection.php");

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON"]);
    exit;
}

$type = $data['type'];
$id = $data['id'];

try {
    $query = match($type) {
        'user' => "DELETE FROM user WHERE id = ?",
        'event' => "DELETE FROM event WHERE id = ?",
        'forum' => "DELETE FROM forumdiscussion WHERE id = ?",
        default => throw new Exception("Invalid type")
    };

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    echo json_encode(["status" => "success"]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>