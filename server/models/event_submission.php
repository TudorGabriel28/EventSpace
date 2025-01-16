<?php
function insertEvent($conn, $event_name, $description, $cover_photo): int {
    $sql = "INSERT INTO event (name, description, coverPhoto, isApproved) VALUES (?, ?, ?, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $event_name, $description, $cover_photo);
    $stmt->execute();
    return $stmt->insert_id;
}

function insertEventCategory($conn, $event_id, $category): void {
    $sql = "INSERT INTO eventcategory (idEvent, idCategory) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $event_id, $category);
    $stmt->execute();
}

function insertLocation($conn, $address, $city, $postalCode): int {
    $sql = "INSERT INTO location (address, city, postalCode) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $address, $city, $postalCode);
    $stmt->execute();
    return $stmt->insert_id;
}

function insertPlanning($conn, $startDate, $endDate, $capacity, $price, $event_id, $location_id): void {
    $sql = "INSERT INTO planning (startDate, endDate, capacity, price, idEvent, idLocation) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiiii", $startDate, $endDate, $capacity, $price, $event_id, $location_id);
    $stmt->execute();
}
?>
