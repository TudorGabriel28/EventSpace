<?php

function saveContactMessage($conn, $name, $phone, $email, $message): bool
{
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, phone, email, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $phone, $email, $message);

    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

?>