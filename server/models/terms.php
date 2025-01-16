<?php

function getTermsAndConditions($conn): array
{
    $query = "SELECT title, content FROM terms_conditions ORDER BY created_at ASC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    $terms = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $terms[] = $row;
        }
    }

    return $terms;
}

?>