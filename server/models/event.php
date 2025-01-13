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

function getEventData($conn, $eventId): array {
    $sql = "SELECT name, description, coverPhoto FROM event WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc() ?: ["name" => "Event Not Found", "description" => "", "coverPhoto" => ""];
}

function getPlanningDetails($conn, $eventId): array {
    $sql = "SELECT p.id AS planningId, l.address, p.startDate, p.capacity, p.price 
            FROM planning p 
            INNER JOIN location l ON p.idLocation = l.id 
            WHERE p.idEvent = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $result = $stmt->get_result();
    $details = [];
    while ($row = $result->fetch_assoc()) {
        $details[] = $row;
    }
    return $details;
}

function handleSubscription($conn, $postData, $userId, $joinWaitlist = false): array {
    $planningId = intval($postData['event-selector'] ?? 0);
    $ticketQuantity = intval($postData['ticket-quantity'] ?? 1);
    $errorMessage = '';
    $subscriptionSuccess = false;
    $showWaitlistButton = false;

    if ($planningId === 0) {
        return ["Error: Please select a planning.", false, false];
    }

    // Verificar disponibilidad
    $sql = "SELECT capacity - IFNULL(SUM(ticketQuantity), 0) AS ticketsRemaining 
            FROM planning p 
            LEFT JOIN UserEventReservation r ON p.id = r.idPlanning 
            WHERE p.id = ? GROUP BY p.id";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $planningId);
    $stmt->execute();
    $ticketsRemaining = 0;
    $stmt->bind_result($ticketsRemaining);
    $stmt->fetch();
    $stmt->close();

    if ($ticketsRemaining >= $ticketQuantity) {
        // Realizar la reserva
        $sql = "INSERT INTO UserEventReservation (ticketQuantity, idPlanning, idUser) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $ticketQuantity, $planningId, $userId);
        $subscriptionSuccess = $stmt->execute();
        $stmt->close();
        return [$subscriptionSuccess ? '' : "Error: Could not complete subscription.", $subscriptionSuccess, false];
    } elseif ($joinWaitlist) {
        // Agregar a la lista de espera
        $sql = "INSERT INTO UserEventWaitlist (ticketQuantity, idUser, idPlanning) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $ticketQuantity, $userId, $planningId);
        $waitlistSuccess = $stmt->execute();
        $stmt->close();

        if ($waitlistSuccess) {
            return ["You have been added to the waitlist.", false, true];
        } else {
            return ["Error: Could not add to waitlist.", false, false];
        }
    } else {
        // Mostrar botón de lista de espera
        return ["Error: Capacity is not available.", false, true];
    }
}


?>