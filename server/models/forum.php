<?php
function getDiscussions($conn)
{
    $sql = "SELECT forumdiscussion.id, forumdiscussion.title, CONCAT(user.firstName, ' ', user.lastName) AS 'User'
            FROM forumdiscussion 
            INNER JOIN user ON forumdiscussion.idUser = user.id";
    $result = $conn->query($sql);

    $discussions = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $discussions[] = $row;
        }
    }
    return $discussions;
}

function addDiscussion($conn, $title, $question, $userId)
{
    $sql = "INSERT INTO forumdiscussion (title, question, idUser) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $question, $userId);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}

function getAllForums($conn)
{
    $query = "SELECT id, title, question, idUser FROM forumdiscussion";
    $forums = [];
    try {
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $forums[] = $row;
        }
    } catch (mysqli_sql_exception $e) {
        die("Error fetching forums: " . $e->getMessage());
    }
    return $forums;
}
?>