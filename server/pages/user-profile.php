<?php
include '../config.php';
include '../db_connection.php';

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


$firstName = htmlspecialchars($user['firstName']);
$lastName = htmlspecialchars($user['lastName']);
$email = htmlspecialchars($user['email']);
$dateOfBirth = htmlspecialchars($user['dateOfBirth']);
$profilePicture = htmlspecialchars($user['profilePicture']);


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST'&& isset($_POST['update-profile'])) {
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

// Query for attended events in the past
$sql = "SELECT usereventreservation.id as userreservationid, event.name, planning.startDate, usereventreservation.ticketQuantity, event.id
  FROM event 
  INNER JOIN planning ON event.id = planning.idEvent
  INNER JOIN usereventreservation ON planning.id = usereventreservation.idPlanning
  WHERE usereventreservation.idUser = ? AND planning.startDate < CURDATE()";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$attendedEvents = [];
while ($row = $result->fetch_assoc()) {
    $attendedEvents[] = $row;
}
$stmt->close();

// Query for subsribed events in the future
$sql = "SELECT usereventreservation.id as userreservationid, event.name, planning.startDate, usereventreservation.ticketQuantity, event.id
  FROM event 
  INNER JOIN planning ON event.id = planning.idEvent
  INNER JOIN usereventreservation ON planning.id = usereventreservation.idPlanning
  WHERE usereventreservation.idUser = ? AND planning.startDate >= CURDATE()";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$subscribedEvents = [];
while ($row = $result->fetch_assoc()) {
    $subscribedEvents[] = $row;
}
$stmt->close();

// Query to cancel a reservation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel-reservation'])) {
    $reservationId = $_POST['reservation-id'];
    $sql = "DELETE FROM usereventreservation WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reservationId);
    $stmt->execute();
    $stmt->close();
    header("Location: user-profile.php");
    exit();
}

// Query for waitlisted events
$sql = "SELECT usereventwaitlist.id as userwaitlistid, event.name, planning.startDate, usereventwaitlist.ticketQuantity, event.id
  FROM event 
  INNER JOIN planning ON event.id = planning.idEvent
  INNER JOIN usereventwaitlist ON planning.id = usereventwaitlist.idPlanning
  WHERE usereventwaitlist.idUser = ? AND planning.startDate >= CURDATE()";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$waitlistedEvents = [];
while ($row = $result->fetch_assoc()) {
    $waitlistedEvents[] = $row;
}
$stmt->close();

// Query to leave the waitlist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['leave-waitlist'])) {
  $waitlistId = $_POST['waitlist-id'];
  $sql = "DELETE FROM usereventwaitlist WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $waitlistId);
  $stmt->execute();
  $stmt->close();
  header("Location: user-profile.php");
  exit();
}

