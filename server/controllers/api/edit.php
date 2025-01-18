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
$updateData = $data['data'];

try {
    $query = match($type) {
        'user' => "UPDATE user SET firstName = ?, lastName = ?, email = ? WHERE id = ?",
        'event' => "UPDATE event SET name = ?, description = ? WHERE id = ?",
        'forum' => "UPDATE forumdiscussion SET title = ?, question = ? WHERE id = ?",
        default => throw new Exception("Invalid type")
    };

    $stmt = $conn->prepare($query);
    
    if ($type === 'user') {
        $stmt->bind_param("sssi", $updateData['firstName'], $updateData['lastName'], $updateData['email'], $id);
    } elseif ($type === 'event') {
        $stmt->bind_param("ssi", $updateData['name'], $updateData['description'], $id);
    } else {
        $stmt->bind_param("ssi", $updateData['title'], $updateData['question'], $id);
    }
    
    $stmt->execute();
    echo json_encode(["status" => "success"]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>