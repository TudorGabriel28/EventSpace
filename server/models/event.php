<?php

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

    return $events;
}
?>