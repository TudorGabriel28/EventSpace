<?php
include(__DIR__ . "/../config.php");
include(__DIR__ . "/../db_connection.php");
include(__DIR__ . "/../models/contact.php");

$stylesheet = "contact.css";
$successMessage = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    if (saveContactMessage($conn, $name, $phone, $email, $message)) {
        $successMessage = "Thank you! Your message has been sent successfully.";
    } else {
        $errorMessage = "Oops! Something went wrong. Please try again.";
    }
}
?>