<?php

// Include configuration and database connection files
include '../server/config.php';
include '../server/db_connection.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Validate and sanitize input
  $event_name = trim($_POST['event_name']);
  $description = trim($_POST['description']);
  $category = (int) $_POST['category'];
  $cover_photo = $_FILES['cover_photo']['name'];

  if (empty($event_name) || empty($description) || empty($category) || empty($cover_photo)) {
      die("Please fill in all required fields.");
  }

  // Handle file upload
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($cover_photo);
  if (!move_uploaded_file($_FILES['cover_photo']['tmp_name'], $target_file)) {
      die("Error uploading cover photo.");
  }

  // Insert event details
  $stmt = $conn->prepare("INSERT INTO event (name, description, coverphoto) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $event_name, $description, $cover_photo);
  if (!$stmt->execute()) {
      die("Event insertion failed: " . $stmt->error);
  }
  $event_id = $conn->insert_id;

  // Insert category details
  $stmt = $conn->prepare("INSERT INTO eventcategory (category_id, event_id) VALUES (?, ?)");
  $stmt->bind_param("ii", $category, $event_id);
  if (!$stmt->execute()) {
      die("Category insertion failed: " . $stmt->error);
  }

  // Handle locations and planning data
  $location_names = $_POST['location_name'];
  $location_addresses = $_POST['location_address'];
  $start_dates = $_POST['start_date'];
  $end_dates = $_POST['end_date'];
  $capacities = $_POST['capacity'];
  $prices = $_POST['price'];
  $postal_codes = $_POST['postal_code'];

  for ($i = 0; $i < count($location_names); $i++) {
      $stmt = $conn->prepare("INSERT INTO location (address, city, postal_code) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $location_addresses[$i], $location_names[$i], $postal_codes[$i]);
      if (!$stmt->execute()) {
          die("Location insertion failed: " . $stmt->error);
      }
      $location_id = $conn->insert_id;

      $stmt = $conn->prepare("INSERT INTO planning (capacity, startDate, endDate, price, eventid, locationid) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("issdii", $capacities[$i], $start_dates[$i], $end_dates[$i], $prices[$i], $event_id, $location_id);
      if (!$stmt->execute()) {
          die("Planning insertion failed: " . $stmt->error);
      }
  }

  echo "<p>Event successfully created!</p>";
}

?>