<?php

function getUsers($conn): array {
    try {
        $query = "SELECT id, firstName, lastName, email FROM user";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    } catch (mysqli_sql_exception $e) {
        throw new Exception("Error fetching users: " . $e->getMessage());
    }
}

function getPendingEvents($conn): array {
    try {
        $query = "SELECT id, name, description, coverPhoto FROM event WHERE isApproved = 0";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    } catch (mysqli_sql_exception $e) {
        throw new Exception("Error fetching pending events: " . $e->getMessage());
    }
}

function getApprovedEvents($conn): array {
    try {
        $query = "SELECT id, name, description FROM event WHERE isApproved = 1";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    } catch (mysqli_sql_exception $e) {
        throw new Exception("Error fetching approved events: " . $e->getMessage());
    }
}

function getForumDiscussions($conn): array {
    try {
        $query = "SELECT id, title, question, idUser FROM forumdiscussion";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    } catch (mysqli_sql_exception $e) {
        throw new Exception("Error fetching forums: " . $e->getMessage());
    }
}
?>