<?php

function getCategories($conn): array
{
    $query = "SELECT id, name, photo FROM category";
    $result = $conn->query($query);

    $categories = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }

    return $categories;
}


function getCategoryNameById($conn, $categoryId): string
{
    $query = "SELECT name FROM category WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();
    $categoryName = '';

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $categoryName = $row['name'];
    }

    return $categoryName;
}


function getEventsByCategory($conn, $categoryId): array
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
                c.id = ?
            GROUP BY 
                e.id, e.name, e.description, e.coverPhoto, c.id, c.name
            ORDER BY e.creationTimestamp DESC";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();

    $events = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }
    }

    return $events;
}
?>