<?php

session_start(); // Ensure the session is started

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
    $stmt_event->bind_param("sss", $event_name, $description, $target_file);
    if (!$stmt_event->execute()) {
        die("Event insertion failed: " . $stmt->error);
    }
    $event_id = $stmt_event->insert_id;

    // Insert category details
    $sql_eventcategory = "INSERT INTO eventcategory (idEvent, idCategory) VALUES (?, ?)";
    $stmt_eventcategory = $conn->prepare($sql_eventcategory);
    $stmt_eventcategory->bind_param("ii", $event_id, $category);
    if (!$stmt_eventcategory->execute()) {
        die("Category insertion failed: " . $stmt->error);
    }
    $stmt_eventcategory->insert_id;


    $address = $_POST['location_address'];
    $city = $_POST['location_city'];
    $postalCode = $_POST['postal_code'];
    $location_num = $_POST['location_num'];
    $start_dates = $_POST['start_date'];
    $end_dates = $_POST['end_date'];
    $capacity = $_POST['capacity'];
    $price = $_POST['price'];


    // Ensure that the data is in array format
    if (!is_array($address) || !is_array($city) || !is_array($postalCode) || !is_array($start_dates) || !is_array($end_dates) || !is_array($capacity) || !is_array($price)) {
        die("Invalid data format.");
    }

    

    // Iterate over the arrays and bind parameters for each value
    for ($i = 0; $i < count($address); $i++) {
        $postalCode = $postalCode[$i];
        $city = $city[$i];
        $address = $address[$i];
        $start_dates = $start_dates[$i];
        $end_dates = $end_dates[$i];
        $capacity = $capacity[$i];
        $price = $price[$i];

     // Insert the data into the database
    $sql_location = "INSERT INTO location ( postalCode, city, address ) VALUES (?, ?, ?)";
    $stmt_location = $conn->prepare($sql_location);
    

    // Check if the statement was prepared successfully
    if (!$stmt_location) {
        die("Location insertion failed: " . $conn->error);
    } 


     
    
    // Convert datetime format from 'YYYY-MM-DDTHH:MM' to 'YYYY-MM-DD HH:MM:SS'
    //$start_dates = str_replace('T', ' ', $start_dates) . ':00';
   // $end_dates = str_replace('T', ' ', $end_dates) . ':00';
   
    // Format the date and time
    $formatted_startdate = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $start_dates)));
    $formatted_enddate = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $end_dates)));

    // Debugging: Check the values of start_date and end_date
    echo "Start Date: $formatted_startdate, End Date: $formatted_enddate<br>";

    $stmt_location->bind_param("sss", $postalCode, $city, $address);

    // Execute the query
    if ($stmt_location->execute()) {
        $location_id = $stmt_location->insert_id;
        // Insert data into the planning table
        $sql_planning = "INSERT INTO planning (startDate, endDate, capacity, price, idEvent, idLocation) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_planning = $conn->prepare($sql_planning);
        $stmt_planning->bind_param("ssiiii", $formatted_startdate, $formatted_enddate, $capacity, $price, $event_id, $location_id);
        if (!$stmt_planning->execute()) {
            die("Planning insertion failed: " . $stmt_planning->error);
        }
        $stmt_planning->insert_id;
        header("Location: ../pages/home.php"); // Redirect to a different page (optional)
        exit; // Ensure the script stops after redirect
    } else {
        echo "Error: " . $stmt_location->error;
    }
}

    // Close the statement and connection
    $stmt_event->close();
    $stmt_eventcategory->close();
    $stmt_location->close();
    $stmt_planning->close();
    $conn->close();

    // Display success message
    
}else {
    die("Invalid request method.");
}


?>