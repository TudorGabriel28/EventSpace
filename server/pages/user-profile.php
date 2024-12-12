<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/user-profile.css">
    <link rel="stylesheet" href="./styles/common.css">
</head>
  <body>
    <div class="profile-container">
      <div class="profile-header">
        <div class="profile-picture">
          <img id="preview" src="../User-profile-pic.png" alt="User Avatar">
        </div>
        <div class="event-buttons">
          <button>Subscribed Events</button>
          <button>Wait Listed Events</button>
          <button>Previously Attended Events</button>
          <button>Created Events</button>
        </div>
      </div>
  
      <div class="personal-info">
        <h2>Personal Information</h2>
        <form>
          <div class="form-group">
            <label for="first-name">First Name</label>
            <input type="text" id="fname" placeholder="Enter Your First Name">
          </div>
          <div class="form-group">
            <label for="name">Last Name</label>
            <input type="text" id="lname" placeholder="Enter Your Last Name">
          </div>
          <div class="form-group">
            <label for="email">E-Mail Address</label>
            <input type="email" id="email" placeholder="Enter Your E-mail">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" placeholder="Enter Your Password">
          </div>
          <div class="form-group">
            <label for="date">Date Of Birth</label>
            <input type="date" id="DOB">
          </div>
          <div class="form-group">
            <label for="ppicture">Profile Picture</label>
            <input type="file" id="ppicture" placeholder="Upload Your Picture">
          </div>
          <button type="submit" class="save-button">Save Changes</button>
        </form>
      </div>
    </div>
  </body>
</html>

<?php
include '../config.php';
include '../db_connection.php';

$stylesheet = "user-profile.css";

$userId = 1; // Replace with dynamic user ID (e.g., from session or login)

//$stmt = prepare("SELECT * FROM user WHERE id = :id");
//$stmt->execute(['id' => $userId]);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission to update user data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $profilePicture = $_POST['profilePicture'];

    $updateStmt = $pdo->prepare(
        "UPDATE user SET firstName = :firstName, lastName = :lastName, email = :email, 
        dateOfBirth = :dateOfBirth, profilePicture = :profilePicture WHERE id = :id"
    );

    $updateStmt->execute([
        'firstName' => $firstName,
        'lastName' => $lastName,
        'email' => $email,
        'dateOfBirth' => $dateOfBirth,
        'profilePicture' => $profilePicture,
        'id' => $userId
    ]);
}
?>