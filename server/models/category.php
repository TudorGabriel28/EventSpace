<?php

function getCategories($conn): array {
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
?>
