<?php
include "../controllers/specific-category.php";
include_once '../components/header.php'; ?>
<main>
    <div class="header">
        <h1>Events in <?= htmlspecialchars($categoryName) ?> Category</h1>
    </div>

    <div class="event-preview-list">
        <!-- list of events -->
        <?php foreach ($events as $event): ?>
            <?php
            $eventData = ['event' => $event];
            include '../components/event-preview.php';
            ?>
        <?php endforeach; ?>
    </div>
</main>
<?php include_once '../components/footer.php'; ?>
</body>

</html>