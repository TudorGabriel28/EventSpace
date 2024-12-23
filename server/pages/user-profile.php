<?php
include '../config.php';
include '../db_connection.php';

$stylesheet = "user-profile.css";

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


$firstName = htmlspecialchars($user['firstName']);
$lastName = htmlspecialchars($user['lastName']);
$email = htmlspecialchars($user['email']);
$dateOfBirth = htmlspecialchars($user['dateOfBirth']);
$profilePicture = htmlspecialchars($user['profilePicture']);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $email = $_POST['email'];
  $dateOfBirth = $_POST['dateOfBirth'];
  $profilePictureName = $profilePicture; // Default to existing picture
  
  // Handle file upload
  if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] == 0) {
      $targetDir = "../assets/users/";
      $profilePictureName = $targetDir . basename($_FILES["profilePicture"]["name"]);
      $targetFilePath = $targetDir . $profilePictureName;

      // Move the uploaded file to the target directory
      if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $targetFilePath)) {
          // File successfully uploaded
      } else {
          echo "Sorry, there was an error uploading your file.";
      }
  }

  // Update user information in the database
  $query = "UPDATE user SET firstName = ?, lastName = ?, email = ?, dateOfBirth = ?, profilePicture = ? WHERE id = ?";
  
  $stmt = $conn->prepare($query);
  $stmt->bind_param("sssssi", $firstName, $lastName, $email, $dateOfBirth, $profilePictureName, $userId);
  
  $stmt->execute();
  $stmt->close();

  // Redirect or display a success message
  header("Location: user-profile.php");
  exit();
}

$conn->close();
?>


<?php include_once '../components/header.php'; ?>
<main>
    <div class="profile-container">
      <div class="profile-header">
        <div class="profile-picture">
          <img id="preview" src="<?php echo $profilePicture; ?>" alt="User Avatar">
        </div>
        <div class="event-buttons">
          <button class="btn">Subscribed Events</button>
          <button class="btn">Wait Listed Events</button>
          <button class="btn">Previously Attended Events</button>
          <button class="btn">Created Events</button>
        </div>
      </div>
  
      <div class="personal-info">
        <h2>Personal Information</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="first-name">First Name</label>
                <input type="text" id="fname" name="firstName" placeholder="Enter Your First Name" value="<?php echo $firstName; ?>" required>
            </div>
            <div class="form-group">
                <label for="name">Last Name</label>
                <input type="text" id="lname" name="lastName" placeholder="Enter Your Last Name" value="<?php echo $lastName; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">E-Mail Address</label>
                <input type="email" id="email" name="email" placeholder="Enter Your E-mail" value="<?php echo $email; ?>" required>
            </div>
            <div class="form-group">
                <label for="date">Date Of Birth</label>
                <input type="date" id="DOB" name="dateOfBirth" value="<?php echo $dateOfBirth; ?>" required>
            </div>
            <div class="form-group">
                <label for="profilePicture">Profile Picture</label>
                <input type="file" id="profilePicture" name="profilePicture" placeholder="Upload Your Picture">
            </div>
            <button type="submit" class="save-button">Save Changes</button>
        </form>
      </div>
    </div>
    </main>
<?php include_once '../components/footer.php'; ?>
</body>
</html>

