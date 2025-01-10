<?php
include '../config.php';
include '../db_connection.php';

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);
$eventId = $data['id'];
$action = $data['action'];

if ($action === 'approve') {
    $sql = "UPDATE event SET isApproved = 1 WHERE id = ?";
} else {
    $sql = "DELETE FROM event WHERE id = ?";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $eventId);

$response = array();
if ($stmt->execute()) {
    $response['status'] = 'success';
    $response['message'] = $action === 'approve' ? 'Event approved successfully' : 'Event rejected successfully';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error processing event: ' . $stmt->error;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>