<?php
include '../config.php';
include '../db_connection.php';

$stylesheet = "specific.css";

$categoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : '';

if (empty($categoryId)) {
    header("Location: home.php");
    exit();
}

// Query to fetch category name
$categoryQuery = "SELECT name FROM category WHERE id = '$categoryId'";
$categoryResult = $conn->query($categoryQuery);
$categoryName = '';
if ($categoryResult->num_rows > 0) {
    $categoryRow = $categoryResult->fetch_assoc();
    $categoryName = $categoryRow['name'];
}

// Query to fetch event details, planning data, and location
$sql = "SELECT 
            e.id AS id, 
            e.name AS name, 
            e.description AS description, 
            e.coverPhoto AS coverPhoto, 
            c.id AS categoryId, 
            c.name AS categoryName, 
            MIN(p.startDate) AS startDateTime,
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


    <link rel="stylesheet" href="../styles/specific-category.css">
</head>
<body>
    <?php include_once '../components/header.php'; ?>

    <main>
        <div class="header">
            <h1>Events in <?= htmlspecialchars($categoryName) ?> Category</h1>
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