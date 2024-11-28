<?php
// Include database connection

include '../config.php';
include '../db_connection.php';


// Query to fetch event details and their corresponding planning data
$sql = "SELECT 
            e.id, 
            e.name, 
            e.description, 
            e.coverPhoto, 
            p.startDate, 
            p.endDate, 
            p.price 
        FROM 
            event AS e
        INNER JOIN 
            planning AS p 
        ON 
            e.id = p.idEvent";

// Execute the query
$result = $conn->query($sql);

// Prepare an array to store event data
$events = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
} else {
    echo "No events found!";
}

$conn->close(); // Close database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eventspace</title>
  <style>
    body {
      background-color: white;
      font-family: Arial, sans-serif;
    }
    h1 {
      color: black;
      margin-left: 20px;
    }
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    .filters-container {
      display: flex;
      justify-content: flex-start;
      margin: 20px;
    }
    .filter {
      display: flex;
      flex-direction: column;
      margin-right: 10px;
    }
    .filter span {
      margin-bottom: 5px;
      font-weight: bold;
    }
    .filter select,
    .filter input[type="date"] {
      width: 200px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 20px;
      box-sizing: border-box;
    }
    .events-container {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
      gap: 20px;
    }
    .event-card {
      width: 300px;
      background-color: #ffffff;
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 15px;
      box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
      text-align: center;
    }
    .event-card img {
      width: 100%;
      height: 200px;
      border-radius: 10px;
      object-fit: cover;
    }
    .event-details {
      margin-top: 15px;
    }
    .event-details h2 {
      font-size: 18px;
      margin-bottom: 10px;
      text-align: left;
    }
    .event-details p {
      font-size: 14px;
      color: #555;
      margin-bottom: 10px;
      text-align: left;
    }
    .event-details .date {
      font-weight: bold;
      margin-bottom: 15px;
      text-align: left;
    }
    .event-details .price {
      font-size: 14px;
      font-weight: bold;
      color: #333;
      text-align: left;
    }
    .event-details button {
      padding: 10px 20px;
      background-color: #ff8800;
      color: #ffffff;
      border: none;
      border-radius: 5px;
      font-size: 14px;
      cursor: pointer;
      margin-left: 190px;
    }
    .event-details button:hover {
      background-color: #e67600;
    }
  </style>
</head>
<body>
<h1>asdasdas</h1>
<p><?php $result ?></p>

  <!-- Header -->
  <div class="header">
    <h1>Upcoming Events</h1>
  </div>

  <!-- Filters Section -->
  <div class="filters-container">
    <!-- Category Filter -->
    <div class="filter">
      <span>Category</span>
      <select>
        <option value="art">Art</option>
        <option value="sports">Sports</option>
        <option value="music">Music</option>
        <option value="technology">Technology</option>
        <option value="food">Food</option>
        <option value="fashion">Fashion</option>
      </select>
    </div>

    <!-- Date Filter -->
    <div class="filter">
      <span>Date</span>
      <input type="date">
    </div>
  </div>

  <!-- Events Section -->
  <div class="events-container">
    <?php if (!empty($events)): ?>
        <?php foreach ($events as $event): ?>
            <div class="event-card">
                <img src="images/<?php echo $event['coverPhoto']; ?>" alt="<?php echo htmlspecialchars($event['name']); ?>">
                <div class="event-details">
                    <h2><?php echo htmlspecialchars($event['name']); ?></h2>
                    <p><?php echo htmlspecialchars($event['description']); ?></p>
                    <div class="date">
                        <strong>Start Date:</strong> <?php echo $event['startDate'] ?: "TBD"; ?><br>
                        <strong>End Date:</strong> <?php echo $event['endDate'] ?: "TBD"; ?>
                    </div>
                    <?php if (!empty($event['price'])): ?>
                        <div class="price">
                            Price: $<?php echo number_format($event['price'], 2); ?>
                        </div>
                    <?php endif; ?>
                    <button>View More</button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No events to display at the moment.</p>
    <?php endif; ?>
  </div>

  <!-- FAQ section-->
  <div style="text-align: center; margin: 20px 0;">
    <h2><a href="faq.html" style="text-decoration: none; color: #007BFF;">FAQ</a></h2>
  </div>

  <!-- Contact section-->
  <div style="text-align: center; margin: 30px 0;">
    <h2><a href="contact.html" style="color: #ff8000; text-decoration: none;">Contact Us</a></h2>
  </div>
  
</body>
</html>
