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
?>