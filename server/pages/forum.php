<?php
include '../config.php';
include '../db_connection.php';

$stylesheet = "forum.css";
$script = "forum.js";

// Simulation of a logged in user
$userId = 8;

// Query to obtain all discussions
$sql = "SELECT forumdiscussion.id, forumdiscussion.title, CONCAT(user.firstName, ' ', user.lastName) AS 'User'
        FROM forumdiscussion 
        INNER JOIN user ON forumdiscussion.idUser = user.id";
$result = $conn->query($sql);

$discussions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $discussions[] = $row;
    }
}

// Insert a new discussion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new-discussion'])) {
    $title = $_POST['title'];
    $question = $_POST['question'];
    $sql = "INSERT INTO forumdiscussion (title, question, idUser) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $question, $userId);
    if ($stmt->execute()) {
        $successMessage = "Discussion added successfully!";
        header("Location: forum.php");
        exit();
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
        <p class="text-center">Collaborate, connect and discuss about the upcoming events. See all the discussions...</p>

        <section class="discussions">
            <?php foreach ($discussions as $discussion): ?>
                <a href="discussion.php?id=<?php echo htmlspecialchars($discussion['id']); ?>" class="discussion-link">
                    <div class="discussion-item">
                        <h3><?php echo htmlspecialchars($discussion['title']); ?></h3>
                        <p>Started by: <?php echo htmlspecialchars($discussion['User']); ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
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