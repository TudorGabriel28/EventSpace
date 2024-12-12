<?php

include '../config.php';
include '../db_connection.php';

$stylesheet = "home.css";

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


<?php include_once '../components/header.php'; ?>
<main>
    <div id="hero-image">
        <h1>Come &<br> Be a part<br> of the family</h1>
    </div>
    <div id="popular-events">
        <h2 class="section-title">Newest Events</h2>
        <div class="event-preview-list">
            <!-- list of events -->
            <?php foreach ($events as $event): ?>
                <?php 
                    $eventData = ['event' => $event];
                    include '../components/event-preview.php'; 
                ?>
        <?php endforeach; ?>

             
        
        </div>
    </div>
    <div id="categories">
        <h2 class="section-title">Browse all the activities</h2>
        <div class="category-list">
        <?php foreach ($categories as $category): ?>
            <a href="specific.php?categoryId=<?= htmlspecialchars($category['id']) ?>" class="category-link">
                <div class="category">
                    <img class="category-image" src="<?= htmlspecialchars($category['photo']) ?>" alt="">
                    <div class="category-title"><?= htmlspecialchars($category['name']) ?></div>
                </div>
            </a>
        <?php endforeach; ?>
    
        </div>

    </div>
    
</main>
<?php include_once '../components/footer.php'; ?>
</body>
</html>
