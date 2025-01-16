<?php include_once "../controllers/discussion.php"; ?>
<?php include_once '../components/header.php'; ?>

<main>
    <div class="forum-container">
        <section class="discussion">
            <h2><?php echo htmlspecialchars($discussion['title']); ?></h2>
            <div class="discussion-user">
                <img src="<?php echo htmlspecialchars($discussion['profilePicture']); ?>" alt="Profile Picture" class="profile-pic">
                <p><strong><?php echo htmlspecialchars($discussion['User']); ?></strong></p>
            </div>
            <p><?php echo htmlspecialchars($discussion['question']); ?></p>
        </section>

        <section class="comments">
            <h3>Comments</h3>
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <div class="comment-user">
                        <img src="<?php echo htmlspecialchars($comment['profilePicture']); ?>" alt="Profile Picture" class="profile-pic">
                        <p><strong><?php echo htmlspecialchars($comment['User']); ?>:</strong></p>
                    </div>    
                    <p><?php echo htmlspecialchars($comment['content']); ?></p>
                </div>
            <?php endforeach; ?>
        </section>

        <section class="add-comment">
            <form method="POST" action="">
                <label for="comment">Comment:</label><br>
                <textarea id="comment" name="comment" required></textarea>
                <button class="btn" style="align-self:flex-end" type="submit">Submit</button>
            </form>
        </section>
    </div>
</main>

<?php include_once '../components/footer.php'; ?>