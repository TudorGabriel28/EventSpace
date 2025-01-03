<?php

$stylesheet = "../styles/host.css";

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include configuration and database connection files
include '../config.php';
include '../db_connection.php';

// Fetch categories from the database
$sql_category = "SELECT id, name FROM category";
$result_category = $conn->query($sql_category);

if ($result_category === false) {
    die("Error fetching categories: " . $conn->error);
}

$categories = [];
while ($row = $result_category->fetch_assoc()) {
    $categories[] = $row;
}

$conn->close();
?>

<?php include_once '../components/header.php'; ?>
<main class="host-event">

  <section class="page-title">
    <h1>Host Event</h1>
    <p>Your Event ! Your Squad ! Your Way!</p>
  </section>

  <div class="container">
    <h2>Enter event details</h2>
    <form action="../components/submit_event.php" method="POST" enctype="multipart/form-data">
      <!-- Event Name -->
      <label for="event-name">Event Name:</label>
      <input type="text" id="event-name" name="event_name", placeholder="Enter the event name">

      <!-- Description -->
      <label for="description">Description:</label>
      <textarea id="description" name="description" placeholder="Enter the event description" required></textarea>

      <!-- Category -->
      <label for="Category">Category</label>
      <select id="Category" name="category" required>
      <option value="">Select Category</option>
        <?php foreach ($categories as $category): ?>
          <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
        <?php endforeach; ?>
      </select>

      <!-- Cover Photo -->
      <label for="cover-photo">Cover Photo:</label>
      <input type="file" id="cover-photo" name="coverPhoto" required>

      <!-- Number of Locations -->
      <label for="num-locations">Number of Locations:</label>
      <input type="number" id="num-locations" name="location_num" placeholder="Enter the number of locations" min="1" max="10">

      <!-- Tabs Container -->
      <div id="tabs-container" class="tabs"></div>

      <!-- Location Details Container -->
      <div id="location-container"></div>
      
      <button type="submit" name="createEvent" class="create-event">Create Event</button>
    </form>
  </div>

  
</main>

<?php include_once '../components/footer.php'; ?>
<script src="../scripts/host_event.js" defer></script>
<link rel="stylesheet" type="text/css" href="<?php echo $stylesheet; ?>">

</body>
</html>