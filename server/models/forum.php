<?php
class Forum {
    public static function getAllForums($conn) {
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
}