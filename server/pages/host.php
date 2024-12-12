<?php
$stylesheet = "host.css";
?>

<?php include_once '../components/header.php'; ?>
<main>

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
        <option value="">Value</option>
        <option value="music">Music</option>
        <option value="sports">Sports</option>
        <option value="conference">Conference</option>
      </select>

      <!-- Cover Photo -->
      <label for="cover-photo">Cover Photo:</label>
      <input type="file" id="cover-photo" name="coverPhoto" required>

      <!-- Number of Locations -->
      <label for="num-locations">Number of Locations:</label>
      <input type="number" id="num-locations" placeholder="Enter the number of locations" min="1" max="10">

      <!-- Tabs Container -->
      <div id="tabs-container" class="tabs"></div>

      <!-- Location Details Container -->
      <div id="location-container"></div>
      
      <button type="submit" class="create-event">Create Event</button>
    </form>
  </div>
  
</main>
<?php include_once '../components/footer.php'; ?>
<script src="../scripts/host_event.js" defer></script>
</body>
</html>