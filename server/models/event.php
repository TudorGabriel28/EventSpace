<?php
class Event {
    public static function getPendingEvents($conn) {
        $query = "SELECT id, name, description, coverPhoto FROM event WHERE isApproved = 0";
        return self::fetchEvents($conn, $query);
    }

    public static function getApprovedEvents($conn) {
        $query = "SELECT id, name, description FROM event WHERE isApproved = 1";
        return self::fetchEvents($conn, $query);
    }

    private static function fetchEvents($conn, $query) {
        $events = [];
        try {
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $events[] = $row;
            }
        } catch (mysqli_sql_exception $e) {
            die("Error fetching events: " . $e->getMessage());
        }
        return $events;
    }
}