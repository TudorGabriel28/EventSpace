<?php
include '../config.php';
include '../db_connection.php';

$stylesheet = "forum.css";
$script = "forum.js";

$forumDiscussionId = 1;
$userId = 1;

// Query to obtain discussion details
$sql = "SELECT forumdiscussion.title, CONCAT(user.firstName, ' ', user.lastName) AS 'User', user.profilePicture, forumdiscussion.question
        FROM forumdiscussion 
        INNER JOIN user ON forumdiscussion.idUser = user.id
        WHERE forumdiscussion.id = $forumDiscussionId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $discussion = $result->fetch_assoc();
    $discussionTitle = $discussion['title'];
    $discussionUser = $discussion['User'];
    $discussionUserProfilePic = $discussion['profilePicture'];
    $discussionContent = $discussion['question'];
} else {
    $discussionTitle = "Discussion Not Found";
    $discussionUser = "";
    $discussionUserProfilePic = "";
    $discussionContent = "";
}

// Query to obtain comments
$sql = "SELECT CONCAT(user.firstName, ' ', user.lastName) AS 'User', user.profilePicture, forumcomment.content
        FROM forumcomment INNER JOIN user ON forumcomment.idUser = user.id
        WHERE forumcomment.idDiscussion = $forumDiscussionId";
$result = $conn->query($sql);

$comments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
}

// Insert a new comment 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $commentContent = $_POST['comment'];
    $sql = "INSERT INTO forumcomment (content, idDiscussion, idUser) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $commentContent, $forumDiscussionId, $userId);
    if ($stmt->execute()) {
        $successMessage = "Comment added successfully!";
    } else {
        $errorMessage = "Error: " . $stmt->error;
    }
    $stmt->close();
}

?>

<?php include_once '../components/header.php'; ?>

<main >
    <div class="forum-container">
        <h1 class="text-center">Forum Page</h1>
        <p class="text-center">Collaborate, connect and discuss about the upcoming event</p>

        <section class="discussion">
            <h2><?php echo htmlspecialchars($discussionTitle); ?></h2>
            <div class="discussion-user">
                <img src="<?php echo htmlspecialchars($discussionUserProfilePic); ?>" alt="Profile Picture" class="profile-pic">
                <p><strong><?php echo htmlspecialchars($discussionUser); ?></strong></p>
            </div>
            <p><?php echo htmlspecialchars($discussionContent); ?></p>
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
</body>
</html>