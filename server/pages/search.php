<?php
include '../config.php';
include '../db_connection.php';

$stylesheet = "search.css";

$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';


// Redirect to home page if search parameter is empty
if (empty($search)) {
    header("Location: home.php");
    exit();
}


// Query to fetch event details, planning data, and location
$sql = "SELECT 
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
    e.name LIKE '%$search%'";

if ($category) {
    $sql .= " AND c.id = '$category'";
}

if ($startDate) {
    $sql .= " AND DATE(p.startDate) >= '$startDate'";
}

if ($endDate) {
    $sql .= " AND DATE(p.endDate) <= '$endDate'";
}

$sql .= " GROUP BY 
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
}

$categoryQuery = "SELECT id, name FROM category";
$categoryResult = $conn->query($categoryQuery);

$categories = [];

if ($categoryResult->num_rows > 0) {
    while($row = $categoryResult->fetch_assoc()) {
        $categories[] = $row;
    }
}


$conn->close(); // Close database connection
?>

<?php include_once '../components/header.php'; ?>

<main>
    <!-- Header -->
    <div class="header">
        <h1>Search results for '<?= htmlspecialchars($search) ?>'
        </h1>
    
    </div>

    <!-- Filters Section -->
    <form action="search.php" method="GET">
        <div class="filters-container">
            <!-- Category Filter -->
            <div class="filter">
                <span>Category</span>
                <select name="category">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['id']) ?>" <?= isset($_GET['category']) && $_GET['category'] == $category['id'] ? 'selected' : '' ?>><?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="filter">
                    <span>Start Date</span>
                    <input type="date" name="start_date" value="<?= htmlspecialchars($startDate) ?>">
                </div>
            
                <div class="filter">
                    <span>End Date</span>
                    <input type="date" name="end_date" value="<?= htmlspecialchars($endDate) ?>">
                </div>
            
            <div class="filter">
                <span>&nbsp;</span> <!-- Empty span to align the button -->
                <button type="submit" class="btn btn-primary">Apply Filters</button>
            </div>
        </div>
        <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
    </form>


    <div class="event-preview-list">
            
            <?php foreach ($events as $event): ?>
                <?php 
                    $eventData = ['event' => $event];
                    include '../components/event-preview.php'; 
                ?>
        <?php endforeach; ?>
        <?php if (empty($events)): ?>
            <div class="no-events">
                <p>No events found!</p>
            </div>
        <?php endif; ?>
    
    </main>
<?php include_once '../components/footer.php'; ?>
</body>
</html>