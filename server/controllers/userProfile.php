<?php
session_start();
include '../config.php';
include '../db_connection.php';
include '../models/user.php';

$stylesheet = "user-profile.css";
$script = "user-profile.js";

if (!isset($_SESSION['user_id'])) {
  header('Location: /pages/login.php');
  exit();
}

$userId = $_SESSION['user_id'];

$query = "SELECT * FROM user WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    header('Location: /pages/login.php');
}

$stmt->close();

// php for form submission
$firstName = htmlspecialchars($user['firstName']);
$lastName = htmlspecialchars($user['lastName']);
$email = htmlspecialchars($user['email']);
$dateOfBirth = htmlspecialchars($user['dateOfBirth']);
$profilePicture = htmlspecialchars($user['profilePicture']);


if ($_SERVER['REQUEST_METHOD'] == 'POST'&& isset($_POST['update-profile'])) {
  $firstName = !empty($_POST['firstName']) ? $_POST['firstName'] : $firstName;
  $lastName = !empty($_POST['lastName']) ? $_POST['lastName'] : $lastName;
  $email = !empty($_POST['email']) ? $_POST['email'] : $email;
  $dateOfBirth = !empty($_POST['dateOfBirth']) ? $_POST['dateOfBirth'] : $dateOfBirth;
  $profilePictureName = $profilePicture;
  

  if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] == 0) {
      $targetDir = "../assets/users/";
      $profilePictureName = basename($_FILES["profilePicture"]["name"]);
      $targetFilePath = $targetDir . $profilePictureName;

      if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $targetFilePath)) {
          $profilePicture = $profilePictureName;
      } else {
          echo "Sorry, there was an error uploading your file.";
      }
  }

  $query = "UPDATE user SET firstName = ?, lastName = ?, email = ?, dateOfBirth = ?, profilePicture = ? WHERE id = ?";
  
  $stmt = $conn->prepare($query);
  $stmt->bind_param("sssssi", $firstName, $lastName, $email, $dateOfBirth, $profilePictureName, $userId);
  
  $stmt->execute();
  $stmt->close();

  header("Location: user-profile.php");
  exit();
}
?>