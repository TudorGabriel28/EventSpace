<?php
session_start();
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

$sql = "SELECT usereventreservation.id as userreservationid, event.name, planning.startDate, usereventreservation.ticketQuantity, event.id FROM event 
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


$sql = "SELECT usereventreservation.id as userreservationid, event.name, planning.startDate, usereventreservation.ticketQuantity, event.id FROM event 
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


$sql = "SELECT usereventwaitlist.id as userwaitlistid, event.name, planning.startDate, usereventwaitlist.ticketQuantity, event.id FROM event 
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


$sql = "SELECT event.id, event.name, MIN(planning.startDate) as startDate, MAX(planning.endDate) as endDate FROM event
        INNER JOIN planning ON event.id = planning.idEvent
        INNER JOIN usereventrole AS role ON role.idUser = ? AND role.idEvent = event.id
        WHERE role.function = 'Host'
        GROUP BY event.id, event.name";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$createdEvents = [];
while ($row = $result->fetch_assoc()) {
    $createdEvents[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete-event'])) {
  $eventId = $_POST['event-id'];
  $sql = "DELETE FROM event WHERE id = ? AND id IN (SELECT idEvent FROM usereventrole WHERE idUser = ? AND function = 'Host')";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $eventId, $userId);
  $stmt->execute();
  $stmt->close();
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
        <img id="preview" src="<?php echo "../assets/users/" .  $profilePicture . '?' . time(); ?>" alt="User Avatar">
        </div>
        <div class="event-buttons">
          <button id="attended-events-btn">Attended Events</button>
          <button id="subscribed-events-btn">Subscribed Events</button>
          <button id="waitListed-events-btn">Wait Listed Events</button>
          <button id="created-events-btn">Created Events</button>
        </div>
      </div>
<!-- Popup Functionality -->
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
          <h2>Subscribed Events</h2>
          <?php if (!empty($subscribedEvents)): ?>
              <table>
                  <thead>
                      <tr>
                          <th>Reservation ID</th>
                          <th>Event Name</th>
                          <th>Start Date</th>
                          <th>Ticket Quantity</th>
                          <th>Actions</th>
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
                          <th>Actions</th>
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
        <?php if (!empty($createdEvents)): ?>
        <table>
            <thead>
                <tr>
                    <th>Event ID</th>
                    <th>Event Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($createdEvents as $event): ?>
                <tr>
                    <td><?php echo htmlspecialchars($event['id']); ?></td>
                    <td><a href="event-details.php?id=<?php echo htmlspecialchars($event['id']); ?>"><?php echo htmlspecialchars($event['name']); ?></a></td>
                    <td><?php echo htmlspecialchars($event['startDate']); ?></td>
                    <td><?php echo htmlspecialchars($event['endDate']); ?></td>
                    <td>
                        <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this event?');">
                            <input type="hidden" name="event-id" value="<?php echo htmlspecialchars($event['id']); ?>">
                            <button class="cancel-btn" type="submit" name="delete-event">Delete Event</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>User has not hosted an event.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Form Section -->
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
                <div class="icon-container">
                    <input type="file" id="profilePicture" name="profilePicture" placeholder="Upload Your Picture" disabled>
                    <button type="button" class="edit-btn" onclick="toggleEdit('profilePicture')">Edit</button>
                </div>
            </div>
            <button type="submit" name="update-profile" class="save-button">Save Changes</button>
        </form>
      </div>
    </div>
</main>
<?php include_once '../components/footer.php'; ?>
</body>
</html>

