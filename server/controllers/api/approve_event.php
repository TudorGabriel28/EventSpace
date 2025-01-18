<?php

header('Content-Type: application/json');

include_once("../../config.php");
include_once("../../db_connection.php");

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON"]);
    exit;
}

$id = $data['id'];
$action = $data['action'];

try {
    $isApproved = $action === 'approve' ? 1 : 0;
    $query = "UPDATE event SET isApproved = ? WHERE id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $isApproved, $id);
    $stmt->execute();
    
    echo json_encode(["status" => "success"]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>