// Query for created events

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
          <button id="attended-events-btn">Attended Events</button>
          <button id="subscribed-events-btn">Subscribed Events</button>
          <button id="waitListed-events-btn">Wait Listed Events</button>
          <button id="created-events-btn">Created Events</button>
        </div>
      </div>
      <!-- Popup Windows -->
      <div id="popup-attended" class="popup">
          <div class="popup-content">
              <span class="close-btn">&times;</span>
              <h2>Attended Events</h2>
              <?php if (!empty($attendedEvents)): ?>
                  <table>
                      <thead>
                          <tr>
                              <th>Reservation ID</th>
                              <th>Event Name</th>
                              <th>Start Date</th>
                              <th>Ticket Quantity</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php foreach ($attendedEvents as $event): ?>
                              <tr>
                                  <td><?php echo htmlspecialchars($event['userreservationid']); ?></td>
                                  <td><a href="event-details.php?id=<?php echo htmlspecialchars($event['id']); ?>"><?php echo htmlspecialchars($event['name']); ?></a></td>
                                  <td><?php echo htmlspecialchars($event['startDate']); ?></td>
                                  <td><?php echo htmlspecialchars($event['ticketQuantity']); ?></td>
                              </tr>
                          <?php endforeach; ?>
                      </tbody>
                  <tr>
                  </table>
              <?php else: ?>
                  <p>No attended events found.</p>
              <?php endif; ?>
          </div>
      </div>

      <div id="popup-subscribed" class="popup">
        <div class="popup-content">
          <span class="close-btn">&times;</span>
          <h2>Subcsribed Events</h2>
          <?php if (!empty($subscribedEvents)): ?>
              <table>
                  <thead>
                      <tr>
                          <th>Reservation ID</th>
                          <th>Event Name</th>
                          <th>Start Date</th>
                          <th>Ticket Quantity</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php foreach ($subscribedEvents as $event): ?>
                          <tr>
                              <td><?php echo htmlspecialchars($event['userreservationid']); ?></td>
                              <td><a href="event-details.php?id=<?php echo htmlspecialchars($event['id']); ?>"><?php echo htmlspecialchars($event['name']); ?></a></td>
                              <td><?php echo htmlspecialchars($event['startDate']); ?></td>
                              <td><?php echo htmlspecialchars($event['ticketQuantity']); ?></td>
                              <td>
                              <form method="POST" action="" onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
                                  <input type="hidden" name="reservation-id" value="<?php echo htmlspecialchars($event['userreservationid']); ?>">
                                  <button class="cancel-btn" type="submit" name="cancel-reservation">Unsubscribe event</button>
                              </form>
                              </td>
                          </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>
          <?php else: ?>
              <p>No subscribed events found.</p>
          <?php endif; ?>
        </div>
      </div>

      <div id="popup-waitlisted" class="popup">
        <div class="popup-content">
          <span class="close-btn">&times;</span>
          <h2>Wait Listed Events</h2>
          <?php if (!empty($waitlistedEvents)): ?>
              <table>
                  <thead>
                      <tr>
                          <th>Waitlist ID</th>
                          <th>Event Name</th>
                          <th>Start Date</th>
                          <th>Ticket Quantity</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php foreach ($waitlistedEvents as $event): ?>
                          <tr>
                              <td><?php echo htmlspecialchars($event['userwaitlistid']); ?></td>
                              <td><a href="event-details.php?id=<?php echo htmlspecialchars($event['id']); ?>"><?php echo htmlspecialchars($event['name']); ?></a></td>
                              <td><?php echo htmlspecialchars($event['startDate']); ?></td>
                              <td><?php echo htmlspecialchars($event['ticketQuantity']); ?></td>
                              <td>
                                <form method="POST" action="" onsubmit="return confirm('Are you sure you want to leave the waitlist?');">
                                    <input type="hidden" name="waitlist-id" value="<?php echo htmlspecialchars($event['userwaitlistid']); ?>">
                                    <button class="cancel-btn" type="submit" name="leave-waitlist">Leave waitlist</button>
                                </form>
                              </td>
                          </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>
              <?php else: ?>
                  <p>No events on the waitlist found.</p>
              <?php endif; ?>
        </div>
      </div>

      <div id="popup-created" class="popup">
        <div class="popup-content">
          <span class="close-btn">&times;</span>
          <h2>Created Events</h2>
          <p>Example content for created events...</p>
        </div>
      </div>
      <!-- End of Popup Windows -->
      <div class="personal-info">
        <h2>Personal Information</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="first-name">First Name</label>
              <div class="icon-container">
                <input type="text" id="fname" name="firstName" placeholder="Enter Your First Name" value="<?php echo $firstName; ?>" required disabled>
                <button type="button" class="edit-btn" onclick="toggleEdit('fname')">Edit</button>
              </div>
            </div>
            <div class="form-group">
              <label for="name">Last Name</label>
              <div class="icon-container">
                <input type="text" id="lname" name="lastName" placeholder="Enter Your Last Name" value="<?php echo $lastName; ?>" required disabled>
                <button type="button" class="edit-btn" onclick="toggleEdit('lname')">Edit</button>
              </div>
            </div>
            <div class="form-group">
              <label for="email">E-Mail Address</label>
              <div class="icon-container">
                <input type="email" id="email" name="email" placeholder="Enter Your E-mail" value="<?php echo $email; ?>" required disabled>
                <button type="button" class="edit-btn" onclick="toggleEdit('email')">Edit</button>
              </div>
            </div>
            <div class="form-group">
              <label for="date">Date Of Birth</label>
              <div class="icon-container">
                <input type="date" id="DOB" name="dateOfBirth" value="<?php echo $dateOfBirth; ?>" required disabled>
                <button type="button" class="edit-btn" onclick="toggleEdit('DOB')">Edit</button>
              </div>
            </div>
            <div class="form-group">
                <label for="profilePicture">Picture</label>
                <input type="file" id="profilePicture" name="profilePicture" placeholder="Upload Your Picture">
            </div>
            <button type="submit" name="update-profile" class="save-button">Save Changes</button>
        </form>
      </div>
    </div>
</main>
<?php include_once '../components/footer.php'; ?>
</body>
</html>

