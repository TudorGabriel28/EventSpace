<?php
include '../config.php';
include '../db_connection.php';
include '../models/user.php';

$errorMessage = '';
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $dateOfBirth = $_POST['dateOfBirth'];

    if ($password !== $confirmPassword) {
        $errorMessage = 'Passwords do not match';
    } else {
        $result = registerUser($conn, $firstName, $lastName, $email, $password, $dateOfBirth);

        if ($result['success']) {
            $successMessage = 'Account successfully created';
            header('Location: ../views/login.php');
            exit();
        } else {
            $errorMessage = $result['error'];
        }
    }

}
?>