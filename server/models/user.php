<?php

function authenticateUser($conn, $email, $password)
{
    $query = "SELECT id, password FROM user WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            return ['id' => $id];
        }
    }

    return null;
}


function registerUser($conn, $firstName, $lastName, $email, $password, $dateOfBirth)
{
    // Check if email already exists
    $query = "SELECT id FROM user WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        return ['success' => false, 'error' => 'User with this email already exists'];
    }
    $stmt->close();

    // Insert new user
    $query = "INSERT INTO user (firstName, lastName, email, password, dateOfBirth) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bind_param("sssss", $firstName, $lastName, $email, $hashedPassword, $dateOfBirth);

    if ($stmt->execute()) {
        return ['success' => true];
    } else {
        return ['success' => false, 'error' => 'Error: ' . $stmt->error];
    }
}


//User Profile Page
function getUserEvents($conn, $userId)
{
    $events = [];

    // Attended events
    $sql = "SELECT usereventreservation.id as userreservationid, event.name, planning.startDate, usereventreservation.ticketQuantity, event.id FROM event 
            INNER JOIN planning ON event.id = planning.idEvent
            INNER JOIN usereventreservation ON planning.id = usereventreservation.idPlanning
            WHERE usereventreservation.idUser = ? AND planning.startDate < CURDATE()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $events['attendedEvents'] = [];
    while ($row = $result->fetch_assoc()) {
        $events['attendedEvents'][] = $row;
    }
    $stmt->close();

    // Subscribed events
    $sql = "SELECT usereventreservation.id as userreservationid, event.name, planning.startDate, usereventreservation.ticketQuantity, event.id FROM event 
            INNER JOIN planning ON event.id = planning.idEvent
            INNER JOIN usereventreservation ON planning.id = usereventreservation.idPlanning
            WHERE usereventreservation.idUser = ? AND planning.startDate >= CURDATE()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $events['subscribedEvents'] = [];
    while ($row = $result->fetch_assoc()) {
        $events['subscribedEvents'][] = $row;
    }
    $stmt->close();

    // Waitlisted events
    $sql = "SELECT usereventwaitlist.id as userwaitlistid, event.name, planning.startDate, usereventwaitlist.ticketQuantity, event.id FROM event 
            INNER JOIN planning ON event.id = planning.idEvent
            INNER JOIN usereventwaitlist ON planning.id = usereventwaitlist.idPlanning
            WHERE usereventwaitlist.idUser = ? AND planning.startDate >= CURDATE()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $events['waitlistedEvents'] = [];
    while ($row = $result->fetch_assoc()) {
        $events['waitlistedEvents'][] = $row;
    }
    $stmt->close();

    // Created events
    $sql = "SELECT event.id, event.name, MIN(planning.startDate) as startDate, MAX(planning.endDate) as endDate FROM event
            INNER JOIN planning ON event.id = planning.idEvent
            INNER JOIN usereventrole AS role ON role.idUser = ? AND role.idEvent = event.id
            WHERE role.function = 'Host'
            GROUP BY event.id, event.name";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $events['createdEvents'] = [];
    while ($row = $result->fetch_assoc()) {
        $events['createdEvents'][] = $row;
    }
    $stmt->close();

    return $events;
}

function cancelReservation($conn, $reservationId)
{
    $sql = "DELETE FROM usereventreservation WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reservationId);
    $stmt->execute();
    $stmt->close();
}

function leaveWaitlist($conn, $waitlistId)
{
    $sql = "DELETE FROM usereventwaitlist WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $waitlistId);
    $stmt->execute();
    $stmt->close();
}

function deleteEvent($conn, $eventId, $userId)
{
    $sql = "DELETE FROM event WHERE id = ? AND id IN (SELECT idEvent FROM usereventrole WHERE idUser = ? AND function = 'Host')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $eventId, $userId);
    $stmt->execute();
    $stmt->close();
}


function getAllUsers($conn)
{
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
?>