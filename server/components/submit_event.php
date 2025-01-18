<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config.php';
include '../db_connection.php';



// Check if the form was submitted
session_start();
$user_id = $_SESSION['user_id'];

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
        die("Category insertion failed: " . $stmt->error);
    }
    $stmt_eventcategory->insert_id;


    $address = $_POST['location_address'];
    $city = $_POST['location_city'];
    $postalCode = $_POST['postal_code'];
    $start_dates = $_POST['start_date'];
    $end_dates = $_POST['end_date'];
    $capacity = $_POST['capacity'];
    $price = $_POST['price'];


    // Ensure that the data is in array format
    if (!is_array($address) || !is_array($city) || !is_array($postalCode) || !is_array($start_dates) || !is_array($end_dates) || !is_array($capacity) || !is_array($price)) {
        die("Invalid data format.");
    }

    // Validate dates
    $error_message = "";
    foreach ($start_dates as $index => $start_date) {
        $end_date = $end_dates[$index];
        if (strtotime($end_date) < strtotime($start_date)) {
            $error_message = "End date cannot be earlier than start date" . ($index + 1) . ".";
            break;
        }
    }
    if ($error_message) {
        echo "<input type='hidden' id='error_message' value='$error_message'>";

    } else {

        // Iterate over the arrays and bind parameters for each value
        for ($i = 0; $i < count($address); $i++) {
            $current_postalCode = $postalCode[$i];
            $current_city = $city[$i];
            $current_address = $address[$i];
            $current_start_dates = $start_dates[$i];
            $current_end_dates = $end_dates[$i];
            $current_capacity = $capacity[$i];
            $current_price = $price[$i];

            // Insert the data into the database
            $sql_location = "INSERT INTO location ( postalCode, city, address) VALUES (?, ?, ?)";
            $stmt_location = $conn->prepare($sql_location);
            $stmt_location->bind_param("sss", $current_postalCode, $current_city, $current_address);
            //$stmt_location->execute();
            // Check if the statement was prepared successfully
            if (!$stmt_location->execute()) {
                die("Location insertion failed: " . $stmt_location->error);
            }
            $location_id = $stmt_location->insert_id;

            // Format the date and time
            $formatted_startdate = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $current_start_dates)));
            $formatted_enddate = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $current_end_dates)));

            // Insert data into the planning table
            $sql_planning = "INSERT INTO planning (startDate, endDate, capacity, price, idEvent, idLocation) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_planning = $conn->prepare($sql_planning);
            $stmt_planning->bind_param("ssiiii", $formatted_startdate, $formatted_enddate, $current_capacity, $current_price, $event_id, $location_id);
            if (!$stmt_planning->execute()) {
                die("Planning insertion failed: " . $stmt_planning->error);
            }


            $stmt_location->close();
            $stmt_planning->close();

        }

        // Set success message and redirect to the host page
        $_SESSION['success'] = "Event is pending for approval.";
        header("Location: ../views/host.php");

        exit; // Ensure the script stops after redirect

    }
} else {
    die("Invalid request method.");
}
// Close the statement and connection
$stmt_event->close();
$stmt_eventcategory->close();
$conn->close();

?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var errorMessage = document.getElementById('error_message');
        if (errorMessage) {
            alert(errorMessage.value);
            window.location.href = "../views/host.php"; // Redirect to host.php
        }
    });
</script>