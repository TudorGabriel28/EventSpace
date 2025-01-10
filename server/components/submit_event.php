<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config.php';
include '../db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Basic event details
    $event_name = $_POST['event_name'];
    $description = $_POST['description'];
    $category = (int) $_POST['category'];
    $cover_photo = $_FILES['coverPhoto']['name'];

    // Handle file upload
    $target_dir = "../assets/events/";
    $target_file = $target_dir . basename($cover_photo);
    if (!move_uploaded_file($_FILES['coverPhoto']['tmp_name'], $target_file)) {
        die("Error uploading cover photo.");
    }

    // Insert event with isApproved = 0
    $sql_event = "INSERT INTO event (name, description, coverPhoto, isApproved) VALUES (?, ?, ?, 0)";
    $stmt_event = $conn->prepare($sql_event);
    $stmt_event->bind_param("sss", $event_name, $description, $target_file);
    if (!$stmt_event->execute()) {
        die("Event insertion failed: " . $stmt_event->error);
    }
    $event_id = $stmt_event->insert_id;

    // Insert category
    $sql_eventcategory = "INSERT INTO eventcategory (idEvent, idCategory) VALUES (?, ?)";
    $stmt_eventcategory = $conn->prepare($sql_eventcategory);
    $stmt_eventcategory->bind_param("ii", $event_id, $category);
    if (!$stmt_eventcategory->execute()) {
        die("Category insertion failed: " . $stmt_eventcategory->error);
    }

    // Location details
    $location_num = (int)$_POST['location_num'];
    
    // Process each location
    for ($i = 0; $i < $location_num; $i++) {
        $curr_postal = $_POST['postal_code'][$i];
        $curr_city = $_POST['location_city'][$i];
        $curr_address = $_POST['location_address'][$i];
        $curr_start = $_POST['start_date'][$i];
        $curr_end = $_POST['end_date'][$i];
        $curr_capacity = (int)$_POST['capacity'][$i];
        $curr_price = (int)$_POST['price'][$i];

        // Insert location
        $sql_location = "INSERT INTO location (postalCode, city, address) VALUES (?, ?, ?)";
        $stmt_location = $conn->prepare($sql_location);
        if (!$stmt_location) {
            die("Location preparation failed: " . $conn->error);
        }
        
        $stmt_location->bind_param("sss", $curr_postal, $curr_city, $curr_address);
        if (!$stmt_location->execute()) {
            die("Location insertion failed: " . $stmt_location->error);
        }
        $location_id = $stmt_location->insert_id;

        // Format dates
        $formatted_start = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $curr_start)));
        $formatted_end = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $curr_end)));

        // Insert planning
        $sql_planning = "INSERT INTO planning (startDate, endDate, capacity, price, idEvent, idLocation) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_planning = $conn->prepare($sql_planning);
        $stmt_planning->bind_param("ssiiii", $formatted_start, $formatted_end, $curr_capacity, $curr_price, $event_id, $location_id);
        if (!$stmt_planning->execute()) {
            die("Planning insertion failed: " . $stmt_planning->error);
        }
    }

    // Close statements
    $stmt_event->close();
    $stmt_eventcategory->close();
    $stmt_location->close();
    $stmt_planning->close();
    $conn->close();

    echo "<script>alert('Event created successfully and pending approval'); window.location.href = '../pages/home.php';</script>";
} else {
    die("Invalid request method.");
}
?>