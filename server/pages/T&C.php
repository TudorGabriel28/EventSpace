<?php
include '../config.php';
include '../db_connection.php';

// Fetch T&C content from the database
$terms = [];
try {
    $query = "SELECT title, content FROM terms_conditions ORDER BY created_at ASC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $terms[] = $row;
    }
} catch (mysqli_sql_exception $e) {
    die("Error fetching Terms and Conditions: " . $e->getMessage());
}
?>


<?php include_once '../components/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            animation: fadeIn 1.2s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Container for the terms */
        .terms-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .terms-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .terms-container h2 {
            margin-top: 20px;
            color: #ff7f00;
        }

        .terms-container p {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="terms-container">
        <h1>Terms and Conditions</h1>
        <?php if (!empty($terms)): ?>
            <?php foreach ($terms as $term): ?>
                <h2><?php echo htmlspecialchars($term['title']); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($term['content'])); ?></p>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No terms and conditions available at the moment.</p>
        <?php endif; ?>
    </div>
    <?php include_once '../components/footer.php'; ?>
</body>
</html>