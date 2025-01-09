<?php
include '../config.php';
include '../db_connection.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$type = $data['type'];
$id = $data['id'];
$update = $data['data'];

$query = "";

if ($type === 'user') {
    $query = "UPDATE user SET firstName = ?, lastName = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $update['firstName'], $update['lastName'], $update['email'], $id);
} elseif ($type === 'event') {
    $query = "UPDATE event SET name = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $update['name'], $update['description'], $id);
} elseif ($type === 'forum') {
    $query = "UPDATE forumdiscussion SET title = ?, question = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $update['title'], $update['question'], $id);
}

$stmt->execute();
echo json_encode(["status" => "success", "message" => "Record updated successfully"]);
?>
