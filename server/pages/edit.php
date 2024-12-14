<?php
include '../config.php';
include '../db_connection.php';

// Fetch query parameters
$type = isset($_GET['type']) ? $_GET['type'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Redirect if no valid type or id is provided
if (empty($type) || $id <= 0) {
    header("Location: admin.php");
    exit();
}

// Fetch existing data
$data = [];
try {
    if ($type === 'user') {
        $query = "SELECT firstName, lastName, email FROM user WHERE id = ?";
    } elseif ($type === 'event') {
        $query = "SELECT name, description FROM event WHERE id = ?";
    } elseif ($type === 'forum') {
        $query = "SELECT title, question FROM forumdiscussion WHERE id = ?";
    } else {
        throw new Exception("Invalid type specified.");
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
} catch (Exception $e) {
    die("Error fetching data: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if ($type === 'user') {
            $query = "UPDATE user SET firstName = ?, lastName = ?, email = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssi", $_POST['firstName'], $_POST['lastName'], $_POST['email'], $id);
        } elseif ($type === 'event') {
            $query = "UPDATE event SET name = ?, description = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssi", $_POST['name'], $_POST['description'], $id);
        } elseif ($type === 'forum') {
            $query = "UPDATE forumdiscussion SET title = ?, question = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssi", $_POST['title'], $_POST['question'], $id);
        } else {
            throw new Exception("Invalid type specified.");
        }

        $stmt->execute();
        header("Location: admin.php");
        exit();
    } catch (Exception $e) {
        die("Error updating data: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit <?php echo ucfirst($type); ?></title>
</head>
<body>
    <h1>Edit <?php echo ucfirst($type); ?></h1>
    <form method="POST">
        <?php if ($type === 'user'): ?>
            <label>First Name: <input type="text" name="firstName" value="<?php echo htmlspecialchars($data['firstName']); ?>" required></label><br>
            <label>Last Name: <input type="text" name="lastName" value="<?php echo htmlspecialchars($data['lastName']); ?>" required></label><br>
            <label>Email: <input type="email" name="email" value="<?php echo htmlspecialchars($data['email']); ?>" required></label><br>
        <?php elseif ($type === 'event'): ?>
            <label>Event Name: <input type="text" name="name" value="<?php echo htmlspecialchars($data['name']); ?>" required></label><br>
            <label>Description: <textarea name="description" required><?php echo htmlspecialchars($data['description']); ?></textarea></label><br>
        <?php elseif ($type === 'forum'): ?>
            <label>Title: <input type="text" name="title" value="<?php echo htmlspecialchars($data['title']); ?>" required></label><br>
            <label>Question: <textarea name="question" required><?php echo htmlspecialchars($data['question']); ?></textarea></label><br>
        <?php endif; ?>
        <button type="submit">Save Changes</button>
        <a href="admin.php">Cancel</a>
    </form>
</body>
</html>
