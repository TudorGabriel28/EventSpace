<?php
include '../config.php';
include '../db_connection.php';

$stylesheet = "common.css";

$categoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : '';

if (empty($categoryId)) {
    header("Location: home.php");
    exit();
}

// Query to fetch event details, planning data, and location
$eventQuery = "SELECT 
    e.id AS id, 
    e.name AS name, 
    e.description AS description, 
    e.coverPhoto AS coverPhoto, 
    c.id AS categoryId, 
    c.name AS categoryName, 
    JSON_ARRAYAGG(JSON_OBJECT('city', l.city, 'postalCode', l.postalCode)) AS locations
FROM 
    event e
JOIN 
    eventcategory ec ON e.id = ec.idEvent
JOIN 
    category c ON ec.idCategory = c.id
JOIN 
    planning p ON e.id = p.idEvent
JOIN 
    location l ON p.idLocation = l.id
WHERE
    c.id = '$categoryId'
GROUP BY 
    e.id, e.name, e.description, e.coverPhoto, c.id, c.name
ORDER BY e.creationTimestamp DESC";

// Execute the query
$result = $conn->query($eventQuery);

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
    <title>Specific Category - Eventspace</title>
    <link rel="stylesheet" href="../styles/common.css">
</head>
<body>
    <?php include_once '../components/header.php'; ?>

    <main>
        <div class="header">
            <h1>Events in Specific Category</h1>
        </div>

        <div class="event-preview-list">
            <!-- list of events -->
            <?php foreach ($events as $event): ?>
                <?php 
                    $eventData = ['event' => $event];
                    include '../components/event-preview.php'; 
                ?>
        <?php endforeach; ?>

             
        
        </div>
    </main>

    <?php include_once '../components/footer.php'; ?>
</body>
</html>