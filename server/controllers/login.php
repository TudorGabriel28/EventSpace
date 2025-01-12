<?php
include '../config.php';
include '../db_connection.php';
include '../models/user.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = authenticateUser($conn, $email, $password);

    if ($user) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        header("Location: ../views/home.php");
        exit();
    } else {
        $error = "Invalid email or password";
        include '../views/login.php';
    }
}
?>