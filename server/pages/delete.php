<?php
include '../config.php';
include '../db_connection.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$type = $data['type'];
$id = $data['id'];

$query = "";

if ($type === 'user') {
    $query = "DELETE FROM user WHERE id = ?";
} elseif ($type === 'event') {
    $query = "DELETE FROM event WHERE id = ?";
} elseif ($type === 'forum') {
    $query = "DELETE FROM forumdiscussion WHERE id = ?";
}

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();

echo json_encode(["status" => "success", "message" => "Record deleted successfully"]);
?>
