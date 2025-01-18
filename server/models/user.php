<?php
class User {
    public static function getAllUsers($conn) {
        $query = "SELECT id, firstName, lastName, email FROM user";
        $users = [];
        try {
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        } catch (mysqli_sql_exception $e) {
            die("Error fetching users: " . $e->getMessage());
        }
        return $users;
    }
}