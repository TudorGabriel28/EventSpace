<?php
include('../controllers/search.php');
include_once '../components/header.php'; ?>

<main>
    <!-- Header -->
    <div class="header">
        <h1>Search results for '<?= htmlspecialchars($search) ?>'
        </h1>

    </div>

    <!-- Filters Section -->
    <form action="search.php" method="GET">
        <div class="filters-container">
            <!-- Category Filter -->
            <div class="filter">
                <span>Category</span>
                <select name="category">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['id']) ?>" <?= isset($_GET['category']) && $_GET['category'] == $category['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter">
                <span>Start Date</span>
                <input type="date" name="start_date" value="<?= htmlspecialchars($startDate) ?>">
            </div>

            <div class="filter">
                <span>End Date</span>
                <input type="date" name="end_date" value="<?= htmlspecialchars($endDate) ?>">
            </div>

            <div class="filter">
                <span>&nbsp;</span> <!-- Empty span to align the button -->
                <button type="submit" class="btn btn-primary">Apply Filters</button>
            </div>
        </div>
        <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
    </form>


    <div class="event-preview-list">

        <?php foreach ($events as $event): ?>
            <?php
            $eventData = ['event' => $event];
            include '../components/event-preview.php';
            ?>
        <?php endforeach; ?>
        <?php if (empty($events)): ?>
            <div class="no-events">
                <p>No events found!</p>
            </div>
        <?php endif; ?>

</main>
<?php include_once '../components/footer.php'; ?>
</body>

</html>