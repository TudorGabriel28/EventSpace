<?php include_once "../controllers/forum.php"; ?>
<?php include_once '../components/header.php'; ?>

<main>
    <div class="forum-container">
        <section class="discussions-header">
            <h1>Forum Page</h1>
            <p>Collaborate, connect and discuss about the upcoming events. See all the discussions...</p>
        </section>

        <section class="discussions">
            <?php if (!empty($discussions)): ?>
                <?php foreach ($discussions as $discussion): ?>
                    <a href="discussion.php?id=<?php echo htmlspecialchars($discussion['id']); ?>" class="discussion-link">
                        <div class="discussion-item">
                            <h3><?php echo htmlspecialchars($discussion['title']); ?></h3>
                            <p>Started by: <?php echo htmlspecialchars($discussion['User']); ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No discussions found.</p>
            <?php endif; ?>
        </section>

        <section class="add-discussion">
            <h2>Do you have any questions? Start your own discussion:</h2>
            <form method="POST" action="">
                <label for="title">Title:</label><br>
                <input type="text" id="title" name="title" required><br>
                <label for="question">Question:</label><br>
                <textarea id="question" name="question" required></textarea><br>
                <button class="btn" type="submit" name="new-discussion">Submit</button>
            </form>
            <?php if (isset($successMessage)): ?>
                <p class="success" style="color: green;"><?php echo $successMessage; ?></p>
            <?php endif; ?>
            <?php if (isset($errorMessage)): ?>
                <p class="error" style="color: red;"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php include_once '../components/footer.php'; ?>
</body>
</html>