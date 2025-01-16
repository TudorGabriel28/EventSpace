<?php
function getLegalNotices($conn): array {
    $query = "SELECT title, content FROM legal_notice ORDER BY id ASC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $legal_notices = [];
    while ($row = $result->fetch_assoc()) {
        $legal_notices[] = $row;
    }
    return $legal_notices;
}
?>
