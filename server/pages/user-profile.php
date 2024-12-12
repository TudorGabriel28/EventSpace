<?php
include '../config.php';
include '../db_connection.php';

$stylesheet = "user-profile.css";

$userId = 1; // Replace with dynamic user ID (e.g., from session or login)

//$stmt = prepare("SELECT * FROM user WHERE id = :id");
//$stmt->execute(['id' => $userId]);


// Fetch user data
$query = "SELECT * FROM user WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    // Redirect to login page if user not found
    header('Location: /pages/login.php');
}

$stmt->close();


$firstName = htmlspecialchars($user['firstName']);
$lastName = htmlspecialchars($user['lastName']);
$email = htmlspecialchars($user['email']);
$dateOfBirth = htmlspecialchars($user['dateOfBirth']);
$profilePicture = htmlspecialchars($user['profilePicture']);



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

$conn->close();
?>


<?php include_once '../components/header.php'; ?>
<main>
    <div class="profile-container">
      <div class="profile-header">
        <div class="profile-picture">
          <img id="preview" src="$profilePicture" alt="User Avatar">
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

