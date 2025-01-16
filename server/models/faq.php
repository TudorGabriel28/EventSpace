<?php

function getFAQs($conn): array
{
    $query = "SELECT id, question, answer FROM faq";
    $result = $conn->query($query);

    $faqs = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $faqs[] = $row;
        }
    }

    return $faqs;
}
?>