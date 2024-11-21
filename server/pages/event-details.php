<?php
include '../config.php';
include '../db_connection.php';

$eventId = 1;

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


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $eventName?></title>
    <link rel="stylesheet" href="../../styles/event-details.css">
    <link rel="stylesheet" href="../../styles/common.css">
    <script>
        function updateTotalPrice() {
            const select = document.getElementById('event-selector');
            const pricePerTicket = parseFloat(select.options[select.selectedIndex].getAttribute('data-price'));
            const quantity = document.getElementById('ticket-quantity').value;
            const totalPrice = pricePerTicket * quantity;
            document.getElementById('total-price').innerText = `Total Price: ${totalPrice.toFixed(2)} €`;
        }

        let selectedPlanningId = null;

        function updateCapacity() {
            const select = document.getElementById('event-selector');
            const capacity = select.options[select.selectedIndex].getAttribute('data-capacity');
            selectedPlanningId = select.options[select.selectedIndex].getAttribute('data-planning-id');
            document.getElementById('event-capacity').innerText = capacity;
            document.getElementById('event-capacity-container').style.display = 'block';
        }
    </script>
</head>
<body>

    <header>
        <h1>Navigation bar...</h1>
    </header>

    <main >
        <div class="event-container">
            <section class="event-header">
                <section class="event-name">
                    <p class="text-xl"><strong><?php echo $eventName;?></strong></p>
                </section>
                <section class="event-image">
                    <img class="image-class" src="<?php echo $eventImage;?>" alt="Event 1">
                </section>
            </section>
            <section class="event-information">
                <section class="event-description">
                    <p class="text-sm"><strong>Category: </strong><span><?php echo $eventCategory;?></span></p>
                    <p class="text-sm"><strong>Description</strong></p>
                    <p class="text-sm"><?php echo $eventDescription;?></p>
                </section>
                <section class="event-subscription">
                    <div class="event-selector">
                        <p class="text-sm">Select your date and location:</p>
                        <select id="event-selector" onchange="updateCapacity()">
                            <option value disabled selected>Choose one:</option>
                            <?php foreach ($planningDetails as $planning): ?>
                                <option value="<?php echo htmlspecialchars($planning['address']) . '-' . htmlspecialchars($planning['startDate']); ?>" data-capacity="<?php echo htmlspecialchars($planning['capacity']); ?>" data-capacity="<?php echo htmlspecialchars($planning['capacity']); ?>" data-price="<?php echo htmlspecialchars($planning['price']); ?>" data-planning-id="<?php echo htmlspecialchars($planning['planningId']); ?>">
                                    <?php echo htmlspecialchars($planning['address']) . ' - ' . htmlspecialchars($planning['startDate']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <section class="event-capacity" id="event-capacity-container" style="display: none;">
                        <p class="text-sm"><strong>Capacity: </strong><span id="event-capacity"></span></p>
                    </section>
                    <div class="subscription-details">
                        <div class="ticket-quantity">
                            <p class="text-sm">Number of tickets:</p>
                            <button class="btn" onclick="document.getElementById('ticket-quantity').stepDown(); updateTotalPrice();">-</button>
                            <input type="number" id="ticket-quantity" value="1" min="1" max="10" onchange="updateTotalPrice();">
                            <button class="btn" onclick="document.getElementById('ticket-quantity').stepUp(); updateTotalPrice();">+</button>
                        </div>
                        <div id="total-price">
                            <p class="text-sm">Total price: <span id="event-price"></span></p>
                        </div>
                        <button class="btn" onclick="alert('Subscribed!')">Subscribe event</button>
                    </div>
                </section>
            </section>
        </div>  
    </main>

</body>
</html>