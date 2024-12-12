<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Include configuration and database connection files
include '../config.php';
include '../db_connection.php';
// Check if the form was submitted

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
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

    // Insert event details
    $sql_event = "INSERT INTO event (name, description, coverPhoto) VALUES (?, ?, ?)";
    $stmt_event = $conn->prepare($sql_event);
    $stmt_event->bind_param("sss", $event_name, $description, $cover_photo);
    if (!$stmt_event->execute()) {
        die("Event insertion failed: " . $stmt->error);
    }
    $stmt_event->insert_id;

    $address = $_POST['location_address'];
    $city = $_POST['location_city'];
    $postalCode = $_POST['postal_code'];
    $location_num = $_POST['location_num'];

    // Ensure that the data is in array format
    if (!is_array($address) || !is_array($city) || !is_array($postalCode)) {
        die("Invalid data format.");
    }

    // Insert the data into the database
    $sql_location = "INSERT INTO location ( postalCode, city, address ) VALUES (?, ?, ?)";
    $stmt_location = $conn->prepare($sql_location);
    

    // Check if the statement was prepared successfully
    if ($stmt_location === false) {
        die("Error preparing the SQL statement: " . $conn->error);
    }

    // Iterate over the arrays and bind parameters for each value
    for ($i = 0; $i < count($address); $i++) {
        $postalCode = $postalCode[$i];
        $city = $city[$i];
        $address = $address[$i];

    $stmt_location->bind_param("sss", $postalCode, $city, $address);

    // Execute the query
    if ($stmt_location->execute()) {
        echo "Location successfully added with ID: " . $stmt_location->insert_id;
        header("Location: ../pages/home.php"); // Redirect to a different page (optional)
        exit; // Ensure the script stops after redirect
    } else {
        echo "Error: " . $stmt_location->error;
    }
}

    // Close the statement and connection
    $stmt_location->close();
    $conn->close();
}

?>