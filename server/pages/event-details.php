<?php
include '../config.php';
include '../db_connection.php';

$stylesheet = "event-details.css";
$script = "event-details.js";


$eventId = 1;
$userId = 1;


// Query for event name and descrption
$sql = "SELECT name, description, coverPhoto FROM event WHERE id = $eventId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $event = $result->fetch_assoc();
    $eventName = $event['name'];
    $eventDescription = $event['description'];
    $eventImage = $event['coverPhoto'];
} else {
    $eventName = "Event Not Found";
}

// Query for event category
$sql = "SELECT category.name FROM category INNER JOIN eventcategory ON category.id = eventcategory.idCategory WHERE eventcategory.idEvent = $eventId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $category = $result->fetch_assoc();
    $eventCategory = $category['name'];
} else {
    $eventName = 'Category Not Found';
}

// Query for event capacity
$sql = "SELECT capacity FROM planning WHERE planning.idEvent = $eventId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $capacity = $result->fetch_assoc();
    $eventCapacity = $capacity['capacity'];
} else {
    $eventCapacity = 0;
}

// Query for planning details
$sql = "SELECT planning.id AS planningId, location.address, planning.startDate, planning.capacity, planning.price FROM planning INNER JOIN location ON planning.idLocation = location.id WHERE planning.idEvent = $eventId";
$result = $conn->query($sql);

$planningDetails = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $planningDetails[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subscribe'])) {

    $ticketQuantity = intval($_POST['ticket-quantity']);
    $planningId = intval($_POST['event-selector']);

    if (empty($planningId)) {
        echo "Error: Please select a planning.";
        exit;
    }

    // Verify if the capacity is available
    $sql = "SELECT 
    CASE 
        WHEN EXISTS (
            SELECT 1
            FROM UserEventReservation r
            INNER JOIN Planning p ON r.idPlanning = p.id
            WHERE r.idPlanning = ?
            GROUP BY r.idPlanning, p.capacity
            HAVING SUM(r.ticketQuantity) + ? <= p.capacity
        ) THEN TRUE
        ELSE FALSE
    END AS isCapacityAvailable";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $planningId, $ticketQuantity);
    $stmt->execute();
    $stmt->bind_result($isCapacityAvailable);
    $stmt->fetch();
    $stmt->close();
    
    if ($isCapacityAvailable) {
        $sql = "INSERT INTO usereventreservation (ticketquantity, idPlanning, idUser) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $ticketQuantity,  $planningId, $userId);
        if ($stmt->execute()) {
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: Capacity is not available.";
    }
}


$conn->close();
?>




<?php include_once '../components/header.php'; ?>

    <main >
        <div class="event-container">
            <section class="event-header">
                <section class="event-name">
                    <p class="text-xl"><strong><?php echo $eventName;?></strong></p>
                </section>
                <section class="event-image">
                    <img class="image-class" src="<?php echo $eventImage;?>" alt="Event Image">
                </section>
            </section>
            <section class="event-information">
                <section class="event-description">
                    <p class="text-sm"><strong>Category: </strong><span><?php echo $eventCategory;?></span></p>
                    <p class="text-sm"><strong>Description</strong></p>
                    <p class="text-sm"><?php echo $eventDescription;?></p>
                </section>
                <section class="event-subscription">
                    <form method="POST" action="">
                        <div class="event-selector">
                            <p class="text-sm">Select your date and location:</p>
                            <select id="event-selector" name="event-selector" onchange="updateCapacity(); enableSubscribeButton();">
                                <option value disabled selected>Choose one:</option>
                                <?php foreach ($planningDetails as $planning): ?>
                                    <option value="<?php echo htmlspecialchars($planning['planningId']) ?>" data-capacity="<?php echo htmlspecialchars($planning['capacity']); ?>" data-capacity="<?php echo htmlspecialchars($planning['capacity']); ?>" data-price="<?php echo htmlspecialchars($planning['price']); ?>" data-planning-id="<?php echo htmlspecialchars($planning['planningId']); ?>">
                                        <?php echo htmlspecialchars($planning['address']) . ' - ' . htmlspecialchars($planning['startDate']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <section class="event-capacity" id="event-capacity-container" style="display: none;">
                            <p class="text-sm"><strong>Total Capacity: </strong><span id="event-capacity"></span></p>
                        </section>
                        <div class="subscription-details">
                            <div class="ticket-quantity">
                                <p class="text-sm">Number of tickets:</p>
                                <button class="btn" type="button" onclick="document.getElementById('ticket-quantity').stepDown(); updateTotalPrice();">-</button>
                                <input type="number" id="ticket-quantity" name="ticket-quantity" value="1" min="1" max="10" onchange="updateTotalPrice();">
                                <button class="btn" type="button" onclick="document.getElementById('ticket-quantity').stepUp(); updateTotalPrice();">+</button>
                            </div>
                            <div id="total-price">
                                <p class="text-sm">Total price: <span id="event-price"></span></p>
                            </div>
                            <button class="btn" type="submit" name="subscribe" id="subscribe-button">Subscribe event</button>
                        </div>
                    </form>
                    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subscribe']) && empty($_POST['event-selector'])): ?>
                        <p class="error">Please select a planning before subscribing.</p>
                    <?php endif; ?>
                </section>
            </section>
        </div>  
    </main>
    <?php include_once '../components/footer.php'; ?>
</body>
</html>