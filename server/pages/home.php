<?php

include '../config.php';
include '../db_connection.php';

// Query to fetch events
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
GROUP BY 
    e.id, e.name, e.description, e.coverPhoto, c.id, c.name
ORDER BY e.creationTimestamp DESC
LIMIT 5";

$categoryQuery = "SELECT id, name, photo FROM category";

$eventResult = $conn->query($eventQuery);
$categoryResult = $conn->query($categoryQuery);

$events = [];
$categories = [];

if ($eventResult->num_rows > 0) {
    while($row = $eventResult->fetch_assoc()) {
        $events[] = $row;
    }
}

if ($categoryResult->num_rows > 0) {
    while($row = $categoryResult->fetch_assoc()) {
        $categories[] = $row;
    }
}

$conn->close();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/common.css">
    <link rel="stylesheet" href="../styles/home.css">
</head>
<body>
    <div id="hero-image">
        <h1>Come &<br> Be a part<br> of the family</h1>
    </div>
    <div id="popular-events">
        <h2 class="section-title">Newest Events</h2>
        <div class="event-preview-list">
            <!-- list of events -->
            <?php foreach ($events as $event): ?>
            <div class="event-preview">
                <div class="event-preview-image" style="background-image: url('<?= htmlspecialchars($event['coverPhoto']) ?>');">
                    <div class="event-preview-date">
                        On 05/05/2024
                    </div>
                </div>
                <div class="event-preview-info">
                    <h4 class="event-preview-title"><?= htmlspecialchars($event['name']) ?></h4>
                    <div class="event-preview-category-container">
                        <p class="event-preview-category"><?= htmlspecialchars($event['categoryName']) ?></p>
                        <div class="event-preview-location-list">
                            <?php 
                                $locations = json_decode($event['locations'], true); // Decode the JSON array of locations
                                if (!empty($locations)): 
                                    foreach ($locations as $location): ?>
                                            <div class="event-preview-location">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1.5rem" height="1.5rem"><title>map-marker-radius-outline</title><path d="M12 4C14.2 4 16 5.8 16 8C16 10.1 13.9 13.5 12 15.9C10.1 13.4 8 10.1 8 8C8 5.8 9.8 4 12 4M12 2C8.7 2 6 4.7 6 8C6 12.5 12 19 12 19S18 12.4 18 8C18 4.7 15.3 2 12 2M12 6C10.9 6 10 6.9 10 8S10.9 10 12 10 14 9.1 14 8 13.1 6 12 6M20 19C20 21.2 16.4 23 12 23S4 21.2 4 19C4 17.7 5.2 16.6 7.1 15.8L7.7 16.7C6.7 17.2 6 17.8 6 18.5C6 19.9 8.7 21 12 21S18 19.9 18 18.5C18 17.8 17.3 17.2 16.2 16.7L16.8 15.8C18.8 16.6 20 17.7 20 19Z" /></svg>
                                                <p class="event-preview-location-title"><?= htmlspecialchars($location['city']) ?>, <?= htmlspecialchars($location['postalCode']) ?></p>
                                            </div>
                                        
                                    <?php endforeach; 
                                endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

             
        
        </div>
    </div>
    <div id="categories">
        <h2 class="section-title">Browse all the activities</h2>
        <div class="category-list">
        <?php foreach ($categories as $category): ?>
            <div class="category">
                <img class="category-image" src="<?= htmlspecialchars($category['photo']) ?>" alt="">
                <div class="category-title"><?= $category['name'] ?></div>
            </div>
        <?php endforeach; ?>
    
        </div>

    </div>
    

</body>
</html>
