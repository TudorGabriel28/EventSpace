<?php
include '../controllers/host.php';
include_once '../components/header.php';
?>
<main class="host-event">
  <section class="page-title">
    <h1>Host Event</h1>
    <p>Your Event! Your Squad! Your Way!</p>
  </section>

  <div class="container">
    <h2>Enter event details</h2>
    <form id="host-event-form" action="../controllers/submit_event.php" method="POST" enctype="multipart/form-data">
      <div class="note" style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; border-radius:5px;">
        <p>Note: The event will be created once approved by the admin.</p>
      </div>

      <!-- Event Name -->
      <label for="event-name">Event Name:</label>
      <input type="text" id="event-name" name="event_name" placeholder="Enter the event name">

      <!-- Description -->
      <label for="description">Description:</label>
      <textarea id="description" name="description" placeholder="Enter the event description" required></textarea>

      <!-- Category -->
      <label for="Category">Category</label>
      <select id="Category" name="category" required>
        <option value="">Select Category</option>
        <?php foreach ($categories as $category): ?>
          <option value="<?= htmlspecialchars($category['id']); ?>">
            <?= htmlspecialchars($category['name']); ?>
          </option>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('host-event-form');
    const isLoggedIn = <?= json_encode(isset($_SESSION['user_id'])); ?>;

    form.addEventListener('submit', function(event) {
        if (!isLoggedIn) {
            event.preventDefault();
            alert('Please log in first to create an event.');
            window.location.href = '../views/login.php'; // Redirect to login page
        }
        const startDates = document.querySelectorAll('input[name="start_date[]"]');
        const endDates = document.querySelectorAll('input[name="end_date[]"]');
        for (let i = 0; i < startDates.length; i++) {
            const startDate = new Date(startDates[i].value);
            const endDate = new Date(endDates[i].value);
            if (endDate < startDate) {
                event.preventDefault();
                alert(`End date cannot be earlier than start date for location ${i + 1}.`);
                return;
            }
        }
    });

<?php if (isset($_SESSION['success'])): ?>
        alert("<?= $_SESSION['success']; ?>");
        <?php unset($_SESSION['success']); ?>
        window.location.href = '../views/home.php'; // Redirect to home page
<?php endif; ?>
});
</script>

<?php include_once '../components/footer.php'; ?>
<script src="../scripts/host_event.js" defer></script>
<link rel="stylesheet" type="text/css" href="<?= $stylesheet; ?>">

</body>
</html>
