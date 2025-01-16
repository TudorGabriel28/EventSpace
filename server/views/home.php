<?php
include "../controllers/home.php";
include_once '../components/header.php'; ?>
<main>
    <div id="hero-image">
        <h1>Come &<br> Be a part<br> of the family</h1>
    </div>
    <div id="popular-events">
        <h2 class="section-title">Newest Events</h2>
        <div class="event-preview-list">
            <!-- list of events -->
            <?php foreach ($events as $event): ?>
                <?php
                $eventData = ['event' => $event];
                include '../components/event-preview.php';
                ?>
            <?php endforeach; ?>



        </div>
    </div>
    <div id="categories">
        <h2 class="section-title">Browse all the activities</h2>
        <div class="category-list">
            <?php foreach ($categories as $category): ?>
                <a href="specific-category.php?categoryId=<?= htmlspecialchars($category['id']) ?>" class="category-link">
                    <div class="category">
                        <img class="category-image" src="<?= htmlspecialchars($category['photo']) ?>" alt="">
                        <div class="category-title"><?= htmlspecialchars($category['name']) ?></div>
                    </div>
                </a>
            <?php endforeach; ?>

        </div>

    </div>

</main>
<?php include_once '../components/footer.php'; ?>
</body>

</html>