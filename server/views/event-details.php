<?php include "../controllers/event-details.php"; ?>
<?php include_once '../components/header.php'; ?>

<main>
    <div class="event-container">
        <section class="event-header">
            <div class="event-name">
                <p class="text-xl"><strong><?= htmlspecialchars($eventData['name']); ?></strong></p>
            </div>
            <div class="event-image">
                <img class="image-class" src="<?= htmlspecialchars($eventData['coverPhoto']); ?>" alt="Event Image">
            </div>
        </section>

        <section class="event-information">
            <section class="event-description">
                    <p class="text-sm"><strong>Description: </strong><?= htmlspecialchars($eventData['description']); ?></p>
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
                        <?php if (!isset($showWaitlistButton) || !$showWaitlistButton): ?>
                            <button class="btn" type="submit" name="subscribe">Subscribe</button>
                        <?php else: ?>
                            <button class="btn" type="submit" name="join-waitlist" onclick="alert('You have joined the waitlist!');">Join Waitlist</button>
                        <?php endif; ?>

                    </div>
                </form>
            </section>
        </section>
    </div>
</main>

<?php include_once '../components/footer.php'; ?>
<?php if (isset($subscriptionSuccess) && $subscriptionSuccess): ?>
    <script>
        alert('You have successfully subscribed to the event!');
    </script>
<?php endif; ?>

</body>
</html>