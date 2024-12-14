<?php
include '../config.php';
include '../db_connection.php';

// Fetch query parameters
$type = isset($_GET['type']) ? $_GET['type'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Redirect if no valid type or id is provided
if (empty($type) || $id <= 0) {
    header("Location: admin.php");
    exit();
}

// Permanently delete the record
try {
    if ($type === 'user') {
        $query = "DELETE FROM user WHERE id = ?";
    } elseif ($type === 'event') {
        $query = "DELETE FROM event WHERE id = ?";
    } elseif ($type === 'forum') {
        $query = "DELETE FROM forumdiscussion WHERE id = ?";
    } else {
        throw new Exception("Invalid type specified.");
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: admin.php");
    exit();
} catch (Exception $e) {
    die("Error permanently deleting data: " . $e->getMessage());
}
?>
