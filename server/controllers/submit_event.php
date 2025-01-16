<?php
include '../config.php';
include '../db_connection.php';
include '../models/event_submission.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $event_name = $_POST['event_name'];
    $description = $_POST['description'];
    $category = (int)$_POST['category'];
    $cover_photo = $_FILES['coverPhoto']['name'];
    $target_dir = "../assets/events/";
    $target_file = $target_dir . basename($cover_photo);

    if (!move_uploaded_file($_FILES['coverPhoto']['tmp_name'], $target_file)) {
        die("Error uploading cover photo.");
    }

    $conn->begin_transaction();
    try {
        $event_id = insertEvent($conn, $event_name, $description, $target_file);
        insertEventCategory($conn, $event_id, $category);

        $addresses = $_POST['location_address'];
        $cities = $_POST['location_city'];
        $postalCodes = $_POST['postal_code'];
        $startDates = $_POST['start_date'];
        $endDates = $_POST['end_date'];
        $capacities = $_POST['capacity'];
        $prices = $_POST['price'];

        foreach ($addresses as $i => $address) {
            $location_id = insertLocation($conn, $address, $cities[$i], $postalCodes[$i]);
            insertPlanning(
                $conn,
                date('Y-m-d H:i:s', strtotime($startDates[$i])),
                date('Y-m-d H:i:s', strtotime($endDates[$i])),
                $capacities[$i],
                $prices[$i],
                $event_id,
                $location_id
            );
        }

        $conn->commit();
        $_SESSION['success'] = "Event is pending for approval.";
        header("Location: ../views/host.php");
        exit;
    } catch (Exception $e) {
        $conn->rollback();
        die("Error processing request: " . $e->getMessage());
    }
} else {
    die("Invalid request method.");
}
?>
