<?php
   function getPendingEvents($conn) {
    $query = "SELECT id, name, description, coverPhoto FROM event WHERE isApproved = 0";
    return self::fetchEvents($conn, $query);
}

    function getApprovedEvents($conn) {
    $query = "SELECT id, name, description FROM event WHERE isApproved = 1";
    return self::fetchEvents($conn, $query);
}

function getEvents($conn): array
{
    $query = "SELECT 
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
        e.isApproved = 1
    GROUP BY 
        e.id, e.name, e.description, e.coverPhoto, c.id, c.name
    ORDER BY e.creationTimestamp DESC
    LIMIT 5";

    // Use mysqli's query method
    $result = $conn->query($query);

    $events = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }
    }

    return $events;
}

function getSearchResults($conn, $search, $category, $startDate, $endDate): array
{

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
    e.name LIKE '%$search%'";

    if ($category) {
        $sql .= " AND c.id = '$category'";
    }

    private static function fetchEvents($conn, $query) {
        $events = [];
        try {
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $events[] = $row;
            }
        } catch (mysqli_sql_exception $e) {
            die("Error fetching events: " . $e->getMessage());
        }
        return $events;
    }
}